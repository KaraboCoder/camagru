<?php
    session_start();
    include("config/setup.php");

    $comments = array();

    if (isset($_SESSION['email']) && isset($_SESSION['username']) && isset($_SESSION['uid']))
    {
        $username = $_SESSION['username'];
        $uid = $_SESSION['uid'];
        if (isset($_POST['comment']) && isset($_POST['submit']) && isset($_GET["photoid"]))
        {
            $sql = "INSERT INTO comments(photoid, username, comment) VALUES(:photoid, :username, :comment)";
            $stmt = $db->prepare($sql);
            $stmt->execute(["photoid" => $_GET['photoid'], "username" => $username, "comment" => $_POST['comment']]);
        }
        $sql = "SELECT * FROM comments WHERE photoid = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_GET["photoid"]]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="comments-content">
        <?php
                foreach($comments as $comment)
                {
                    echo "<div class='comment-wrapper'>";
                    echo "<div class='author'>";
                    echo "<p>By: ".$comment['username']."</p>";
                    echo "<p>Posted: ".$comment['timestamp']."</p>";
                    echo "</div>";
                    echo "<div class='comment'>";
                    echo "<p>".$comment['comment']."</p>";
                    echo "</div></div>";
                }
            ?>
        </div>
        <div class="comment-form-wrapper">
            <form action="" method="post" id="comments-form">
                <input type="text" name="comment" id="comment-input">
                <input type="submit" name="submit" value="comment">
            </form>
        </div>
        <script src="js/comments.js"></script>
    </body>
</html>