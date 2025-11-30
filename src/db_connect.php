<?php
$servername = "mysql_db"; 
$username = "root";       
$password = "root";        
$dbname = "touride";      

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
