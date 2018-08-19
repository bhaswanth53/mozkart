<?php
    ob_start();
    session_start();
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
    if ( !empty( $_SESSION['email'] ) ) {
        $session_mail = $_SESSION['email'];
        $sql = "SELECT * FROM user WHERE email = '$session_mail'";
        $query = mysqli_query($con, $sql);
        $user_data = mysqli_fetch_assoc($query);
        $forgot_status = $user_data['forgot'];
        if ($forgot_status != 2) {
            header('location: logout.php');
        }
        else {
            if( isset($_POST['submit'] ) ) {
                $password = protect($con, $_POST['password']);
                $confirm_password = protect($con, $_POST['confirm_password']);
                if($password == $confirm_password) {
                    $password = md5($password);
                    $update_password = mysqli_query($con,"UPDATE user SET password = '$password' WHERE email = '$session_mail'");
                    $update_status = mysqli_query($con,"UPDATE user SET forgot = '0' WHERE email = '$session_mail'");
                    $name = "Mozkart";
                    $html = "
                        <h3 style='text-align: center'>Your password has been reset! Please login to continue...</h3>
                    ";
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPSecure = 'tls';
                    $mail->SMTPAuth = true;
                    $mail->Username = EMAIL;
                    $mail->Password = PASS;
                    $mail->setFrom(EMAIL, $name);
                    $mail->addAddress($session_mail, 'User');
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset';
                    $mail->Body = $html;
                    $mail->send();
                    header('location: logout.php');
                }
                else {
                    die("passwords didn't match");
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