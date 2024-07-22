<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "birthday_wishing_system";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>