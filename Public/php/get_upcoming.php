<?php
require_once 'connection.php';

// Check if the connection is established
if (!isset($my_connection)) {
    die(json_encode(['success' => false, 'error' => 'Database connection not established.']));
}

$today = date('Y-m-d');
$thirtyDaysLater = date('Y-m-d', strtotime('+30 days'));

$query = "SELECT name, date, phone FROM birthdays 
          WHERE DATE_FORMAT(date, '%m-%d') BETWEEN DATE_FORMAT('$today', '%m-%d') 
          AND DATE_FORMAT('$thirtyDaysLater', '%m-%d')
          ORDER BY DATE_FORMAT(date, '%m-%d') ASC
          LIMIT 5";

$result = $my_connection->query($query);

if ($result) {
    $upcomingBirthdays = [];
    while ($row = $result->fetch_assoc()) {
        $upcomingBirthdays[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $upcomingBirthdays]);
} else {
    echo json_encode(['success' => false, 'error' => $my_connection->error]);
}

$my_connection->close();
?>