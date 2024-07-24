<?php
session_start();
require "connection.php";

if(isset($_POST['login'])){
    $name = mysqli_real_escape_string($my_connection, $_POST['email']);
    $pass = mysqli_real_escape_string($my_connection, $_POST['password']);

    $query = "SELECT * FROM clients WHERE FULLNAME = '$name' OR Email = '$name'";
    $result = mysqli_query($my_connection, $query);

    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        if($pass == $row["Password"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: ../pages/dashboard.html"); // Redirect to homepage after successful login
            exit();
        } else {
            echo "<script> alert('Wrong Password');
            window.location.href='../pages/registration.html'; </script>";
        }
    } else {
        echo "<script> alert('User not registered');
        window.location.href='../pages/registration.html'; </script>";
    }
}
?>
