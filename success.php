<?php
	session_start();
    $session_mail = $_SESSION["email"];
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
	if(empty($session_mail)) {
		header('location: index.php');
	}
	else {
        require ("local.php");
		$status=$_POST["status"];
		$firstname=$_POST["firstname"];
		$amount=$_POST["amount"];
		$txnid=$_POST["txnid"];
		$posted_hash=$_POST["hash"];
		$key=$_POST["key"];
		$productinfo=$_POST["productinfo"];
		$email=$_POST["email"];
        $salt="eCwWELxi";
        $encoded = base64_encode($productinfo);
        $user = mysqli_query($con, "SELECT * FROM users WHERE email = '$session_mail'");
        $user_data = mysqli_fetch_array($user);
        $log = $user_data['username'];
        $link = "index.php";
        $query = mysqli_query($con, "SELECT * FROM orders WHERE order_number = $productinfo");
		$row = mysqli_fetch_assoc($query);
		if (empty($_POST['productinfo'])) {
			header('location: cart.php');
		}

		// Salt should be same Post Request 

		If (isset($_POST["additionalCharges"])) {
			   $additionalCharges=$_POST["additionalCharges"];
				$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
		  } else {
				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
				 }
				 $hash = hash("sha512", $retHashSeq);
			   if ($hash != $posted_hash) {
				   echo "Invalid Transaction. Please try again";
				   } else {
				  // echo "<h3>Thank You. Your order status is ". $status .".</h3>";
				  // echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
                  // echo "<h4>We have received a payment of Rs. " . $amount . ". Your order will soon be shipped.</h4>";
                    $sql = "UPDATE orders SET status='placed', txn_id='$txnid' WHERE order_number='$productinfo'";
                    $quer = mysqli_query($con, $sql) or die(mysqli_error($con));
                    $delete = mysqli_query($con, "DELETE FROM cart WHERE user_email = '$session_mail'");
                    $sord = mysqli_query($con, "SELECT * FROM `ORDERS` WHERE order_number = '$productinfo'");
                    $spi = mysqli_fetch_assoc($sord);
                    $ord = json_decode($spi['order_data'], true);
                    for($j = 0; $j < count($ord); $j++) {
                        $pd = $ord[$j][0];
                        $qnt = $ord[$j][3];
                        mysqli_query($con, "UPDATE `products` SET in_stock = in_stock - $qnt WHERE product_number = '$pd';");
                    }
                $name = "Mozkart";
                $html = "
                    <h1 style='text-align: center'>Order Successful!</h1>
                    <p style='text-align:center'>Amount paid successfully. Transaction ID: ". $txnid ."</p>
                    <p style='text-align:center'>Your order has been placed successfully. Please use order number <b>". $productinfo ."</b> for future queries. Your order will be shipped soon</p>
                    <p style='text-align:center'>Trace your order by using below link</p>
                    <a href='http://localhost/task8/index.php?track=". $encoded ."'> Trace order</a>
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
                $mail->Subject = 'ORDER SUCCESSFUL';
                $mail->Body = $html;
                $mail->send();
				   }
	}
?>	

