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

// Function to safely redirect
function redirect($url) {
    header("Location: $url");
    exit();
}

// Registration Process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'register') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, full_name) VALUES (:username, :email, :password, :full_name)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $email,
                ':email' => $email,
                ':password' => $hashed_password,
                ':full_name' => $name
            ]);
            
            $_SESSION['success'] = "Registration successful! Please log in.";
            redirect("../php/dashboard.php"); // Redirect to login page after successful registration
        } catch(PDOException $e) {
            $_SESSION['error'] = "Registration failed. Please try again.";
        }
    }
    redirect("../pages/registration.php"); // Redirect back to registration page if there was an error
}

// Login Process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Both email and password are required.";
    } else {
        $sql = "SELECT id, email, password, full_name FROM users WHERE email = :email";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch();
                if (password_verify($password, $row['password'])) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["full_name"] = $row['full_name'];
                    
                    redirect("../pages/dashboard.php"); // Redirect to dashboard after successful login
                } else {
                    $_SESSION['error'] = "Invalid email or password.";
                }
            } else {
                $_SESSION['error'] = "Invalid email or password.";
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = "Login failed. Please try again.";
        }
    }
    redirect("../pages/registration.html"); // Redirect back to login page if there was an error
}

// If no POST request, redirect to the registration page
redirect("../pages/registration.html");
?>