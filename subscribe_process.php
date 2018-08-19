<?php
    ob_start();
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
    if ( isset( $_POST['submit'] ) ) {
        $subscriber_email = protect($con, $_POST['email']);
        if ( empty( $subscriber_email) ) {
            die("Email shouldn't be empty");
        }
        $check = "SELECT * FROM `subscribers` WHERE subscriber_email = '$subscriber_email'";
        $result = mysqli_query($con, $check);
        $numrows = mysqli_num_rows($result);
        if ($numrows == 0) {
            $sql = "INSERT INTO `subscribers` (`id`, `subscriber_email`) VALUES (NULL, '$subscriber_email');";
            if(mysqli_query($con, $sql)) {
                //header("Location: " . $_SERVER["HTTP_REFERER"] ."?subscribed=true");
                $name = "Mozkart";
                $html = "
                    <h1 style='text-align: center'>Thank you for supporting us!</h1>
                    <p style='text-align:center'>You have been successfully subscribed to our newsletter</p>
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
                $mail->addAddress($subscriber_email, 'User');
                $mail->isHTML(true);
                $mail->Subject = 'SUBSCRIBE NEWSLETTER';
                $mail->Body = $html;
                $mail->send();
                echo "<script>
                    alert('Subscribed Successfully');
                    window.location.href=window.history.back();
                    </script>";
            }
            else {
                die(mysqli_error($con));
            }
        }
        else {
            echo "<script>
            alert('Already Subscribed!');
            window.location.href=window.history.back();
            </script>";
        }
    }
    else {
        
    }
?>