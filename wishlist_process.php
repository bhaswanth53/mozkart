<?php
    session_start();
    require "local.php";
    require "check.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        if ( isset($_POST['submit'] ) ) {
            $wishlist_name = protect($con, $_POST['wishlist_name']);
            $sql = "INSERT INTO `wishlist` (`w_id`, `wishlist`, `user_email`) VALUES (NULL, '$wishlist_name', '$session_mail');";
            if(mysqli_query($con, $sql)) {
                header("location: wishlist.php");
            }
            else {
                die(mysqli_error($con));
            }
        }
        else {
            header("location: wishlist.php");
        }
    }
?>