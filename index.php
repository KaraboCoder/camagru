<?php
session_start();
include("config/setup.php");
if (isset($_SESSION['email']) && isset($_SESSION['uid']) && isset($_SESSION['username']))
{
    header("Location: editor.php");
}
if (isset($_GET['error']))
    switch ($_GET['error'])
    {
        case "0":
            $error = "You need to login first.";
        break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru - Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color:rgba(0,0,0,0.5);">

<div id="error-container">
    <p class="error"><?php echo $error?></p>
</div>

<div id="loginForm-container">
    <h3>Login</h3>
    <form id="loginForm">
        <input type="email" name="email" id="email" placeholder="Email">
        <input type="password" name="password" id="password" placeholder="Password">
    </form>
    <button onclick="loginUser()">Login</button>
    <p><a href="#" id="forgot-password-link">Forgot Password</a></p>
    <p>Don't have an account? <a href="#" id="signup-link">Signup here!</a></p>
</div>

<div id="signupForm-container" class="hide">
    <h3>Signup</h3>
    <form id="signupForm">
        <input type="email" name="email" id="email" placeholder="Email">
        <input type="text" name="username" id="username" placeholder="Username">
        <input type="password" name="password" id="password" placeholder="Password">
        <input type="password" name="verify_password" id="verify-password" placeholder="Confirm Password">
    </form>
    <button onclick="signupUser()">Sign up</button>
    <p>Already have an account? <a href="#" id="login-link">Login here!</a></p>
</div>

<div id="forgotPassword-container" class="hide">
    <h3>Reset Password</h3>
    <form id="fogortPasswordForm">
        <input type="email" name="email" id="forgot-password-email" placeholder="Email">
    </form>
    <button onclick="sendResetPasswordLink()">Send Reset Link</button>
    <p><a href="#" id="back-link">Back</a></p>
</div>
    <script src="js/ajax.js"></script>
    <script src="js/index.js"></script>
</body>
</html>