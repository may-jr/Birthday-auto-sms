<?php
// This is the sigup database

    // Include the connection file
    require "connection.php";

    // Check if the 'signup' form has been submitted
    if(isset($_POST['signup'])){
        // Sanitize and escape user input
        $fname = mysqli_real_escape_string($my_connection, $_POST['name']);
        $mail = mysqli_real_escape_string($my_connection, $_POST['email']);
        $passd = mysqli_real_escape_string($my_connection, $_POST['password']);
        $con_passd = mysqli_real_escape_string($my_connection, $_POST['confirm_password']);

        // SQL query to check if the username or email already exists
        $compare = "SELECT * FROM clients WHERE FULLNAME = '$uname' OR Email = '$mail'";

        // Execute the query
        $check = mysqli_query($my_connection, $compare);

        // Check if a matching username or email is found in the database
        if(mysqli_num_rows($check) > 0){
            echo "<script> alert('Username or Email has already been taken');window.location.href='../HTML/login.html'; </script>";
        }
        else{
            // Check if the entered passwords match
            if($passd == $con_passd){
                // Insert user data into the 'signup' table
                $data = "INSERT INTO clients (FULLNAME, Email, Password, Confirm_Password) VALUES('$fname','$uname', '$mail' ,'$passd', '$con_passd')";
                mysqli_query($my_connection, $data);
                echo "<script> alert('Registered successfully'); 
                window.location.href='../pages/dashboard.html';</script>";
            }
            else{
                echo "<script> alert('Password does not Match');
                window.location.href='../pages/registration.html'</script>";
            };
        };
    }
?>