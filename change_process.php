<?php
    ob_start();
    session_start();
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        if ( isset( $_POST['change_password'] ) ) {
            $current_password = protect($con, $_POST['current_password']);
            $new_password = protect($con, $_POST['new_password']);
            $confirm_password = protect($con, $_POST['confirm_password']);
            $check = mysqli_query($con, "SELECT * FROM `user` WHERE email = '$session_mail'");
            $user = mysqli_fetch_assoc($check);
            $numrows = mysqli_num_rows($check);
            if($numrows > 0) {
                $password = $user['password'];
                if(md5($current_password) == $password) {
                    $new_password = md5($new_password);
                    $update_password = mysqli_query($con,"UPDATE user SET password = '$new_password' WHERE email = '$session_mail'");
                    $name = "Mozkart";
                    $html = "
                        <h3 style='text-align: center'>Your password has been changed! Please login to continue...</h3>
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
                    $mail->Subject = 'Password changed';
                    $mail->Body = $html;
                    $mail->send();
                    echo "<script>
                        alert('Password changed successfully!');
                        window.location.href='account.php';
                        </script>";
                }
                else {
                    die("Current password is wrong!");
                }
            }
            else {
                die("User doesn't exist");
            }
        }
        else {
            header('location: index.php');
        }
    }
    else {
        header('location: index.php');
    }
?>