<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'birthday_wishing_system';
$username = 'root';
$password = '';

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Both email and password are required.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id, email, password, full_name FROM users WHERE email = :email";

        try {
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':email', $email);

            // Execute the prepared statement
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                // Fetch the row
                $row = $stmt->fetch();
                
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    // Password is correct, start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["full_name"] = $row['full_name'];
                    
                    // Redirect user to welcome page
                    header("location: welcome.php");
                } else {
                    // Password is not valid
                    echo "Invalid email or password.";
                }
            } else {
                // No account found with that email
                echo "Invalid email or password.";
            }
        } catch(PDOException $e) {
            die("ERROR: Could not execute query. " . $e->getMessage());
        }
    }
}
?>