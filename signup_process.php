<?php
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
    if(isset ( $_POST['signup'] ) ) {
        $username = protect($con, filter_var($_POST['username'], FILTER_SANITIZE_STRING));
        $email = protect($con, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $mobile = protect($con, $_POST['mobile']);
        $password = protect($con, $_POST['password']);
        $confirm_password = protect($con, $_POST['confirm_password']);

        if ( empty ( $username ) ) {
            die("Username shouldn't be empty");
        }
        else if ( empty( $email ) ) {
            die("Email shouldn't be empty");
        }
        else if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			die('Email is not valid! Please enter valid email address...');
        }
        else if ( empty( $mobile ) ) {
            die("Mobile number shouldn't be empty");
        }
        else if ( strlen($mobile) < 10 ) {
            die("Mobile number must be atleast 10 digits");
        }
        else if ( strlen( $password ) < 6 ) {
            die("Password should be atleast minimum 6 characters");
        }
        else if ( strlen( $password ) > 30 ) {
            die("Maximum length of password is 30 characters");
        }
        else if ( $password != $confirm_password ) {
            die("Passwords didn;t match!");
        }
        else {
            $check = "SELECT * FROM `user` WHERE email = '$email'";
			$result = mysqli_query($con, $check);
			if(mysqli_num_rows($result) > 0)
			{
				die("Email already exists! Try with another email");
			}
            else { 
                $password = md5($password);
                $sql = "INSERT INTO `user` (`id`, `username`, `email`, `password`, `mobile`) VALUES (NULL, '$username', '$email', '$password', '$mobile');";
                mysqli_query($con, $sql);
                $name = "Mozkart";
                $html = "
                    <h1 style='text-align: center'>Welcome!</h1>
                    <p style='text-align:center'>Your registration has been successfull and we are glad you welcome you to our community!</p>
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
                $mail->addAddress($email, 'User');
                $mail->isHTML(true);
                $mail->Subject = 'REGISTRATION SUCCESSFULL';
                $mail->Body = $html;
                $mail->send();
                echo "<script>
                    alert('Registered Successfully! Please login to continue');
                    window.location.href=window.history.back();
                    </script>";
            }
        }
    }
    else {
        header('location: index.php');
    }
?>