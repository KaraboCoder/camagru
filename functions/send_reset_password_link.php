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

function send_reset_password_link($email, $token){
    $headers = 'From: noreply@camagru.io' . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n".'X-Mailer: PHP/' . phpversion();
    mail($email,"Camagru:Reset Password Link", "
        <p>Hi</p>
        <p>Click the following link to reset your password. <a href='http://localhost:8080/camagru/reset.php?t=$token'>Reset Password</a> </p>
        <p><strong>If you did not request for a reset password link, ignore this message.</strong></p>
        <br><br>
        <p>Regards<br>Camagru Team</p>
    ", $headers);
}

#######################################
#                                     #
#      SEND RESET PASSWORD LINK       #
#                                     #
#######################################

if(isset($_POST['action']) && $_POST['action'] == "reset_link")
{
    if (user_exists($_POST["email"], $db) == false)
    {
        echo json_encode(array("status" => "KO", "msg" => "No such user."));
    }
    else
    {
        #################################
        #                               #
        #     GENERATE RESET TOKEN      #
        #                               #
        #################################
        $token = hash("whirlpool", time());
        $sql = "INSERT INTO reset_tokens(email, token) VALUES(:email, :token)";
        $stmt = $db->prepare($sql);
        $stmt->execute(["email" => $_POST["email"], "token" => $token]);
        send_reset_password_link($_POST['email'], $token);
        echo json_encode(array("status" => "OK", "msg" => "Password reset link sent to ".$_POST['email']));
    }
}