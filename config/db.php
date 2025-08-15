<?php
// config/db.php
$host = 'localhost';
$db   = 'citiguard';
$user = 'root';
$pass = 'Denis55522';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
