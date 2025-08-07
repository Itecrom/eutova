<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'eutova_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

mysqli_set_charset($conn, "utf8mb4");

?>