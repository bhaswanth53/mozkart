<?php
    session_start();
    require "local.php";
    require "check.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        if ( isset( $_POST['update_profile'] ) ) {
            $name = protect($con, $_POST['name']);
            $mobile = protect($con, $_POST['mobile']);
      
            $address = serialize($_POST['address']);

            $check = mysqli_query($con, "SELECT * FROM user WHERE email = '$session_mail'");
            if(mysqli_num_rows($check) > 0) {
                $ins = "UPDATE user SET username = '$name', mobile = '$mobile', address = '$address' WHERE email = '$session_mail'";
                if(mysqli_query($con, $ins)) {
                    header("location: account.php");
                }
                else {
                    die(mysqli_error($con));
                }
            }
            else {
                die("User doesn't exist");
            }
        }
    }
?>