<?php
require_once 'connection.php';

// Check if the connection is established
if (!isset($my_connection)) {
    die(json_encode(['success' => false, 'error' => 'Database connection not established.']));
}

// Get the raw POST data
$rawData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($rawData, true);

// Check if JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(['success' => false, 'error' => 'Invalid JSON data']));
}

// Check if required data is present
if (!isset($data['name']) || !isset($data['date']) || !isset($data['phone'])) {
    die(json_encode(['success' => false, 'error' => 'Name and date are required']));
}

$name = $my_connection->real_escape_string($data['name']);
$date = $my_connection->real_escape_string($data['date']);
$phone = $my_connection->real_escape_string($data['phone']);

$query = "INSERT INTO birthdays (name, date, phone) VALUES ('$name', '$date', '$phone')";

if ($my_connection->query($query) === TRUE) {
    echo json_encode(['success' => true, 'id' => $my_connection->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $my_connection->error]);
}

$my_connection->close();
?>