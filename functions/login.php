<?php
session_start();
include("../config/setup.php");

function login_user($email, $password, $dbHandle){
    $password = hash("whirlpool", $password);
    $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
    $stmt = $dbHandle->prepare($sql);
    $stmt->execute([$email, $password]);
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header("Content-Type: application/json");
    if(count($user) == 1)
    {
        foreach ($user as $u)
        {
            if ($u['verified'] == 0)
            {
                echo json_encode(array("status" => "KO", "msg" => "Email not verified."));
                exit();
            }
            $_SESSION['email'] = $u['email'];
            $_SESSION['uid'] = $u['uid'];
            $_SESSION['username'] = $u['username'];
        }
        echo json_encode(array("status" => "OK", "location" => "editor.php"));

    }
    else
        echo json_encode(array("status" => "KO", "msg" => "Email or password incorrect."));
}

#######################################
#                                     #
#         HANDLE LOGIN                #
#                                     #
#######################################

if (isset($_POST["action"]) && $_POST["action"] == "login")
{
    login_user($_POST['email'], $_POST['password'], $db);
}

?>
