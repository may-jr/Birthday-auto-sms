<?php
require_once 'connection.php';

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$date = $data['date'];

$stmt = $pdo->prepare("INSERT INTO birthdays (name, date) VALUES (?, ?)");
$stmt->execute([$name, $date]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
?>