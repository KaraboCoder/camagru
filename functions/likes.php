<?php
    include("../config/setup.php");


    function count_likes($photoid, $dbHandle)
    {
        $sql = "SELECT * FROM likes WHERE photoid = ?";
        $stmt = $dbHandle->prepare($sql);
        $stmt->execute([$photoid]);
        $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($likes);
    }
    
    function user_exists($uid, $photoid, $dbHandle){
        $sql = "SELECT * FROM likes WHERE uid = ? AND photoid = ? LIMIT 1";
        $stmt = $dbHandle->prepare($sql);
        $stmt->execute([$uid, $photoid]);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($user) == 1)
            return (true);
        else
            return (false);
    }

    function add_likes($uid, $photoid, $dbHandle)
    {
        $sql = "INSERT INTO likes(uid, photoid) VALUES(:uid, :photoid)";
        $stmt = $dbHandle->prepare($sql);
        $stmt->execute(["uid" => $uid, "photoid" => $photoid]);
        echo json_encode(array("status" => "OK", "action" => "likes","count" => count_likes($photoid, $dbHandle)));
    }

    function remove_likes($uid, $photoid, $dbHandle)
    {
        $sql = "DELETE FROM likes WHERE uid = ? AND photoid = ?";
        $stmt = $dbHandle->prepare($sql);
        $stmt->execute([$uid, $photoid]);
        echo json_encode(array("status" => "OK", "action" => "likes","count" => count_likes($photoid, $dbHandle)));
    }

    //if (user_exists($_GET['uid'], $_GET['photoid'], $db))
    //{
     //   remove_likes($_GET['uid'], $_GET['photoid'], $db);
   // }else{
        add_likes($_GET['uid'], $_GET['photoid'], $db);
    //}
?>