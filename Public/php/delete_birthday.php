<?php
require_once 'connection.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];

$stmt = $pdo->prepare("DELETE FROM birthdays WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['success' => true]);
?>