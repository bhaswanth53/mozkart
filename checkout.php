<?php
    error_reporting(E_ALL ^ E_WARNING); 
    session_start();
    require "local.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        function order_code($order_number){
            require "local.php";
			$qur = "SELECT * FROM `orders` WHERE order_number ='". $order_number."'";
			$select = mysqli_query($con, $qur);
			if(mysqli_num_rows($select) > 0 || strlen($order_number) != 10) {
				$number='0123456789';
				$order_number = substr(str_shuffle($number), 0, 10);
				order_code($order_number);
			}
			return $order_number;
        }
        $action = "";
        $sql = "SELECT * FROM user WHERE email = '$session_mail'";
        $query = mysqli_query($con, $sql);
        $user_data = mysqli_fetch_assoc($query);
        $log = $user_data['username'];
        $link = "index.php";
        $forgot_status = $user_data['forgot'];
        if($forgot_status != 0) {
            if($forgot_status == 1) {
                header('location: verify_otp.php');
            }
            else if($forgot_status == 2) {
                header('location: reset_password.php');
            }
        }

        if ( isset( $_POST['checkout'] ) ) {
            $order = array();
            $numbers = '0123456789';
			$mixed = substr(str_shuffle($numbers));
            $order_number = order_code($mixed);
            $payment_method = $_POST['payment_method'];
            $name = $_POST['op_name'];
            $email = $_POST['op_mail'];
            $mobile = $_POST['op_mobile'];
            $order_number = $_POST['productinfo'];
            $delivery_address = $_POST['op_delivery'];
            $payment_type = $_POST['payment_type'];
            for($i=0; $i<count($_POST['product_number']); $i++) {
				$order[$i] = array($_POST['product_number'][$i], $_POST['product_name'][$i], $_POST['product_color'][$i], $_POST['quantity'][$i], $_POST['tprice'][$i]);
            }
            $items = json_encode($order);
            $price = $_POST['tprice'];
            $total_price = array_sum($price);
        }

        if( isset ($_POST['proceed'] ) ) {
            $order = base64_decode($_POST['order']);
            $name = $_POST['firstname'];
            $email = $_POST['email'];
            $mobile = $_POST['phone'];
            $total_price = $_POST['amount'];
            $payment_method = $_POST['payment_method'];
            $payment_type = $_POST['payment_type'];
            $delievery_address = $_POST['delivery_address'];
            $sql = "INSERT INTO `orders` (`o_id`, `order_number`, `name`, `email`, `mobile`, `billing_address`, `delivery_address`, `payment_method`, `payment_type`, `status`, `order_data`, `price`) VALUES (NULL, '$order_number', '$name', '$email', '$mobile', 'NULL', '$delivery_address', '$payment_method', '$payment_type', 'NULL', '$order', '$total_price');";
            mysqli_query($con, $sql) or die(mysqli_error($con));
        }
            
       }
        $MERCHANT_KEY = "gtKFFx";
		$SALT = "eCwWELxi";
		$PAYU_BASE_URL = "https://test.payu.in/_payment";
		$posted = array();
       if(!empty($_POST)) {
            //print_r($_POST);
        foreach($_POST as $key => $value) {    
            $posted[$key] = $value;	
        }
        }
        $formError = 0;
        if(empty($posted['txnid'])) {
        // Generate random transaction id
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        } else {
        $txnid = $posted['txnid'];
        }
        $hash = '';
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if(empty($posted['hash']) && sizeof($posted) > 0) {
        if(
                empty($posted['key'])
                || empty($posted['txnid'])
                || empty($posted['amount'])
                || empty($posted['firstname'])
                || empty($posted['email'])
                || empty($posted['phone'])
                || empty($posted['productinfo'])
                || empty($posted['surl'])
                || empty($posted['furl'])
                
        ) {
            $formError = 1;
        } else {
            //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';	
            foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
            }

            $hash_string .= $SALT;

            //echo $hash_string;
            
            $hash = strtolower(hash('sha512', $hash_string));
            
            $action = $PAYU_BASE_URL . '/_payment';
        }
        } elseif(!empty($posted['hash'])) {
        $hash = $posted['hash'];
        $action = $PAYU_BASE_URL . '/_payment';
        }
    else {
        header("location: index.php?login");
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
        <script>
			var hash = '<?php echo $hash ?>';
			//alert(hash);
			function submitPayuForm() {
                if(hash == '') {
                    return;
                }
                var payuForm = document.forms.payuForm;
                payuForm.submit();
			}
	    </script>
    </head>
    <body onload="submitPayuForm()">
        <nav class="navbar navbar-dark bg-primary fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
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
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="<?php  echo $link; ?>"><i class="fa fa-user-circle-o" style="font-size:24px"></i> <?php  echo $log; ?></a></li>
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
                                <a class="dropdown-item" href="index.php?login">Username</a>
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
        <section>
            <div class="container pad">
                <form action="<?php echo $action; ?>" method="POST" name="payuForm">
                    <h3 class="text-primary uk-text-uppercase text-center">Order Info</h3>
                    <table class="uk-table d-none d-sm-block">
                        <tbody>
                            <tr>
                                <td class="uk-width-1-2 text-right border-col-right text-primary">Name</td>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td class="uk-width-1-2 text-right border-col-right text-primary">Mobile</td>
                                <td><?php echo $mobile; ?></td>
                            </tr>
                            <tr>
                                <td class="uk-width-1-2 text-right border-col-right text-primary">Email</td>
                                <td><?php echo $email; ?></td>
                            </tr>
                            <tr>
                                <td class="uk-width-1-2 text-right border-col-right text-primary">Total Items</td>
                                <td><?php echo count($order); ?></td>
                            </tr>
                            <tr>
                                <td class="uk-width-1-2 text-right border-col-right text-primary">Amount to be paid</td>
                                <td><?php echo $total_price; ?></td>
                            </tr>
                            <tr>
                                <td class="uk-width-1-2 text-right border-col-right text-primary">Delivery Address</td>
                                <td>
                                    <address>
                                        <?php echo $delivery_address; ?>
                                    </address>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="uk-table uk-table-responsive d-block d-sm-none">
                        <tbody>
                            <tr>
                                <td class="text-primary">Name:</td>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary">Mobile:</td>
                                <td><?php echo $mobile; ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary">Email:</td>
                                <td><?php echo $email; ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary">Total Items:</td>
                                <td><?php echo count($order); ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary">Amount to be paid:</td>
                                <td><?php echo $total_price; ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary">Delivery Address:</td>
                                <td>
                                    <address>
                                        <?php echo $delivery_address; ?>
                                    </address>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                    <input type="hidden" name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' . $order_number . '' : $posted['productinfo'] ?>" />
                    <input type="hidden" name="surl" value="<?php echo (empty($posted['surl'])) ? 'http://localhost/task8/success.php' : $posted['surl'] ?>" size="64" />
                    <input type="hidden" name="furl" value="<?php echo (empty($posted['furl'])) ? 'http://localhost/task8/failure.php' : $posted['furl'] ?>" size="64" />
                    <input type="hidden" name="firstname" id="firstname" class="form-control" value="<?php echo (empty($posted['firstname'])) ? ''. $name .'' : $posted['firstname']; ?>" />
                    <input type="hidden" name="email" id="email" class="form-control" value="<?php echo (empty($posted['email'])) ? '' . $email .'' : $posted['email']; ?>" />
                    <input type="hidden" name="phone" class="form-control" value="<?php echo (empty($posted['phone'])) ? ''. $mobile .'' : $posted['phone']; ?>" />
                    <input type="hidden" name="amount" class="form-control" readonly value="<?php echo (empty($posted['amount'])) ? '' . $total_price . '' : $posted['amount'] ?>" />
                    <input type="hidden" name="order" value="<?php echo base64_encode($items); ?>">
                    <input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>">
                    <input type="hidden" name="payment_type" value="<?php echo $payment_type; ?>">
                    <input type="hidden" name="delivery_address" value="<?php echo $delivery_address ?>">
                    <?php if(!$hash) { ?>
                    <input type="submit" name="proceed" value="proceed to payment" class="btn btn-primary btn-round uk-align-center"/>
                    <?php } ?>
                    <button class="btn btn-danger" onclick="window.history.back();">Cancel Payment</button>
                </form>
            </div>
        </section>
        <section class="sixth bg-white">
            <div class="container pad">
                <div class="row">
                    <div class="col-sm-12 col-lg-5">
                        <h4 class="text-primary uk-text-uppercase">Get In Touch</h4>
                        <p class="uk-margin-right">Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879</p>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <h4 class="text-primary uk-text-uppercase">Categories</h4>
                        <ul class="uk-list">
                            <li>Men</li>
                            <li>Women</li>
                            <li>Dresses</li>
                            <li>Sunglasses<li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <h4 class="text-primary uk-text-uppercase">Help</h4>
                        <ul class="uk-list">
                            <li>Track Order</li>
                            <li>Returns</li>
                            <li>Shipping</li>
                            <li>FAQs</li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <h4 class="text-primary uk-text-uppercase">NEWSLETTER</h4>
                        <form action="subscribe_process.php" method="POST">
                            <div class="form-group">
                                <label for="email" class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <span class="bmd-help">We'll never share your email with anyone</span>
                            </div>
                            <input type="submit" name="submit" value="SUBSCRIBE" class="btn btn-primary btn-round"/>
                        </form>
                    </div>
                </div>
                <div class="text-primary text-center uk-padding-small">
                    <i class="fa fa-cc-paypal" style="font-size:36px"></i>
                    <i class="fa fa-cc-visa" style="font-size:36px"></i>
                    <i class="fa fa-credit-card" style="font-size:36px"></i>
                    <i class="fa fa-cc-discover" style="font-size:36px"></i>
                    <i class="fa fa-cc-stripe" style="font-size:36px"></i>
                </div>
            </div>
        </section>
        <button class="btn btn-primary btn-fab btn-round uk-position-bottom-right uk-position-fixed uk-position-z-index uk-margin uk-margin-right" id="return-to-top">
            <i class="material-icons">arrow_upward</i>
        </button>
        <footer class="bg-purple">
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
    </body>
</html>