<?php
// This is the authentication script for signup and login

// Start session and include the connection file
session_start();
require_once "connection.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the 'register' form has been submitted
if(isset($_POST['action']) && $_POST['action'] == 'register'){
    // Sanitize and escape user input
    $username = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required'); window.location.href='register.php';</script>";
        exit();
    }

    if($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href='register.php';</script>";
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location.href='register.php';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to check if the username or email already exists
    $compare = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $compare);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a matching username or email is found in the database
    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('Username or Email has already been taken'); window.location.href='register.php';</script>";
    }
    else{
        // Insert user data into the 'users' table
        $data = "INSERT INTO users (username, email, password) VALUES(?, ?, ?)";
        $stmt = mysqli_prepare($conn, $data);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
        
        if(mysqli_stmt_execute($stmt)){
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['username'] = $username;
            echo "<script>alert('Registered successfully'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location.href='register.php';</script>";
        }
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}

// Check if the 'login' form has been submitted
if(isset($_POST['action']) && $_POST['action'] == 'login'){
    // Sanitize and escape user input
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    // Validate input
    if(empty($email) || empty($password)) {
        echo "<script>alert('Email and password are required'); window.location.href='login.php';</script>";
        exit();
    }

    // SQL query to check if the email exists
    $query = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Update last login time
            $update_query = "UPDATE users SET last_login = NOW() WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, "i", $user['id']);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);

            echo "<script>alert('Login successful'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='login.php';</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>