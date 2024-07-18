<?php
header('Content-Type: application/json');

$db = new mysqli('localhost', 'username', 'password', 'database_name');
$result = $db->query("SELECT name, birth_date FROM birthdays");

$birthdays = [];
while ($row = $result->fetch_assoc()) {
    $birthdays[] = $row;
}

echo json_encode($birthdays);
