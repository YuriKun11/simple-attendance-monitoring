<?php
    $servername = "mysql_db";
    $username = "root";
    $password = "root";
    $db = "attendance_system";
    
    $conn = new mysqli($servername, $username, $password, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>