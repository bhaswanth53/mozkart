<?php
    require "local.php";
    require "check.php";
    if( isset( $_POST['submit'] ) ) {
        $color_code = protect($con, $_POST['color']);
        $check = mysqli_query($con, "SELECT * FROM `colors` WHERE color_code = '$color_code'");
        $numrows = mysqli_num_rows($check);
        if($numrows == 0) {
            $sql = "INSERT INTO `colors` (`id`, `color_code`) VALUES (NULL, '$color_code');";
            $insert = mysqli_query($con, $sql);
            header('location: colors.php');
        }
        else {
            die('Color already exists!');
        }
    }
    else {
        header('location: colors.php');
    }
?>