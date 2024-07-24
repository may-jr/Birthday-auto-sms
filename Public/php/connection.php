<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "AUTO_BIRTHDAY_WHISH";

// Create connection
$my_connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$my_connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>