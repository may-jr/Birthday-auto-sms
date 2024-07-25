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
if (!isset($data['id']) || !isset($data['name']) || !isset($data['date']) || !isset($data['phone'])) {
    die(json_encode(['success' => false, 'error' => 'ID, name, and date are required']));
}

$id = intval($data['id']); // Ensure id is an integer
$name = $my_connection->real_escape_string($data['name']);
$date = $my_connection->real_escape_string($data['date']);
$phone = $my_connection->real_escape_string($data['phone']);

$query = "UPDATE birthdays SET name = '$name', date = '$date', phone ='$phone' WHERE id = $id";

// Log the query for debugging
error_log("Update Query: " . $query);

if ($my_connection->query($query) === TRUE) {
    if ($my_connection->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Birthday updated successfully']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No birthday found with the given ID or no changes made', 'query' => $query]);
    }
} else {
    echo json_encode(['success' => false, 'error' => $my_connection->error, 'query' => $query]);
}

$my_connection->close();
?>