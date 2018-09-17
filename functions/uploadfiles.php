<?php
    session_start();
    include("../config/setup.php");

    $filename =  $_FILES['capturedImage']['name'];
    $temp_location =  $_FILES['capturedImage']['tmp_name'];
    $newName = $_SESSION["uid"]."_".time().".png";
    
    
    if(move_uploaded_file($temp_location, "../uploads/$newName"))
    {
        $superposable_image = json_decode($_POST['image'], true);

        $capturedImage = imagecreatefrompng("../uploads/$newName");
        $s_image = imagecreatefrompng($superposable_image['url']);
        imagealphablending($capturedImage, true);
        imagesavealpha($capturedImage, true);
        imagecopy($capturedImage, $s_image, 0, 0, 0, 0, $superposable_image['w'], $superposable_image['h']);
        imagepng($capturedImage, "../uploads/$newName");
        imagedestroy($capturedImage);
        imagedestroy($s_image);
        
        $sql = "INSERT INTO photos(uid, url) VALUES(:uid, :url)";
        $stmt = $db->prepare($sql);
        $stmt->execute(["uid" => $_SESSION['uid'], "url" => "uploads/$newName"]);
        echo json_encode(array("status" => "OK", "url" => "uploads/$newName", "image" => $superposable_image['url']));
    }else{
        echo json_encode(array("status" => "KO"));
    }
?>