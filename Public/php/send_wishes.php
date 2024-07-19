<?php
$db = new mysqli('localhost', 'username', 'password', 'database_name');

$today = date('m-d');
$result = $db->query("SELECT name, phone_number FROM birthdays WHERE DATE_FORMAT(birth_date, '%m-%d') = '$today'");

while ($row = $result->fetch_assoc()) {
    $message = "Happy Birthday, {$row['name']}! Have a great day!";
    sendSMS($row['phone_number'], $message);
}

function sendSMS($to, $message)
{
    // Implement SMS sending using your chosen gateway
}
