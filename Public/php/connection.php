<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "birthday_wishing_system";

// establishing connection
$conn = new mysqli($host, $user, $pass, $db);
// checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>