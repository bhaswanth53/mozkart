<?php
    session_start();
    require "check.php";
    require "local.php";
    if(!empty($_SESSION["email"])) {
		header('location: index.php');
    }
    else {
        if ( isset($_POST['login'] ) ) {
            $email = protect($con, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
            $password = protect($con, md5( $_POST['password'] ));
            if( $email && $password ) {
                $query = mysqli_query($con,"SELECT * FROM user WHERE email = '$email'");
                $numrows = mysqli_num_rows($query);
                if ( $numrows != 0 ) {
                    while ($row = mysqli_fetch_assoc($query))
                    {
                        $dbemail = $row['email'];
                        $dbpassword = $row['password'];
                    }
                    if ($email == $dbemail && $password == $dbpassword) {
                        $_SESSION['email'] = $_POST['email'];
                        header('location: index.php');
                    }
                    else {
                        die("Invalid email address or password!");
                    }
                }
                else {
                    die("User doesn't exist!");
                }
            }
            else {
                die("Please enter email and password!");
            }
        }
        else {
            header('location: index.php');
        }
    }
?>