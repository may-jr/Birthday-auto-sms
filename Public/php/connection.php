<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "AUTO_BIRTHDAY_WHISH";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>