<?php
    ob_start();
    session_start();
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
    if( isset ($_POST['submit'] ) ) {
        $email = protect($con, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        if( empty( $email ) ) {
            die("Please enter your email address");
        }
        else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            die("Please enter a valid email_address");
        }
        else {
            $sql = "SELECT * FROM `user` WHERE email = '$email'";
            $query = mysqli_query($con, $sql);
            $numrows = mysqli_num_rows($query);
            if($numrows > 0) {
                $_SESSION['email'] = $_POST['email'];
                header('location: verify_otp.php');
            }
            else {
                die("Email didn't registered yet! Please register");
            }
        }
    }
    else {
        header('location: index.php');
    }
?>