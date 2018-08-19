<?php
    session_start();
    require "local.php";
    require "check.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        $sql = "SELECT * FROM user WHERE email = '$session_mail'";
        $select_wishlist = mysqli_query($con, "SELECT * FROM wishlist WHERE user_email ='$session_mail'");
        $select_wishlist_one = mysqli_query($con, "SELECT * FROM wishlist WHERE user_email ='$session_mail'");
        $select_wishlist_two = mysqli_query($con, "SELECT * FROM wishlist WHERE user_email ='$session_mail'");
        $select_wishlist_three = mysqli_query($con, "SELECT * FROM wishlist WHERE user_email ='$session_mail'");
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
        if(isset($_GET['cart'])) {
            $cart = protect($con, $_GET['cart']);
            $sel_cart = mysqli_query($con, "SELECT * FROM `products` WHERE product_id='$cart'");
            $add = mysqli_fetch_array($sel_cart);
            $product_number = $add['product_number'];
            $product_name = $add['product_name'];
            $img = json_decode($add['images'], true);
            $product_image = $img[0];
            $quantity = $add['min_quantity'];
            $colors = json_decode($add['colors'], true);
            $color = $colors[0];
            $user_email = $session_mail;
            $price = $add['price_per_unit'];
            $check = mysqli_query($con, "SELECT * FROM cart WHERE product_number = '$product_number'");
            if(mysqli_num_rows($check) > 0) {
                header("location: cart.php");
            }
            else {
                $ins = "INSERT INTO `cart` (`cart_id`, `product_number`, `product_name`, `product_image`, `quantity`, `color`, `user_email`, `price`) VALUES (NULL, '$product_number', '$product_name', '$product_image', '$quantity', '$color', '$user_email', '$price');";
                if(mysqli_query($con, $ins)) {
                    header("location: cart.php");
                }
                else {
                    die(mysqli_error($con));
                }
            }
        }
        if ( isset( $_GET['clear'] ) ) {
            $clear = protect($con, $_GET['clear']);
            $clean = "DELETE FROM wishlist_product WHERE wp_id = '$clear'";
            if(mysqli_query($con, $clean)) {
                header("location: wishlist.php");
            }
            else {
                die(mysqli_error($con));
            }
        }
        if ( isset( $_GET['delete'] ) ) {
            $delete = protect($con, $_GET['delete']);
            $clean = "DELETE FROM wishlist WHERE w_id = '$delete'";
            $selwi = mysqli_query($con, "SELECT * FROM wishlist WHERE w_id = '$delete'");
            $s = mysqli_fetch_array($selwi);
            $w = $s['wishlist'];
            $n = $s['user_email'];
            if(mysqli_query($con, $clean)) {
                mysqli_query($con, "DELETE FROM wishlist_product WHERE wishlist = '$w' AND user_email = '$session_mail'");
                header("location: wishlist.php");
            }
            else {
                die(mysqli_error($con));
            }
        }
        if ( isset( $_GET['empty'] ) ) {
            $empty = protect($con, $_GET['empty']);
            $clean = "DELETE FROM wishlist_product WHERE wishlist = '$empty' AND user_email='$session_mail'";
            if(mysqli_query($con, $clean)) {
                header("location: wishlist.php");
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
                <div class="ch1">
                    <h1 class="uk-headind-primary uk-text-center text-white uk-text-uppercase">wishlist</h1>
                </div>
            </div>
        </section>
        <section class="">
            <div class="container pad">
                <div class="d-none d-md-block">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="nav nav-pills flex-column">
                                <?php
                                    if(mysqli_num_rows($select_wishlist)) {
                                        while($wishlist = mysqli_fetch_array($select_wishlist)) {
                                ?>
                                <li class="nav-item"><a class="nav-link tabs" href="#tab<?php echo $wishlist['w_id']; ?>" data-toggle="tab"><?php echo $wishlist['wishlist']; ?></a></li>
                                <?php
                                        }
                                    }
                                ?>
                                <li class="nav-item"><a class="nav-link" href="#create-new" data-toggle="tab"><span>&#43;</span> New List</a></li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content">
                                <?php
                                    if(mysqli_num_rows($select_wishlist_one)) {
                                        while($w_one = mysqli_fetch_array($select_wishlist_one)) {
                                            $w_name = $w_one['wishlist'];
                                ?>
                                <div class="tab-pane" id="tab<?php echo $w_one['w_id']; ?>">
                                    <h2 class="uk-heading-line text-primary"><span><?php echo $w_name; ?></span></h2>
                                    <div class="row">
                                        <?php
                                            $spw = mysqli_query($con, "SELECT * FROM wishlist_product WHERE wishlist = '$w_name' AND user_email = '$session_mail'");
                                            if(mysqli_num_rows($spw) > 0) {
                                                while($spd = mysqli_fetch_array($spw)) {
                                                    $sp_num = $spd['product_number'];
                                                    $spi = mysqli_query($con, "SELECT * FROM products WHERE product_number = '$sp_num'");
                                                    $spi_fetch = mysqli_fetch_assoc($spi);
                                                    $image = json_decode($spi_fetch['images'], true);
                                        ?>
                                        <div class="col-md-6 py-2">
                                            <div class="uk-card slide-card uk-card-default uk-card-hover" onclick="location.href = 'product_detail.php?product_view=<?php echo $spi_fetch['product_id']; ?>';">
                                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-width-1-1">
                                                    <img src="admin/<?php echo $image[0]; ?>" alt="" class="uk-width-1-1">
                                                    <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                                        <a href="wishlist.php?cart=<?php echo $spi_fetch['product_id']; ?>" class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</a>
                                                        <a href="wishlist.php?clear=<?php echo $spd['wp_id']; ?>" class="btn btn-danger btn-fab btn-fab-mini btn-round"><i class="fa fa-close"></i></a>
                                                    </div>
                                                </div>
                                                <div class="uk-card-footer">
                                                    <p class="uk-text-large"><?php echo $spi_fetch['product_name']; ?><br>&#8377;<?php echo $spi_fetch['price_per_unit']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                                }
                                            }
                                            else {
                                                echo "<p>No Products in this wishlist</p>";
                                            }
                                        ?>
                                    </div>
                                    <div class="uk-margin-top">
                                        <a href="wishlist.php?delete=<?php echo $w_one['w_id']; ?>" class="btn btn-danger">Delete Wishlist</a>
                                        <a href="wishlist.php?empty=<?php echo $w_one['wishlist']; ?>" class="btn btn-primary">Clear Wishlist</a>
                                        <a href="share_wishlist.php?user=<?php  echo base64_encode($session_mail); ?>&wishlist=<?php echo base64_encode($w_one['wishlist']); ?>" class="btn btn-info">Share Wishlist</a>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                                
                                
                                <div class="tab-pane" id="create-new">
                                    <h2 class="uk-heading-line text-primary"><span><i class="fa fa-plus"></i>  Create New Wishlist</span></h2>
                                    <form action="wishlist_process.php" method="POST" class="uk-width-1-2@m uk-margin-top">
                                        <div class="uk-margin">
                                            <input type="text" name="wishlist_name" class="uk-input" placeholder="Wishlist Name">
                                            <input type="submit" name="submit" value="create" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block d-md-none">
                    <ul class="nav nav-pills">
                        <?php 
                            if(mysqli_num_rows($select_wishlist_two)) {
                                while($wish_two = mysqli_fetch_array($select_wishlist_two)) {
                        ?>
                        <li class="nav-item"><a class="nav-link tablet" href="#pill<?php echo $wish_two['w_id']; ?>" data-toggle="tab"><?php echo $wish_two['wishlist']; ?></a></li>
                        <?php
                                }
                            }
                        ?>
                        <li class="nav-item"><a class="nav-link" href="#createnew" data-toggle="tab"><span>&#43;</span> New List</a></li>
                    </ul>
                    <div class="tab-content tab-space">
                        <?php
                            if(mysqli_num_rows($select_wishlist_three)) {
                                while($w_two = mysqli_fetch_array($select_wishlist_three)) {
                                    $wp_name = $w_two['wishlist'];
                        ?>
                        <div class="tab-pane tablet-pane" id="pill<?php echo $w_two['w_id']; ?>">
                            <h2 class="uk-heading-line uk-text-center text-primary"><span><?php echo $w_two['wishlist']; ?></span></h2>
                            <div class="row">
                                <?php
                                    $spw1 = mysqli_query($con, "SELECT * FROM wishlist_product WHERE wishlist = '$wp_name'");
                                    if(mysqli_num_rows($spw1) > 0) {
                                        while($spd1 = mysqli_fetch_array($spw1)) {
                                            $sp_num1 = $spd1['product_number'];
                                            $spi1 = mysqli_query($con, "SELECT * FROM products WHERE product_number = '$sp_num1'");
                                            $spi_fetch1 = mysqli_fetch_assoc($spi1);
                                            $image1 = json_decode($spi_fetch1['images'], true);
                                ?>
                                <div class="col-sm-6 py-2">
                                    <div class="uk-card slide-card uk-card-default uk-card-hover" onclick="location.href = 'product_detail.php?product_view=<?php echo $spi_fetch['product_id']; ?>';">
                                        <div class="uk-card-media-top uk-inline-clip uk-transition-toggle">
                                            <img src="admin/<?php echo $image1[0]; ?>" alt="" class="uk-width-1-1">
                                        </div>
                                        <div class="uk-card-footer">
                                            <p class="uk-text-large"><?php echo $spi_fetch1['product_name']; ?><br>&#8377;<?php echo $spi_fetch1['price_per_unit']; ?></p>
                                            <a href="wishlist.php?cart=<?php echo $spi_fetch['product_id']; ?>" class="btn btn-primary btn-round btn-fab btn-fab-mini"><i class="fa fa-shopping-bag"></i></a>
                                            <a href="wishlist.php?clear=<?php echo $spd['wp_id']; ?>" class="btn btn-danger btn-fab btn-fab-mini btn-round"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                    else {
                                        echo "<p>No Products in this wishlist</p>";
                                    }
                                ?>
                            </div>
                            <div class="uk-margin-top">
                                <a href="wishlist.php?delete=<?php echo $w_two['w_id']; ?>" class="btn btn-danger">Delete Wishlist</a>
                                <a href="wishlist.php?empty=<?php echo $w_two['wishlist']; ?>" class="btn btn-primary">Clear Wishlist</a>
                                <a href="share_wishlist.php?user=<?php  echo base64_encode($session_mail); ?>&wishlist=<?php echo base64_encode($w_two['wishlist']); ?>" class="btn btn-info">Share Wishlist</a>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
                        <div class="tab-pane" id="createnew">
                            <h2 class="uk-heading-line text-primary"><span><i class="fa fa-plus"></i>  Create New Wishlist</span></h2>
                            <form action="wishlist_process.php" method="POST">
                                <div class="uk-margin">
                                    <input type="text" name="wishlist_name" class="uk-input" placeholder="Wishlist Name">
                                    <input type="submit" name="submit" value="create" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
            $(function() {
                $( "ul.nav.nav-pills a.tabs" ).first().addClass( "active" );
                $( ".tab-pane" ).first().addClass( "active" );
                $( "ul.nav.nav-pills a.tablet" ).first().addClass( "active" );
                $( ".tablet-pane" ).first().addClass( "active" );
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
    </body>
</html>