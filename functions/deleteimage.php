<?php
    include("../config/setup.php");
    $sql = "DELETE FROM photos WHERE url = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['url']]);
    echo json_encode(array("status" => "OK"));

?>