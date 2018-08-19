<?php
    session_start();
    require "local.php";
    require "check.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        $sql = "SELECT * FROM user WHERE email = '$session_mail'";
        $query = mysqli_query($con, $sql);
        $user_data = mysqli_fetch_assoc($query);
        $log = $user_data['username'];
        $link = "index.php";
        $forgot_status = $user_data['forgot'];
        $trace = 'account.php';
        if($forgot_status != 0) {
            if($forgot_status == 1) {
                header('location: verify_otp.php');
            }
            else if($forgot_status == 2) {
                header('location: reset_password.php');
            }
        }
        if(isset($_GET['track'])) {
            $num = protect($con, base64_decode($_GET['track'], true));
            $track = mysqli_query($con, "SELECT * FROM `orders` WHERE order_number = '$num'");
            $get_trace = mysqli_fetch_array($track);
        }
        if(isset($_GET['add'])) {
            $num = protect($con, base64_decode($_GET['add'], true));
            $get_query = mysqli_query($con, "SELECT * FROM `orders` WHERE order_number = '$num'");
            $get = mysqli_fetch_array($get_query);
            $data = json_decode($get['order_data'], true);
            foreach($data as $odd) {
                $prd = $odd[0];
                $price = $odd[4];
                $selp = mysqli_query($con, "SELECT * FROM `products` WHERE product_number = '$prd'");
                $p = mysqli_fetch_array($selp);
                $product_name = $p['product_name'];
                //$quantity = $p['min_quantity'];
                $quantity = $odd[3];
                //$color = json_decode($p['colors'], true);
                $color = $odd[2];
                $price = $odd[4];
                $pic = json_decode($p['images'], true);
                $cap = $pic[0];
                $ck = mysqli_query($con, "SELECT * FROM `cart` WHERE product_number = '$prd' AND user_email = '$session_mail'");
                if($p['in_stock'] >= $quantity) {
                    if(mysqli_num_rows($ck) == 0) {
                        $ins = "INSERT INTO `cart` (`cart_id`, `product_number`, `product_name`, `product_image`, `quantity`, `color`, `user_email`, `price`) VALUES (NULL, '$prd', '$product_name', '$cap', '$quantity', '$color', '$session_mail', '$price');";
                        mysqli_query($con, $ins);
                    }
                }
            }
            header("location: account.php");
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
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
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
        <section class="done">
            <div class="container pad">
                <ul class="nav nav-pills nav-pills-icons" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">
                            <i class="material-icons">account_circle</i>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#change_password" role="tab" data-toggle="tab">
                            <i class="material-icons">lock</i>
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#orders" role="tab" data-toggle="tab">
                            <i class="material-icons">list</i>
                            Your Orders
                        </a>
                    </li>
                </ul>
                <div class="container pad">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="profile">
                            <div class="view_profile">
                                <table class="uk-table font-size">
                                    <tbody>
                                        <tr>
                                            <td class="text-primary text-right uk-width-1-2 border-right">Name:</td>
                                            <td><?php echo $user_data['username']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-primary text-right uk-width-1-2 border-right">Email:</td>
                                            <td><?php echo $user_data['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-primary text-right uk-width-1-2 border-right">Mobile:</td>
                                            <td><?php echo $user_data['mobile']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="container">
                                    <h4 class="text-primary">Saved Addresses:</h4>
                                    <div class="row">
                                        <?php
                                      /*   $json = ['aaa','bbb'];
                                        print_r(json_decode(json_encode($json),true)); */
                        
                                            $addr =$user_data['address'];
                                            $address = unserialize($addr);
                                            if (count($address) != 0) {
                                                foreach($address as $add) {
                                            
                                        ?>
                                        <div class="col-md-4 py-2">
                                            <div class="uk-card uk-card-default uk-card-hover">
                                                <div class="uk-card-body">
                                                    <p class="font-size"><?php echo $add; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                                }
                                            }
                                            else {
                                                echo "No addresses saved!";
                                            }
                                        ?>
                                    </div>
                                    <button class="btn btn-primary edit_open">Edit Profile</button>
                                </div>
                            </div>
                            <div class="container pad edit_profile">
                                <form action="edit_profile_process.php" method="POST">
                                    <fieldset class="uk-fieldset">
                                        <legend class="uk-legend">Edit your profile</legend>
                                        <div class="uk-margin">
                                            <input type="text" class="uk-input" name="name" placeholder="Name" value="<?php echo $user_data['username']; ?>">
                                        </div>
                                        <div class="uk-margin">
                                            <input type="email" class="uk-input" name="email" placeholder="Email" value="<?php echo $user_data['email']; ?>" readonly>
                                        </div>
                                        <div class="uk-margin">
                                            <input type="text" class="uk-input" name="mobile" placeholder="Mobile" value="<?php echo $user_data['mobile']; ?>">
                                        </div>
                                        <div class="uk-margin address_wrap">
                                            <div class="add_wrap">
                                                <textarea class="uk-textarea" rows="5" placeholder="Address" name="address[]"><?php echo $address[0]; ?></textarea>
                                                <a href="javascript:void(0);" class="btn btn-primary" id="add_address"><i class="material-icons">add</i></a>
                                            </div>
                                            <?php
                                                for($d = 1; $d < count($address); $d++) {
                                            ?>
                                            <div class="add_wrap">
                                                <textarea class="uk-textarea" rows="5" placeholder="Address" name="address[]"><?php echo $address[$d]; ?></textarea>
                                                <a href="javascript:void(0);" class="btn btn-primary" id="add_address"><i class="material-icons">add</i></a>
                                                <a href="javascript:void(0);" class="btn btn-danger" id="remove_address"><i class="material-icons">close</i></a>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        
                                        <input type="submit" name="update_profile" value="Save Profile" class="btn btn-primary">
                                        <a href="javascript:void(0);" class="btn btn-info view_open">View Profile</a>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="change_password">
                            <div class="container">
                                <form action="change_process.php" method="POST" class="uk-width-1-2@m" name="change_password">
                                    <fieldset class="uk-fieldset">
                                        <legend class='uk-legend'>Change Password</legend>
                                        <div class="uk-margin">
                                            <input class="uk-input" type="password" name="current_password" placeholder="Current Password">
                                        </div>
                                        <div class="uk-margin">
                                            <input class="uk-input" type="password" id="new_password" name="new_password" placeholder="New Password">
                                        </div>
                                        <div class="uk-margin">
                                            <input class="uk-input" type="password" name="confirm_password" placeholder="Confirm Password">
                                        </div>
                                        <input type="submit" name="change_password" value="update password" class="btn btn-primary">
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="orders">
                            <div class="container">
                                <ul class="uk-list-divider" uk-accordion>
                                    <?php
                                        $ord = mysqli_query($con, "SELECT * FROM `orders` WHERE session='$session_mail'");
                                        if(mysqli_num_rows($ord) > 0) {
                                            while($order = mysqli_fetch_array($ord)) {
                                                
                                    ?>
                                    <li>
                                        <a class="uk-accordion-title uk-text-uppercase" href="#">order no: <?php echo $order['order_number']; ?></a>
                                        <div class="uk-accordion-content">
                                            <table class="table">
                                                <tbody class="font-size uk-text-uppercase">
                                                    <tr>
                                                        <td class="text-primary bold">Order date:</td>
                                                        <td><?php echo $order['order_date']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-primary bold">Order status:</td>
                                                        <td><?php echo $order['status']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-primary bold">Total Amount:</td>
                                                        <td>&#8377;<?php echo $order['price']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-primary bold">Payment type:</td>
                                                        <td><?php echo $order['payment_method']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-primary bold">Delivered Date:</td>
                                                        <td>
                                                            <?php
                                                                $delivery_date = $order['delivery_date'];
                                                                if (empty($delivery_date)) {
                                                                    $delivery_date = 'Processing';
                                                                }
                                                                echo $delivery_date;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <?php
                                                    $op = json_decode($order['order_data'], true);
                                                    foreach($op as $item) {
                                                        $num = $item[0];
                                                        $img = mysqli_query($con, "SELECT * FROM products WHERE product_number = '$num'");
                                                        $he = mysqli_fetch_assoc($img);
                                                        $im = json_decode($he['images'], true);
                                                ?>
                                                <div class="col-md-3">
                                                    <div class="card" style="">
                                                        <img class="card-img-top" src="admin/<?php echo $im[0]; ?>" alt="Card image cap" style="height: 200px">
                                                        <div class="card-body">
                                                            <h4 class="card-title text-primary"><?php echo $item[1]; ?></h4>
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-primary">Quantity</td>
                                                                        <td><?php echo $item[3]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-primary">Price</td>
                                                                        <td>&#8377;<?php echo $item[4]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-primary">Color</td>
                                                                        <td>
                                                                            <div style="width: 25px; height: 17px; background-color: <?php echo $item[2]; ?>"></div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="">
                                                <a href="account.php?add=<?php echo base64_encode($order['order_number']); ?>" class="btn btn-primary">Add to Cart</a>
                                                <a href="<?php echo $trace; ?>?track=<?php echo base64_encode($order['order_number']); ?>" class="btn btn-danger">Track Order</a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                            }
                                        }
                                        else {
                                            echo "<p>No orders yet!</p>";
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade track" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bold font-size text-center uk-text-uppercase text-primary" id="exampleModalLabel">Order Number: 1122334455</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody class="font-size uk-text-uppercase">
                            <tr>
                                <td  class="text-primary bold">Order Date:</td>
                                <td><?php echo $get_trace['order_date']; ?></td>
                            </tr>
                            <tr>
                                <td  class="text-primary bold">Total Amount:</td>
                                <td><?php echo $get_trace['price']; ?></td>
                            </tr>
                            <tr>
                                <td  class="text-primary bold">Payment Type:</td>
                                <td>
                                    <?php
                                        $type = $get_trace['payment_method'];
                                        if($type=='op') {
                                            $type="Online Payment (" . $get_trace['payment_type'] . ")";
                                        }
                                        else {
                                            $type = 'Cash on delivery';
                                        }
                                        echo $type;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td  class="text-primary bold">Status:</td>
                                <td><?php echo $get_trace['status']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
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
        <script src="js/dynamic_fields.js" type="text/javascript"></script>
        <script>
            $(function() {
                $('.edit_profile').css('display','none');
                $('.edit_open').on('click', function() {
                    $('.view_profile').css('display','none');
                    $('.edit_profile').css('display','block');
                });
                $('.view_open').on('click', function() {
                    $('.view_profile').css('display','block');
                    $('.edit_profile').css('display','none');
                });
            });
        </script>
        <script>
            if(window.location.href.indexOf("changed=true") > -1) {
                UIkit.notification({
                    message: 'Password changed successfully!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
        </script>
        <script>
            $(function() {
                $("form[name='change_password']").validate({
                    rules: {
                        current_password: "required",
                        new_password: {
                            required: true,
                            minlength: 6,
                            maxlength: 30
                        },
                        confirm_password: {
                            required: true,
                            equalTo: '#new_password'
                        }
                    },
                    messages: {
                        current_password: "Please enter your current password",
                        new_password: {
                            required: "Please enter your password",
                            minlength: "Password must be minimum 6 characters",
                            maxlength: "Maximum length of password is 30 characters"
                        },
                        confirm_password: {
                            required: "Please confirm your password",
                            equalTo: "Passwords didn't match!"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
        <script>
            if(window.location.href.indexOf("track") > -1) {
              $('.track').modal('show');
            }
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
    </body>
</html>