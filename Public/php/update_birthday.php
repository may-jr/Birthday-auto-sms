<?php
require_once 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$name = $data['name'];
$date = $data['date'];

$stmt = $pdo->prepare("UPDATE birthdays SET name = ?, date = ? WHERE id = ?");
$stmt->execute([$name, $date, $id]);

echo json_encode(['success' => true]);
?>