<?php
// booking_process.php
session_start();
header('Content-Type: application/json; charset=utf-8'); 
require_once '../db_connect.php'; 

if (!isset($conn) || !$conn) {
    $resp = ['success' => false, 'message' => 'Database connection not found.'];
    echo json_encode($resp);
    exit;
}

function send_response($data, $isAjax) {
    if ($isAjax) {
        echo json_encode($data);
        exit;
    } else {
        $_SESSION['booking_flash'] = $data;
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        header("Location: $redirect");
        exit;
    }
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_response(['success' => false, 'message' => 'Invalid request method.'], $isAjax);
}

if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) { 
    send_response(['success' => false, 'message' => 'User not authenticated. Please log in to book a ride.'], $isAjax);
}

$pickup      = isset($_POST['pickup']) ? trim($_POST['pickup']) : '';
$destination = isset($_POST['destination']) ? trim($_POST['destination']) : '';
$date        = isset($_POST['date']) ? trim($_POST['date']) : '';
$time        = isset($_POST['time']) ? trim($_POST['time']) : '';
$passengers  = isset($_POST['passengers']) ? trim($_POST['passengers']) : '';
$transport   = isset($_POST['transport_mode']) ? trim($_POST['transport_mode']) : '';

$errors = [];

if ($pickup === '') $errors[] = 'Pickup location is required.';
if ($destination === '') $errors[] = 'Destination is required.';
if ($date === '') $errors[] = 'Pickup date is required.';
if ($time === '') $errors[] = 'Pickup time is required.';
if ($transport === '') $errors[] = 'Transport mode is required.';

$allowed_destinations = [
    'Ma-Cho Temple','Saint William the Hermit Cathedral','Pindangan Ruins',
    'Pagoda Hill','Poro Point Lighthouse','SM City La Union','Urbiztondo Beach','Tangadan Falls'
];
if ($destination !== '' && !in_array($destination, $allowed_destinations, true)) {
    $errors[] = 'Invalid destination selected.';
}

$allowed_transports = ['motor','tricycle','jeep','taxi','van','bus'];
if ($transport !== '' && !in_array($transport, $allowed_transports, true)) {
    $errors[] = 'Invalid transport mode selected.';
}

$today = date('Y-m-d');
if ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $errors[] = 'Invalid date format.';
} elseif ($date < $today) {
    $errors[] = 'Pickup date cannot be in the past.';
}

if ($time !== '' && !preg_match('/^\d{2}:\d{2}$/', $time)) {
    $errors[] = 'Invalid time format.';
}

$passenger_value = 1;
if ($passengers === '4+' || strtolower($passengers) === '4+') {
    $passenger_value = 4;
} else {
    if (preg_match('/^(\d+)/', $passengers, $m)) {
        $passenger_value = (int)$m[1];
        if ($passenger_value <= 0) $passenger_value = 1;
    } else {
        $passenger_value = 1; 
    }
}

if (!empty($errors)) {
    send_response(['success' => false, 'message' => 'Validation failed.', 'errors' => $errors], $isAjax);
}

$distance_map = [
    'Ma-Cho Temple' => 3.5,
    'Saint William the Hermit Cathedral' => 1.2,
    'Pindangan Ruins' => 2.8,
    'Pagoda Hill' => 4.0,
    'Poro Point Lighthouse' => 9.0,
    'SM City La Union' => 2.2,
    'Urbiztondo Beach' => 15.0,
    'Tangadan Falls' => 38.0
];

$distance_km = isset($distance_map[$destination]) ? (float)$distance_map[$destination] : 10.0;

$speed_map = [
    'motor' => 40,
    'tricycle' => 30,
    'jeep' => 35,
    'taxi' => 45,
    'van' => 60,
    'bus' => 70
];
$avg_speed = isset($speed_map[$transport]) ? $speed_map[$transport] : 40;
$time_hours = $distance_km / max($avg_speed, 1);
$time_minutes = (int)round($time_hours * 60);

$fare_model = [
    'motor' => ['base' => 50, 'per_km' => 12, 'per_passenger' => 0],
    'tricycle' => ['base' => 60, 'per_km' => 15, 'per_passenger' => 0],
    'jeep' => ['base' => 30, 'per_km' => 8,  'per_passenger' => 15], 
    'taxi' => ['base' => 100,'per_km' => 18, 'per_passenger' => 0],
    'van' => ['base' => 180,'per_km' => 20, 'per_passenger' => 0],
    'bus' => ['base' => 120,'per_km' => 10, 'per_passenger' => 25]
];

$model = $fare_model[$transport];
$fare = $model['base'] + ($model['per_km'] * $distance_km);
if ($model['per_passenger'] > 0) {
    $fare += $model['per_passenger'] * $passenger_value;
}

if ($passenger_value >= 6 && in_array($transport, ['van','bus'])) {
    $fare *= 0.92; 
}

$fare = round($fare, 2);

$user_id = (int)$_SESSION['user_id']; 

$sql = "INSERT INTO ride_bookings (user_id, pickup_location, destination, pickup_date, pickup_time, passengers, transport_mode, fare_estimate, created_at)
        VALUES (?,?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    send_response(['success' => false, 'message' => 'Failed to prepare database statement: ' . mysqli_error($conn)], $isAjax);
}

$passenger_label = $passengers;

mysqli_stmt_bind_param($stmt, 'issssssd', $user_id, $pickup, $destination, $date, $time, $passenger_label, $transport, $fare);

$exec = mysqli_stmt_execute($stmt);
if (!$exec) {
    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    send_response(['success' => false, 'message' => 'Database insert error: ' . $err], $isAjax);
}

$insert_id = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

$response = [
    'success' => true,
    'message' => 'Booking created successfully.',
    'booking_id' => $insert_id,
    'data' => [
        'pickup' => $pickup,
        'destination' => $destination,
        'date' => $date,
        'time' => $time,
        'passengers' => $passenger_label,
        'transport_mode' => $transport,
        'distance_km' => $distance_km,
        'est_travel_minutes' => $time_minutes,
        'fare_estimate' => number_format($fare, 2, '.', '')
    ]
];

send_response($response, $isAjax);