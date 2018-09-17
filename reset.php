<?php
/**
 * Created by PhpStorm.
 * User: kngwato
 * Date: 2017/10/28
 * Time: 10:18 AM
 */

include("config/setup.php");
$token =  $_GET['t'];//token



if (isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_POST['email']))
{
    ###################################
    #                                 #
    #       RESET PASSWORD            #
    #                                 #
    ###################################
    if (($_POST['password'] != "") && ($_POST['confirmPassword'] != "") && ($_POST['email'] != ""))
    {
        if ($_POST['password'] != $_POST['confirmPassword'])
        {
            echo "<p style='color:red;'>Passwords do not match.</p>";
        }else{
                   #VALIDATE PASSWORD
        if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST['password']) === 0)
        {
            echo "<p style='color:red;'>Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit</p>";            
            
        }else{
            $newPassword = hash("whirlpool", $_POST['password']);
            $sql = "UPDATE users SET password = :newPassword WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->execute(["newPassword" => $newPassword, "email" => $_POST['email']]);
            echo "<p style='color:green;'>Your password reset was successful. You can now <a href='index.php'>Login</a> here.</p>";
            exit();
        }
        }
    }else{
        echo "<p style='color:red;'>Could not process your request.</p>";
        exit();
    }

}else{
    $sql = "SELECT * FROM reset_tokens WHERE token = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($token));
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($user) == 1)
    {
        foreach ($user as $u)
        {
            $email = $u['email'];
        }
    }
    else
    {
        echo "<p style='color:red;'>ERROR: Something went wrong.</p>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru - Reset Password</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div id="resetPassword-container">
        <form id="resetPasswordForm" action="" method="post">
            <input type="password" name="password" placeholder="Enter Password">
            <input type="password" name="confirmPassword" placeholder="Confirm Password">
            <input type="hidden" name="email" value=<?php echo "$email"?>>
            <input type="submit" value="reset">
        </form>
    </div>
</body>
</html>
