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

// Check if the id is present
if (!isset($data['id'])) {
    die(json_encode(['success' => false, 'error' => 'ID is required']));
}

$id = intval($data['id']); // Ensure id is an integer

$query = "DELETE FROM birthdays WHERE id = $id";

if ($my_connection->query($query) === TRUE) {
    if ($my_connection->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No birthday found with the given ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => $my_connection->error]);
}

$my_connection->close();
?>