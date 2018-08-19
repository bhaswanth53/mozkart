<?php
    session_start();
    require "local.php";
    require "check.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        $sql = "SELECT * FROM user WHERE email = '$session_mail'";
        $query = mysqli_query($con, $sql);
        $user_data = mysqli_fetch_assoc($query);
        $select_cart = mysqli_query($con, "SELECT * FROM cart WHERE user_email = '$session_mail'");
        $select_min_cart = mysqli_query($con, "SELECT * FROM cart WHERE user_email = '$session_mail'");
        if(mysqli_num_rows($select_cart) == 0) {
            header("location: product.php");
        }
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
        if ( isset( $_GET['clear'] ) ) {
            $clear = protect($con, $_GET['clear']);
            if ($clear == 'all') {
                $clean = "DELETE FROM cart WHERE user_email = '$session_mail'";
            }
            else {
                $clean = "DELETE FROM cart WHERE cart_id = '$clear'";
            }
            if(mysqli_query($con, $clean)) {
                header("location: cart.php");
            }
            else {
                die(mysqli_error($con));
            }
        }
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
    </head>
    <body>
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
        <br><br><br>
        <section class="cone header-filter clear-filter purple-filter" style="background-image: url('./img/c1.jpg')">
            <div class="container pad">
                <h1 class="uk-heading-hero uk-text-center text-white uk-text-uppercase ch1">Cart</h1>
            </div>
        </section>
        <form action="" method="POST" name="checkout_form">
        <section class="">
            <div class="container pad">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="uk-text-uppercase text-primary">
                            <tr>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(mysqli_num_rows($select_cart) > 0) {
                                    while($cart = mysqli_fetch_array($select_cart)) {
                                        $num = $cart['product_number'];
                                        $cp = mysqli_query($con, "SELECT * FROM products WHERE product_number = '$num'");
                                        $sp = mysqli_fetch_array($cp);
                            ?>
                            <tr>
                                <td>
                                    <img src="admin/<?php echo $cart['product_image']; ?>" class="cart-img"/>
                                    <input type="hidden" name="product_number[]" value="<?php echo $cart['product_number']; ?>">
                                </td>
                                <td>
                                    <p class="text-primary cart-text uk-margin-top bold"><?php echo $cart['product_name']; ?></p>
                                    <input type="hidden" name="product_name[]" value="<?php echo $cart['product_name']; ?>">
                                </td>
                                <td>
                                    <div class="uk-margin-top">
                                        <div style="width: 40px; height: 20px; background: <?php echo $cart['color']; ?>"></div>
                                        <input type="hidden" name="product_color[]" value="<?php echo $cart['color']; ?>">
                                    </div>
                                </td>
                                <td><p class="bold uk-margin-top">&#8377;<span><?php echo $cart['price']; ?></span></p></td>
                                <td>
                                    <!--<div class="uk-margin-top count-input space-bottom">
                                        <a class="incr-btn" data-action="decrease" href="#">–</a>
                                        <input class="quantity" type="number" name="quantity[]" value="1" id="units<?php echo $cart['cart_id']; ?>"/>
                                        <a class="incr-btn" data-action="increase" href="#">&plus;</a>
                                    </div>-->
                                    <div class="uk-margin-top">
                                        <input type="number" name="quantity[]" class="uk-input" value="<?php echo $cart['quantity']; ?>" min="<?php echo $sp['min_quantity']; ?>" max="<?php echo $sp['max_quantity']; ?>" id="units<?php echo $cart['cart_id']; ?>">
                                    </div>
                                </td>
                                <td><p class="bold uk-margin-top">&#8377;<span id="price<?php echo $cart['cart_id']; ?>"><?php echo $cart['price']; ?></span></p></td>
                                <td>
                                    <a href="cart.php?clear=<?php echo $cart['cart_id']; ?>" class="uk-margin-top btn btn-danger btn-fab btn-fab-mini btn-round"><i class="material-icons">close</i></a>
                                </td>
                                <input type="hidden" name="tprice[]" id="tprice<?php echo $cart['cart_id']; ?>" value="<?php echo $cart['price']; ?>" readonly>
                            </tr>
                            <?php
                                if($sp['max_quantity'] <= $sp['in_stock']) {
                                    $max_quantity = $sp['max_quantity'];
                                }
                                else {
                                    $max_quantity = $sp['in_stock'];
                                }
                            ?>
                            <script>
                                $(document).ready(function() {
                                    var price = <?php echo $cart['price']; ?>;
                                    var rate = price * $("#units<?php echo $cart['cart_id']; ?>").val();
                                    $("p span#price<?php echo $cart['cart_id']; ?>").text(rate);
                                    $("input#tprice<?php echo $cart['cart_id']; ?>").val(rate);
                                });
                            </script>
                            <script>
                                $(function() {
                                    $("#units<?php echo $cart['cart_id']; ?>").on('input', function() {
                                        var price = <?php echo $cart['price']; ?>;
                                        var rate = price * $(this).val();
                                        $("p span#price<?php echo $cart['cart_id']; ?>").text(rate);
                                        $("input#tprice<?php echo $cart['cart_id']; ?>").val(rate);
                                    });
                                });
                            </script>
                            <script>
                                $("#units<?php echo $cart['cart_id']; ?>").on('input', function () {  
                                    var value = $(this).val();  
                                    if ((value !== '') && (value.indexOf('.') === -1)) {    
                                        $(this).val(Math.max(Math.min(value, <?php echo $max_quantity; ?>), <?php echo $sp['min_quantity']; ?>));
                                    }
                                });
                            </script>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-danger" href="cart.php?clear=all">Clear Cart</a>
            </div>
        </section>
        <section>
            <div class="container pad">
                <div class="row">
                    <div class="col-md-6 pad">
                        <div class="uk-card uk-card-body uk-card-default">
                            <div class="container pad">
                                <h3 class="text-primary">Apply Coupon</h3>
                                <div class="form-group">
                                    <label for="coupon_code" class="bmd-label-floating">Coupon Code</label>
                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code">
                                </div>
                                <!--<input type="button" name="coupon" value="apply coupon" class="btn btn-primary btn-round"/>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pad">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <h2 class="uk-card-title uk-text-uppercase text-primary">Cart Totals</h2>
                            </div>
                            <div class="uk-card-body">
                                <table class="uk-table uk-table-responsive">
                                    <tbody>
                                        <tr>
                                            <td class="uk-text-uppercase text-primary">Shipping</td>
                                            <td>
                                                <select class="uk-select" id="payment_method" name="payment_method">
                                                    <option value="">Select Shipping Mode</option>
                                                    <option value="cod">Cash On Delivery</option>
                                                    <option value="op">Online Payment</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="container" id="cod_info">
                                    <h5 class="text-primary uk-text-uppercase text-center">Cash on delivery</h5>
                                    <div class="uk-margin">
                                        <input type="text" class="uk-input" name="cod_name" placeholder="Name" value="<?php echo $user_data['username']; ?>">
                                    </div>
                                    <div class="uk-margin">
                                        <input type="text" class="uk-input" name="cod_mobile" placeholder="Mobile" value="<?php echo $user_data['mobile']; ?>">
                                    </div>
                                    <div class="uk-margin">
                                        <input type="email" class="uk-input" name="cod_email" placeholder="Email" value="<?php echo $user_data['email']; ?>">
                                    </div>
                                    <div class="uk-margin">
                                        <!--<textarea class="uk-textarea" rows="5" placeholder="Billing Address" id="billing_address" name="billing_address"></textarea>-->
                                        <label>Billing Address</label>
                                        <select class="uk-select" name="billing_address" id="billing_address">
                                            <?php
                                                $address = unserialize($user_data['address']);
                                                foreach($address as $addr) {
                                            ?>
                                            <option><?php echo $addr; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="" id="same">
                                            Same address for delivery
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="uk-margin">
                                        <textarea class="uk-textarea" rows="5" placeholder="Delivery Address" id="delivery_address" name="delivery_address"></textarea>
                                    </div>
                                </div>
                                <div class="container" id="op_info">
                                    <h5 class="text-primary uk-text-uppercase text-center">Online Payment</h5>
                                    <div class="uk-margin">
                                        <input type="text" class="uk-input" name="op_name" placeholder="Enter Name" value="<?php echo $user_data['username']; ?>">
                                    </div>
                                    <div class="uk-margin">
                                        <input type="email" class="uk-input" name="op_mail" placeholder="Enter Email" value="<?php echo $user_data['email']; ?>">
                                    </div>
                                    <div class="uk-margin">
                                        <input type="text" class="uk-input" name="op_mobile" placeholder="Enter Mobile Number" value="<?php echo $user_data['mobile']; ?>">
                                    </div>
                                    <div class="uk-margin">
                                        <!-- <textarea class="uk-textarea" rows="5" name="op_delivery" placeholder="Enter Delivery Address"></textarea> -->
                                        <label>Delivery Address</label>
                                        <select class="uk-select" name="op_delivery">
                                            <?php
                                                $address = unserialize($user_data['address']);
                                                foreach($address as $addr) {
                                            ?>
                                            <option><?php echo $addr; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="uk-margin">
                                        <select class="uk-select" name="payment_type">
                                            <option value="" class="text-primary">Select Payment Type</option>
                                            <option value="paypal">Paypal</option>
                                            <option value="stripe">Stripe</option>
                                            <option value="paytm">PayTm</option>
                                            <option value="ccavenue">CCavenue</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-footer">
                                <input type="submit" name="checkout" value="proceed to checkout" class="btn btn-primary btn-round uk-align-center"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </form>
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
                        <form action="subscribe_process.php" method="POST" name="unsubscribe-newsletter">
                            <div class="form-group">
                                <label for="email" class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <span class="bmd-help">We'll never share your email with anyone</span>
                            </div>
                            <span class="">Want to unsubscribe? <a class="" href="index.php?unsubscribe=true" uk-toggle>Click here</a></span>
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
        <script>
            $(".incr-btn").on("click", function (e) {
                var $button = $(this);
                var oldValue = $button.parent().find('.quantity').val();
                $button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
                if ($button.data('action') == "increase") {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below 1
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                        $button.addClass('inactive');
                    }
                }
                $button.parent().find('.quantity').val(newVal);
                e.preventDefault();
            });
        </script>
        <script type="text/javascript">
            $(function(){
                $("#cod_info").css('display','none');
                $("#op_info").css('display','none');
                $("select#payment_method").change(function(){
                    var val = $("#payment_method option:selected").val();
                    if(val == "cod") {
                        $("#cod_info").css('display','block');
                        $("#op_info").css('display','none');
                        $("form[name='checkout_form']").attr('action','cod_checkout.php');
                    }
                    else if(val == "op") {
                        $("#cod_info").css('display','none');
                        $("#op_info").css('display','block');
                        $("form[name='checkout_form']").attr('action','op_checkout.php');
                    }
                    else {
                        $("#cod_info").css('display','none');
                        $("#op_info").css('display','none');
                        $("form[name='checkout_form']").removeAttr("action");
                    }
                });
                $('#same').on('click', function(){
                    if($(this).prop("checked") === true){
                        $("#delivery_address").val($("#billing_address").val());
                    }
                    else if($(this).prop("checked") === false){
                        $("#delivery_address").val('');
                    }
                    else {
                        $("#delivery_address").val('');
                    }
                });
            });
        </script>
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
        <script>
            $("form[name='checkout_form']").on('submit', function() {
                var payment_method = $("select[name='payment_method']").val();
                if(payment_method == "") {
                    alert("Please select payment method");
                    event.preventDefault();
                }
                else {
                    $(this).submit();
                }
            });
        </script>
    </body>
</html>