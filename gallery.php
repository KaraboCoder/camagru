<?php
    session_start();
    include("config/setup.php");

    $images= array();

    function count_comments($photoid, $dbHandle)
    {
        $sql = "SELECT * FROM comments WHERE photoid = ?";
        $stmt = $dbHandle->prepare($sql);
        $stmt->execute([$photoid]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($comments);
    }

    function count_likes($photoid, $dbHandle)
    {
        $sql = "SELECT * FROM likes WHERE photoid = ?";
        $stmt = $dbHandle->prepare($sql);
        $stmt->execute([$photoid]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($comments);
    }

    if (isset($_SESSION['email']) && isset($_SESSION['username']) && isset($_SESSION['uid']))
    {
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM photos";
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
            <p><a href="editor.php">Editor</a></p>
        </div>
        <div class="gallery-content">
        <?php
                foreach($images as $image)
                {
                    echo "<div class='gallery-image-wrapper'>";
                    echo "<div class='gallery-image-link'>";
                    echo "<img class='gallery-image' src='".$image[url]."'>";
                    echo "</div>";
                    echo "<div class='gallery-controls'>";
                    echo "<p class='view-comments' data-photoid='".$image['photoid']."' data-uid='".$image['uid']."'>comments (".count_comments($image['photoid'], $db).")</p>";
                    echo "<p class='likes' data-photoid='".$image['photoid']."' data-uid='".$image['uid']."'>likes (".count_likes($image['photoid'], $db).")</p>";
                    echo "</div></div>";
                }
            ?>
        </div>
        <script src="js/gallery.js"></script>
    </body>
</html>