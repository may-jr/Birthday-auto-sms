<?php
require_once 'connection.php';

$stmt = $pdo->query("SELECT * FROM birthdays ORDER BY date");
$birthdays = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($birthdays);
?>