<?php
include("../config/setup.php");

function user_exists($email, $dbHandle){
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $dbHandle->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($user) == 1)
        return (true);
    else
        return (false);
}

function send_verification_link($email, $username){
    $headers = 'From: noreply@ira.io' . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n".'X-Mailer: PHP/' . phpversion();
    mail($email,"Camagru:Verification Link", "
        <h1>Hi $username</h1>
        <p>Thanks for creating an account at Camagru, We welcome you.</p>
        <p>Click the following link to verify your email:<a href='http://e4r13p1.wethinkcode.co.za:8080/camagru/verify_email.php?email=$email'>Verify</a> </p>
        <p><strong>Do not reply to this email.</strong></p>
        <br><br>
        <p>Regards<br>Camagru Team</p>
    ", $headers);
}

#######################################
#                                     #
#         HANDLE SIGNUP               #
#                                     #
#######################################

function signup_user($email, $password, $username, $dbHandler)
{
    if (empty($email) || empty($password) || empty($username))
        echo json_encode(array("status" => "KO", "msg" => "Error signing up, please check if all inputs are valid."));
    else
    {
        #VALIDATE EMAIL
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            echo json_encode(array("status" => "KO", "msg" => "Email badly formatted."));            
            exit();
        }

        #VALIDATE PASSWORD
        if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0)
        {
            echo json_encode(array("status" => "KO", "msg" => "Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit"));            
            exit();
        }
        $password = hash("whirlpool", $password);
        $sql = "INSERT INTO users(username, email, password) VALUES(:username, :email, :password)";
        $stmt = $dbHandler->prepare($sql);
        $stmt->execute(["username" => $username, "email" => $email, "password" => $password]);
        send_verification_link($email, $username);
        echo json_encode(array("status" => "OK", "msg" => "Account created successfully, verify account to login.<br>Verification link sent to your email."));
    }
}

if(isset($_POST['action']) && $_POST['action'] == "signup")
{
    if (user_exists($_POST["email"], $db) == true)
        echo json_encode(array("status" => "KO", "msg" => "Email already in use."));
    else
    {
        signup_user($_POST['email'], $_POST['password'], $_POST['username'], $db);
    }
}