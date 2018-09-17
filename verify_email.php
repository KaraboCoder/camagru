<?php
/**
 * Created by PhpStorm.
 * User: kngwato
 * Date: 2017/10/26
 * Time: 11:30 PM
 */
include("config/setup.php");

$email = $_GET['email'];

$verification = 1;

$sql = "UPDATE users SET verified = :verification WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->execute(["verification" => $verification, "email" => $email]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru - Verify Email</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color:rgba(0,0,0,0.5);">
    <p>Your email is successfully verified. Click this link to <a href='http://localhost:8080/camagru/index.php'>Login</a></p>
</body>
</html>
