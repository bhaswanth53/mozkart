<?php
    session_start();
    require "local.php";
    require "check.php";
    if( !empty($_SESSION['email'] ) ) {
        $session_mail = $_SESSION['email'];
        $sql = "SELECT * FROM user WHERE email = '$session_mail'";
        $query = mysqli_query($con, $sql);
        $user_data = mysqli_fetch_assoc($query);
        $forgot_status = $user_data['forgot'];
        if ($forgot_status != 1) {
            header('location: index.php');
        }
        else {
            if ( isset($_POST['submit'] ) ) {
                $sent_otp = protect($con, $_POST['sent_otp']);
                $otp = protect($con, $_POST['otp']);
                $otp = protect($con, md5(base64_encode($otp)));
                if($sent_otp == $otp) {
                    $update_status = mysqli_query($con,"UPDATE user SET forgot = '2' WHERE email = '$session_mail'");
                    header('location: reset_password.php');
                }
                else {
                    die("Wrong OTP");
                }
            }
            else {
                header('location: logout.php');
            }
        }
    }
    else {
        header('location: index.php');
    }
?>