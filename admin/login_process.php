<?php
	session_start();
	require "local.php";
	require "check.php";
	if( !empty($_SESSION['admin']) ) {
		header("location: index.php");
	}
	else {
		if( isset( $_POST['submit'] ) ) {
			$email = protect($con, $_POST['email']);
			$password = md5(protect($con, $_POST['password']));
			$check = mysqli_query($con, "SELECT * FROM admin WHERE email = '$email'");
			if(mysqli_num_rows($check) > 0) {
				while($admin = mysqli_fetch_assoc($check)) {
					$admin_email = $admin['email'];
					$admin_password = $admin['password'];
				}
				if($email == $admin_email && $password == $admin_password) {
					$_SESSION['admin'] = protect($con, $_POST['email']);
					header("location: index.php");
				}
				else {
					die("Incorrect credentials");
				}
			}
			else {
				die("User doesn't exist");
			}
		}
		else {
			header("location: login.php");
		}
	}
?>