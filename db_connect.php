<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "SchoolDB";
$port = 3307; // your MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
