<?php
session_start();
require '../php/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/2efc16a506.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/register.css">
    <title>Login & Registration Form</title>
</head>

<body>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p class="error">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p class="success">' . htmlspecialchars($_SESSION['success']) . '</p>';
        unset($_SESSION['success']);
    }
    ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="../php/process.php" method="post">
                <input type="hidden" name="action" value="register">
                <h1>Register With</h1>
                <div class="social-icons">
                    <a href="#" class="icon" title="google"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon" title="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon" title="github"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon" title="linkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <hr>
                <h1>OR</h1>
                <hr>
                <span>Fill Out The Following Info For Registration</span>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" id="pass" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirm_pass" placeholder="Confirm Password" required>
                <span id="wrong_pass_alert"></span>
                <button type="submit" id="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="../php/process.php" method="post">
                <input type="hidden" name="action" value="login">
                <h1>Login</h1>
                <hr>
                <hr>
                <span>Login With Your Email & Password</span>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your login details</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello</h1>
                    <p>Register to use all features in our site</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../Js/register-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>