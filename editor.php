<?php
/**
 * Created by PhpStorm.
 * User: kngwato
 * Date: 2017/10/26
 * Time: 7:09 PM
 */

session_start();
include("config/setup.php");
$images= array();
if (isset($_SESSION['email']) && isset($_SESSION['username']) && isset($_SESSION['uid']))
{
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM photos WHERE uid = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION["uid"]]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else
    header("Location: index.php?error=0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css">
    <title>Camagru - <?php echo $username?></title>
</head>
    <body style="background-color:rgba(0,0,0,0.5);">
    <div class="top-nav">
        <p><a href="logout.php">Logout(<?php echo $username?>)</a></p>
        <p><a href="gallery.php">Gallery</a></p>
    </div>
    <div id="content">
        <div id="cam-container">
            <div id="cam-wrapper">
                <video autoplay id="cam" width="200" height="200"></video>
            </div>
            <button id="capture" disabled="true">Capture</button>
            <div class="superposable-images">
                <img class="s-image" src="images/blake.png" data-url="../images/blake.png">
                <img class="s-image" src="images/fred.png" data-url="../images/fred.png">
                <img class="s-image" src="images/scooby.png" data-url="../images/scooby.png">
                <img class="s-image" src="images/scooby_and_shaggy.png" data-url="../images/scooby_and_shaggy.png">
            </div>
        </div>
        <div id="canvas-container" style="display:none;">
            <canvas id="canvas" width="200" height="200"></canvas>
        </div>
        <div id="side-bar">
            <?php
                foreach($images as $image)
                {
                    echo "<div class'side-bar-link-container'>";
                    echo "<div class='side-bar-link'>";
                    echo "<img class='side-bar-img' src='".$image[url]."'>";
                    echo "</div>";
                    echo "<button class='delete-btn' data-url='".$image['url']."'>Delete</button>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
    <form></form>
    <form></form>
    </body>
    <script src="js/editor.js"></script>
</html>
