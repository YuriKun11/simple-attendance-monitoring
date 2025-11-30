<?php
session_start();
header('Content-Type: application/json');

include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$spot_id = filter_input(INPUT_POST, 'spot_id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

if ($spot_id === false || $spot_id === null || !in_array($action, ['add', 'remove'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

if ($action === 'add') {
    $sql = "INSERT INTO user_favorites (user_id, spot_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $spot_id);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Spot added to favorites']);
    } else {
        if (mysqli_errno($conn) == 1062) {
            echo json_encode(['success' => true, 'message' => 'Favorite already exists']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    }
    mysqli_stmt_close($stmt);
} elseif ($action === 'remove') {
    $sql = "DELETE FROM user_favorites WHERE user_id = ? AND spot_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $spot_id);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Spot removed from favorites']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>