<?php
// show errors while developing
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection settings
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'schooldb';
$port = 3307; // your MySQL port

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
