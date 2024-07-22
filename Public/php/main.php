<?php
// This is the signup database

// Include the connection file
require "connection.php";

// Check if the 'signup' form has been submitted
if(isset($_POST['signup'])){
    // Sanitize and escape user input
    $fname = mysqli_real_escape_string($my_connection, trim($_POST['fullname']));
    $uname = mysqli_real_escape_string($my_connection, trim($_POST['username']));
    $mail = mysqli_real_escape_string($my_connection, trim($_POST['email']));
    $passd = mysqli_real_escape_string($my_connection, $_POST['pass']);
    $con_passd = mysqli_real_escape_string($my_connection, $_POST['con_password']);

    // Validate input
    if(empty($fname) || empty($uname) || empty($mail) || empty($passd) || empty($con_passd)) {
        echo "<script>alert('All fields are required'); window.location.href='../HTML/login.html';</script>";
        exit();
    }

    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location.href='../HTML/login.html';</script>";
        exit();
    }

    // SQL query to check if the username or email already exists
    $compare = "SELECT * FROM signup WHERE Username = ? OR Email = ?";
    $stmt = mysqli_prepare($my_connection, $compare);
    mysqli_stmt_bind_param($stmt, "ss", $uname, $mail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a matching username or email is found in the database
    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('Username or Email has already been taken'); window.location.href='../HTML/login.html';</script>";
    }
    else{
        // Check if the entered passwords match
        if($passd == $con_passd){
            // Hash the password
            $hashed_password = password_hash($passd, PASSWORD_DEFAULT);

            // Insert user data into the 'signup' table
            $data = "INSERT INTO signup (Fullname, Username, Email, Password) VALUES(?, ?, ?, ?)";
            $stmt = mysqli_prepare($my_connection, $data);
            mysqli_stmt_bind_param($stmt, "ssss", $fname, $uname, $mail, $hashed_password);
            
            if(mysqli_stmt_execute($stmt)){
                echo "<script>alert('Registered successfully'); window.location.href='../HTML/Booking.html';</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.'); window.location.href='../HTML/login.html';</script>";
            }
        }
        else{
            echo "<script>alert('Passwords do not match'); window.location.href='../HTML/login.html';</script>";
        }
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($my_connection);
?>