<!DOCTYPE html>
<html>
    <head>
        <title>Product Detail</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <link href="./assets/demo/demo.css" rel="stylesheet" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="./assets/demo/demo.css" rel="stylesheet" />
        <link href="./assets/css/material-kit.css?v=2.0.3" rel="stylesheet" />
        <link rel="stylesheet" href="css/uikit.min.css" />
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css"/>
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-dark bg-success fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
            <div class="container">
                <div class="navbar-translate">
                    <a class="navbar-brand" href=""><i class="fa fa-cart-arrow-down" style="font-size:24px"></i> Mozkart</a>
                    <button class="navbar-toggler" type="button"  data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                    </button>

                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="product.php">Shop</a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="">Contact us</a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link uk-text-capitalize" href="<?php  echo $link; ?>"><i class="fa fa-user-circle-o" style="font-size:24px"></i> <?php  echo $log; ?></a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="account.php"><i class="fa fa-sticky-note-o" style="font-size:24px"></i> My Account</a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="product.php"><i class="fa fa-cart-arrow-down" style="font-size:24px"></i> Shop</a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="wishlist.php"><i class="fa fa-cart-plus" style="font-size:24px"></i> My Wishlist</a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="cart.php"><i class="fa fa-shopping-bag" style="font-size:24px"></i> Cart</a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href=""><i class="fa fa-envelope-open-o" style="font-size:24px"></i> Contact us</a></li>
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out" style="font-size:24px"></i> Logout</a></li>
                    </ul>
                </div>
                <div class="ml-auto d-none d-lg-block" id="navbar-menu">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" style="font-size:24px"></i></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item uk-text-capitalize" href="<?php  echo $link; ?>"><?php  echo $log; ?></a>
                                <a class="dropdown-item" href="account.php">My Account</a>
                                <a class="dropdown-item" href="wishlist.php">My Wishlist</a>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa fa-shopping-bag" style="font-size:24px"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <br><br><br><br>
        <div class="container pad">
            <ul class="uk-breadcrumb">
                <li><a href="">Items</a></li>
                <li><a href="">Cart</a></li>
                <li><span>Payment</span></li>
            </ul>
            <h1 class="text-success"><i class="fa fa-check-circle-o" style="font-size:48px"></i> Congratulations! your order has been placed successfully!</h1>
        </div>
        <div class="container pad">
            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-smile-o text-success" style="font-size: 300px"></i>
                </div>
                <div class="col-md-8">
                    <div class="">
                        <p class="text-success bold font-size">Transaction ID: <?php echo $txnid; ?></p>
                        <p class="text-success font-size">Your payment has been processed and your order is complete. We will be dispatching yout order soon.</p>
                        <p class="text-success font-size">If you have any additional queries or issues, please state the following order number in all communications.</p>
                        <h2 class="text-success bold text-center"><?php echo $productinfo; ?></h2>
                    </div>
                </div>
            </div>
            <button class="btn btn-success btn-round uk-align-center" onclick="location.href='index.php';">Back to homepage</button>
        </div>
        <section class="sixth bg-white">
            <div class="container pad">
                <div class="row">
                    <div class="col-sm-12 col-lg-5">
                        <h4 class="text-success uk-text-uppercase">Get In Touch</h4>
                        <p class="uk-margin-right">Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879</p>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <h4 class="text-success uk-text-uppercase">Categories</h4>
                        <ul class="uk-list">
                            <li>Men</li>
                            <li>Women</li>
                            <li>Dresses</li>
                            <li>Sunglasses<li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <h4 class="text-success uk-text-uppercase">Help</h4>
                        <ul class="uk-list">
                            <li>Track Order</li>
                            <li>Returns</li>
                            <li>Shipping</li>
                            <li>FAQs</li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <h4 class="text-success uk-text-uppercase">NEWSLETTER</h4>
                        <form action="subscribe_process.php" method="POST" name="unsubscribe-newsletter">
                            <div class="form-group has-success">
                                <label for="email" class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <span class="bmd-help">We'll never share your email with anyone</span>
                            </div>
                            <span class="">Want to unsubscribe? <a class="" href="index.php?unsubscribe=true" uk-toggle>Click here</a></span>
                            <input type="submit" name="submit" value="SUBSCRIBE" class="btn btn-success btn-round"/>
                        </form>
                    </div>
                </div>
                <div class="text-success text-center uk-padding-small">
                    <i class="fa fa-cc-paypal" style="font-size:36px"></i>
                    <i class="fa fa-cc-visa" style="font-size:36px"></i>
                    <i class="fa fa-credit-card" style="font-size:36px"></i>
                    <i class="fa fa-cc-discover" style="font-size:36px"></i>
                    <i class="fa fa-cc-stripe" style="font-size:36px"></i>
                </div>
            </div>
        </section>
        <button class="btn btn-success btn-fab btn-round uk-position-bottom-right uk-position-fixed uk-position-z-index uk-margin uk-margin-right" id="return-to-top">
            <i class="material-icons">arrow_upward</i>
        </button>
        <footer class="bg-success text-white">
            <div class="container">
                <center>Copyright &copy; 2018 Mozkart. All rights reserved.</center>
            </div>
        </footer>
        <script src="./assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
        <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/moment.min.js"></script>
        <script src="./assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
        <script src="./assets/js/material-kit.js?v=2.0.3" type="text/javascript"></script>
        <script src="js/scroll.js" type="text/javascript"></script>
        <script>
            $(function() {
                $("form[name='subscribe-newsletter']").on('submit', function() {
                    var email = $("form[name='subscribe-newsletter'] #email").val();
                    if(email.length == 0) {
                        UIkit.notification({
                            message: 'Email should not be empty',
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });
                        event.preventDefault();
                    }
                    else {
                        $(this).submit();
                    }
                });
                $("form[name='unsubscribe-newsletter']").on('submit', function() {
                    var email = $("form[name='unsubscribe-newsletter'] #email").val();
                    if(email.length == 0) {
                        UIkit.notification({
                            message: 'Email should not be empty',
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });
                        event.preventDefault();
                    }
                    else {
                        $(this).submit();
                    }
                });
            });
        </script>
    </body>
</html>