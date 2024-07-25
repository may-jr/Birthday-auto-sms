<?php
require_once 'connection.php';

// Check if the connection is established
if (!isset($my_connection)) {
    die(json_encode(['success' => false, 'error' => 'Database connection not established.']));
}

$query = "SELECT name, date, message FROM wishes ORDER BY date DESC LIMIT 5";

$result = $my_connection->query($query);

if ($result) {
    $recentWishes = [];
    while ($row = $result->fetch_assoc()) {
        $recentWishes[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $recentWishes]);
} else {
    echo json_encode(['success' => false, 'error' => $my_connection->error]);
}

$my_connection->close();
?>