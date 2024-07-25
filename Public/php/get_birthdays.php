<?php
require_once 'connection.php';

// Assuming connection.php creates a mysqli connection named $conn
if (!isset($my_connection)) {
    die("Database connection not established. Check your connection.php file.");
}

$result = $my_connection->query("SELECT * FROM birthdays ORDER BY date");

if ($result) {
    $birthdays = [];
    while ($row = $result->fetch_assoc()) {
        $birthdays[] = $row;
    }
    echo json_encode($birthdays);
} else {
    echo json_encode(["error" => "Failed to fetch birthdays: " . $my_connection->error]);
}

$my_connection->close();
?>