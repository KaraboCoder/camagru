<?php
/**
 * Created by PhpStorm.
 * User: kngwato
 * Date: 2017/10/27
 * Time: 12:18 AM
 */
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['username']) && isset($_SESSION['uid']))
{
    session_destroy();    
    header("Location: index.php");
}
else
    header("Location: index.php?error=0");