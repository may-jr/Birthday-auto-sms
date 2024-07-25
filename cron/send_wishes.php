<?php
require_once './Public/php/connection.php';

// Check if the connection is established
if (!isset($my_connection)) {
    die("Database connection not established.");
}

// Set the API key and Sender ID
$api_key = '3w72C56POeMmp07tBxyVzS2Wj';
$sender_id = 'Page1Salon';

// Get today's date
$today = date('Y-m-d');

// Query to get birthdays for today
$query = "SELECT * FROM birthdays WHERE DATE_FORMAT(date, '%m-%d') = DATE_FORMAT('$today', '%m-%d')";
$result = $my_connection->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $phone = $row['phone']; // Assuming you have a 'phone' column in your 'birthdays' table

        // Compose the message
        $message = urlencode("Happy birthday, $name! Wishing you a fantastic day filled with joy and celebration.");

        // Construct the API URL
        $url = "https://apps.mnotify.net/smsapi?key=$api_key&to=$phone&msg=$message&sender_id=$sender_id";

        // Send the request
        $response = file_get_contents($url);

        // Parse the response
        $response_code = intval($response);

        // Log the result
        $log_message = date('Y-m-d H:i:s') . " - Sent wish to $name ($phone): ";
        switch ($response_code) {
            case 1000:
                $log_message .= "Success";
                break;
            case 1002:
                $log_message .= "SMS sending failed";
                break;
            case 1003:
                $log_message .= "Insufficient balance";
                break;
            case 1004:
                $log_message .= "Invalid API key";
                break;
            case 1005:
                $log_message .= "Invalid phone number";
                break;
            case 1006:
                $log_message .= "Invalid Sender ID";
                break;
            case 1008:
                $log_message .= "Empty message";
                break;
            case 1011:
                $log_message .= "Numeric Sender IDs are not allowed";
                break;
            case 1012:
                $log_message .= "Sender ID is not registered";
                break;
            default:
                $log_message .= "Unknown error (Code: $response_code)";
        }
        error_log($log_message . "\n", 3, "birthday_wishes.log");
    }
    echo "Birthday wishes sent successfully!";
} else {
    echo "Error fetching birthdays: " . $my_connection->error;
}

$my_connection->close();
?>