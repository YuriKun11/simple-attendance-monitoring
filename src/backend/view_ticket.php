<?php
session_start();
require '../db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? null;

if (!$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Missing booking ID']);
    exit;
}

$sql = "SELECT * FROM ride_bookings WHERE booking_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $booking_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
  
    if ($row['status'] !== 'finished' && $row['status'] !== 'cancelled') {
        
        $current_datetime = date('Y-m-d H:i:s');
        $pickup_datetime = $row['pickup_date'] . ' ' . $row['pickup_time'];

        if (strtotime($pickup_datetime) < strtotime($current_datetime)) {
            $row['status'] = 'finished'; 
        } elseif (date('Y-m-d', strtotime($row['pickup_date'])) == date('Y-m-d')) {
            $row['status'] = 'ongoing';
        } 
    }
    echo json_encode(['success' => true, 'ticket' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ticket not found']);
}
?>