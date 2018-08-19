<?php
    session_start();
    require "local.php";
    require "check.php";
    $select = mysqli_query($con, "SELECT * FROM `categories`");
    $select_offer = mysqli_query($con, "SELECT * FROM offers WHERE expiry_date >= CURDATE()");
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
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
    }
    else {
        $log = "Login / Signup";
        $link = "index.php?login";
    }
    if(isset($_GET['cart'])) {
        //$cart = $_GET['cart'];
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
        if( empty($session['email'] ) ) {
            header("location: index.php?login");
        }
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
    if(isset($_GET['track'])) {
        $num = protect($con, base64_decode($_GET['track'], true));
        
        $track = mysqli_query($con, "SELECT * FROM `orders` WHERE order_number = '$num'");
        $get_trace = mysqli_fetch_array($track);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mozcart - Homepage</title>
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
        <nav class="navbar navbar-dark bg-white navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
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
                        <li class="nav-item d-block d-lg-none"><a class="nav-link uk-text-capitalize" href="<?php echo $link; ?>"><i class="fa fa-user-circle-o" style="font-size:24px"></i> <?php echo $log; ?></a></li>
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
                                <a class="dropdown-item uk-text-capitalize" href="<?php echo $link; ?>"><?php echo $log; ?></a>
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
        <div class="page-header header-filter clear-filter purple-filter head" data-parallax="true" style="background-image: url('./img/1.jpg')">
            <div class="container uk-inline">
                <div class="uk-position-center text-center" uk-scrollspy="cls:uk-animation-fade">
                    <p class="uk-text-large">Collection 2018</p>
                    <h1 class="uk-heading-divider">New Arrivals</h1>
                    <a href="product.php" class="btn btn-primary btn-round"><i class="fa fa-shopping-bag"></i> Shop Now</a>
                </div>
            </div>
        </div>
            <!--<div class="row">
                <div class="col-lg-4">
                    <div class="card card-profile" style="max-width: 360px">
                        <div class="card-header card-header-image uk-inline-clip uk-transition-toggle" tabindex="0">
                                <a href="#pablo">
                                    <img class="img" src="https://cms.souqcdn.com/spring/cms/en/ae/2017_LP/women-clothing/images/women-clothing-skirts.jpg">
                                    <img class="img uk-transition-scale-up uk-position-cover" src="http://www.fashionmela.net/wp-content/uploads/2017/05/Women-Fashion-Irregular-Retro-Dress-Simple-Shape-Indian-Dress-1.jpg" alt="">
                                </a>
                            </div>
                            <div class="card-body ">
                                <button class="btn btn-primary btn-round uk-align-center">Dresses</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        <section class="first">
            <div class="container">
                <div class="row">
                    <?php
                        while($category = mysqli_fetch_array($select)) {
                    ?>
                    <div class="col-lg-4 pad">
                        <div class="uk-card uk-card-default uk-card-hover">
                            <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-width-1-1" tabindex="0">
                                <img src="admin/<?php echo $category['category_img_one']; ?>" alt="admin/<?php echo $category['category_img_one']; ?>" class="uk-width-1-1">
                                <img class="uk-transition-scale-up uk-position-cover uk-width-1-1" src="admin/<?php echo $category['category_img_two']; ?>" alt="admin/<?php echo $category['category_img_two']; ?>">
                            </div>
                            <div class="uk-card-footer">
                                <a href="product.php?category=<?php echo $category['category_name']; ?>" class="btn btn-primary btn-round uk-align-center"><?php echo $category['category_name']; ?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
        <section class="second">
            <div class="container pad">
               <!-- <div class="card">
                    <div class="card-body">
                        <p class="uk-heading-line uk-text-large uk-text-uppercase uk-text-bold uk-text-center"><span>SIGN UP & GET 20% OFF</span></p>
                        <p class="text-center">Be the frist to know about the latest fashion news and get exclu-sive offers</p>
                        <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button>
                    </div>
                </div> -->
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                            while($offer = mysqli_fetch_array($select_offer)) {
                        ?>
                        <div class="carousel-item">
                            <div class="card">
                                <div class="card-body">
                                    <p class="uk-heading-line uk-text-large uk-text-uppercase uk-text-bold uk-text-center text-primary"><span><?php echo $offer['offer_title']; ?></span></p>
                                    <p class="text-center"><?php echo $offer['offer_description']; ?></p>
                                    <div class="">
                                        <p class="uk-text-small uk-text-center text-primary uk-text-large">Offer expires in:</p>
                                        <div class="uk-grid-small uk-flex-center uk-child-width-auto" uk-grid uk-countdown="date: <?php echo $offer['expiry_date']; ?>T23:00:00+00:00">
                                            <div>
                                                <div class="uk-countdown-number uk-countdown-days uk-text-large uk-text-center uk-text-center"></div>
                                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Days</div>
                                            </div>
                                            <div class="uk-countdown-separator uk-text-large">:</div>
                                            <div>
                                                <div class="uk-countdown-number uk-countdown-hours uk-text-large uk-text-center"></div>
                                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Hours</div>
                                            </div>
                                            <div class="uk-countdown-separator uk-text-large">:</div>
                                            <div>
                                                <div class="uk-countdown-number uk-countdown-minutes uk-text-large uk-text-center"></div>
                                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Minutes</div>
                                            </div>
                                            <div class="uk-countdown-separator uk-text-large">:</div>
                                            <div>
                                                <div class="uk-countdown-number uk-countdown-seconds uk-text-large uk-text-center"></div>
                                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">Seconds</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button> -->
                                    <h2 class="text-center text-primary">Coupon Code: <?php echo base64_decode($offer['coupon_code']); ?></h2>
                                    <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <!-- <div class="carousel-item">
                            <div class="card">
                                <div class="card-body">
                                    <p class="uk-heading-line uk-text-large uk-text-uppercase uk-text-bold uk-text-center"><span>Title</span></p>
                                    <p class="text-center">Be the frist to know about the latest fashion news and get exclu-sive offers</p>
                                    <!-- <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button> -->
                                    <!--<h2 class="text-center text-primary">Coupon Code: 112233</h2>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <a class="carousel-control-prev bg-dark uk-position-center-left" href="#carouselExampleIndicators" role="button" data-slide="prev" style="height: 50px; width: 50px">
                        <span class="carousel-control-prev-icon m-3" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next bg-dark uk-position-center-right" href="#carouselExampleIndicators" role="button" data-slide="next" style="height: 50px; width: 50px">
                        <span class="carousel-control-next-icon m-3" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <!--<div class="uk-position-relative uk-visible-toggle uk-light" uk-slideshow>
                    <ul class="uk-slideshow-items">
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="uk-heading-line uk-text-large uk-text-uppercase uk-text-bold uk-text-center"><span>SIGN UP & GET 20% OFF</span></p>
                                    <p class="text-center">Be the frist to know about the latest fashion news and get exclu-sive offers</p>
                                    <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="uk-heading-line uk-text-large uk-text-uppercase uk-text-bold uk-text-center"><span>SIGN UP & GET 20% OFF</span></p>
                                    <p class="text-center">Be the frist to know about the latest fashion news and get exclu-sive offers</p>
                                    <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="uk-heading-line uk-text-large uk-text-uppercase uk-text-bold uk-text-center"><span>SIGN UP & GET 20% OFF</span></p>
                                    <p class="text-center">Be the frist to know about the latest fashion news and get exclu-sive offers</p>
                                    <button class="btn btn-primary btn-round uk-align-center" onclick="location.href = 'index.php?signup'">SIGNUP</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
                </div>-->
            </div>
        </section>
        <section class="third">
            <div class="container pad">
                <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider="autoplay: true">
                    <div class="container">
                        <h1 class="text-primary text-center">Latest Products</h1>
                        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                            <?php
                                $select_latest = mysqli_query($con, "SELECT * FROM `products` ORDER BY product_id DESC LIMIT 10");
                                while($latest = mysqli_fetch_array($select_latest)) {
                                    $latest_img = json_decode($latest['images'], true);
                            ?>
                            <li>
                                <div class="uk-panel">
                                    <div class="uk-card slide-card uk-card-default uk-card-hover" onclick="location.href = 'product_detail.php?product_view=<?php echo $latest['product_id']; ?>';">
                                        <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-width-1-1">
                                            <img src="admin/<?php echo $latest_img[0]; ?>" alt="" class="uk-width-1-1">
                                            <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                                <a href="index.php?cart=<?php echo $latest['product_id']; ?>" class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</a>
                                            </div>
                                        </div>
                                        <div class="uk-card-footer">
                                            <p class="uk-text-large"><?php echo $latest['product_name']; ?><br>&#8377;<?php echo $latest['price_per_unit']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                                }
                            ?>
                            <!-- <li>
                                <div class="uk-panel">
                                    <div class="uk-card slide-card uk-card-default">
                                        <div class="uk-card-media-top uk-inline-clip uk-transition-toggle">
                                            <img src="https://gloimg.drlcdn.com/L/pdm-product-pic/Clothing/2017/06/10/goods-img/1513110203889571742.jpg" alt="" class="uk-width-1-1">
                                            <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                                <button class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</button>
                                            </div>
                                        </div>
                                        <div class="uk-card-footer">
                                            <p class="uk-text-large">Product name<br>$10.00</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="uk-panel">
                                    <div class="uk-card slide-card uk-card-default">
                                        <div class="uk-card-media-top uk-inline-clip uk-transition-toggle">
                                            <img src="https://n2.sdlcdn.com/imgs/b/x/k/Skmei-Black-Digital-Watch-SDL102301072-1-1b805.jpg" alt="" class="uk-width-1-1">
                                            <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                                <button class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</button>
                                            </div>
                                        </div>
                                        <div class="uk-card-footer">
                                            <p class="uk-text-large">Product name<br>$10.00</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="uk-panel">
                                    <div class="uk-card slide-card uk-card-default">
                                        <div class="uk-card-media-top uk-inline-clip uk-transition-toggle">
                                            <img src="https://cdn.shopclues.com/images1/thumbnails/88685/320/320/139208125-88685866-1528374557.jpg" alt="" class="uk-width-1-1">
                                            <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                                <button class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</button>
                                            </div>
                                        </div>
                                        <div class="uk-card-footer">
                                            <p class="uk-text-large">Product name<br>$10.00</p>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                            
                        </ul>
                    </div>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover dir btn btn-primary" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover dir btn btn-primary" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
            </div>
        </section>
        <section class="fourth bg-white">
            <div class="container pad">
                <div class="row">
                    <div class="col-lg-6 uk-margin-top">
                        <div class="uk-card uk-card-default uk-card-hover uk-width-1-1">
                            <div class="uk-card-media-top uk-inline uk-inline-clip uk-transition-toggle" tabindex="0">
                                <img src="img/a.jpg" alt="" class="uk-transition-scale-up uk-transition-opaque">
                                <div class="uk-overlay uk-position-center text-white text-center">
                                    The Beauty
                                    <h1 class="uk-heading-divider text-white">LookBook</h1>
                                    <button class="btn btn-primary btn-round">View collection</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 uk-margin-top">
                        <div class="uk-card uk-card-default uk-card-hover uk-width-1-1">
                            <div class="uk-card-media-top uk-inline uk-inline-clip uk-transition-toggle" tabindex="0">
                                <img src="img/a.jpg" alt="" class="uk-transition-scale-up uk-transition-opaque">
                                <div class="uk-overlay uk-position-center text-white text-center">
                                    The Beauty
                                    <h1 class="uk-heading-divider text-white">LookBook</h1>
                                    <button class="btn btn-primary btn-round">View collection</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="fifth">
            <div class="container">
                <div class="row uk-text-center">
                    <div class="col-lg-4">
                        <div class="my-auto pad">
                            <h2>Free Delivery Worldwide</h2>
                            Click here for more info
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="my-auto pad">
                            <h2>30 Days Return</h2>
                            Simply return it within 30 days for an exchange.
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="my-auto pad">
                            <h2>Store Opening</h2>
                            Shop open from Monday to Sunday
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
                            <?php
                                $selc = mysqli_query($con, "SELECT * FROM `categories` LIMIT 5");
                                while($cat = mysqli_fetch_array($selc)) {
                            ?>
                            <li><?php echo $cat['category_name']; ?></li>
                            <?php
                                }
                            ?>
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
                        <form action="subscribe_process.php" method="POST" name="subscribe-newsletter">
                            <div class="form-group">
                                <label for="email" class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <span class="bmd-help">We'll never share your email with anyone</span>
                            </div>
                            <span class="">Want to unsubscribe? <a class="" href="#modal-center" uk-toggle>Click here</a></span>
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
        <div class="modal fade login" id="loginModal" tabindex="-1" role="">
            <div class="modal-dialog modal-login" role="document">
                <div class="modal-content">
                    <div class="card card-signup card-plain">
                        <div class="modal-header">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Log in</h4>
                                <div class="social-line">
                                    <a href="#pablo" class="btn btn-just-icon btn-link">
                                        <i class="fa fa-facebook-square"></i>
                                    </a>
                                    <a href="#pablo" class="btn btn-just-icon btn-link">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a href="#pablo" class="btn btn-just-icon btn-link">
                                        <i class="fa fa-google-plus"></i>
                                    <div class="ripple-container"></div></a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form" method="POST" action="login_process.php" name="login_form">
                                <div class="card-body">

                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <input type="text" class="form-control" name="email" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <input type="password" placeholder="Password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    </div>
                                </div>
                                <input type="submit" name="login" value="login" class="btn btn-primary">
                            <a href="forgot_password.php" class="btn btn-link btn-primary">Forgot password?</a>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-center">
                            Not a member? <a href="index.php?signup" class="btn btn-link btn-primary">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade signup" id="loginModal" tabindex="-1" role="">
            <div class="modal-dialog modal-login" role="document">
                <div class="modal-content">
                    <div class="card card-signup card-plain">
                        <div class="modal-header">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Signup</h4>
                                <div class="social-line">
                                    <a href="#pablo" class="btn btn-just-icon btn-link">
                                        <i class="fa fa-facebook-square"></i>
                                    </a>
                                    <a href="#pablo" class="btn btn-just-icon btn-link">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a href="#pablo" class="btn btn-just-icon btn-link">
                                        <i class="fa fa-google-plus"></i>
                                    <div class="ripple-container"></div></a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form" method="POST" action="signup_process.php" name="signup_form">
                                <div class="card-body">

                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <input type="text" class="form-control" name="username" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">call</i>
                                            </span>
                                            <input type="text" class="form-control" name="mobile" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <input type="text" class="form-control" name="email" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <input type="password" placeholder="Password" name="password" id="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    </div>
                                </div>
                                <input type="submit" name="signup" value="Get started" class="btn btn-primary">
                            </form>
                        </div>
                        <div class="modal-footer justify-content-center">
                            Already have an account? <a href="index.php?login" class="btn btn-link btn-primary">Login</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal-center" class="uk-flex-top unsubscribe" uk-modal>
                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    <div class="uk-modal-header">
                        <h3 class="uk-modal-title uk-text-uppercase uk-text-primary">unsubscribe newsletter</h3>
                    </div>
                    <form action="unsubscribe_process.php" method="POST" name="unsubscribe-newsletter">
                        <div class="uk-modal-body">
                                <div class="uk-margin">
                                    <input type="email" id="email" name="unsubscribe_email" class="uk-input" placeholder="Email">
                                </div>
                        </div>
                        <div class="uk-modal-footer uk-text-right">
                            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                            <input class="uk-button uk-button-primary" type="submit" value="unsubscribe" name="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        <script src="./assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
        <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/moment.min.js"></script>
        <script src="./assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
        <script src="./assets/js/material-kit.js?v=2.0.3" type="text/javascript"></script>
        <script src="js/scroll.js" type="text/javascript"></script>
        <script>
            if(window.location.href.indexOf("login") > -1) {
              $('.login').modal('show');
            }
            else if(window.location.href.indexOf("signup") > -1) {
              $('.signup').modal('show');
            }
            else if(window.location.href.indexOf("unsubscribe") > -1) {
                UIkit.modal('.unsubscribe').show();
            }
            else if(window.location.href.indexOf("s_success") > -1) {
                UIkit.notification({
                    message: 'Registered successfully!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
            else if(window.location.href.indexOf("subscribed=true") > -1) {
                UIkit.notification({
                    message: 'Subscribed successfully!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
            else if(window.location.href.indexOf("subscribed=false") > -1) {
                UIkit.notification({
                    message: 'Already Subscribed!',
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
            else if(window.location.href.indexOf("unsub=true") > -1) {
                UIkit.notification({
                    message: 'Unsubscribed successfully!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
            else if(window.location.href.indexOf("unsub=false") > -1) {
                UIkit.notification({
                    message: 'Not Subscribed yet!',
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
            else if(window.location.href.indexOf("reset=true") > -1) {
                UIkit.notification({
                    message: 'Password reset! Login to continue...',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
            else if(window.location.href.indexOf("track") > -1) {
                $('.track').modal('show');
            }
        </script>
        <script>
            $(function() {
                $("form[name='signup_form']").validate({
                    rules: {
                        username: "required",
                        email: {
                            required: true,
                            email: true
                        },
                        mobile: {
                            required: true,
                            number: true,
                            minlength: 10
                        },
                        password: {
                            required: true,
                            minlength: 6,
                            maxlength: 30
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        username: "Username shouldn't be empty",
                        email: {
                            required: "Email shouldn't be empty",
                            email: "Please enter a valid email"
                        },
                        mobile: {
                            required: "Mobile number shouldn't be empty",
                            number: "Mobile number must be an Integer",
                            minlength: "Mobile number must be atleast 10 digits"
                        },
                        password: {
                            required: "Please enter password",
                            minlength: "Password must be minimum 6 characters",
                            maxlength: "Maximum length is 30 characters"
                        },
                        confirm_password: {
                            required: "Please confirm your password",
                            equalTo: "Passwords didn't match"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
        <script>
            $(function() {
                $("form[name='login_form']").validate({
                    rules: {
                        email: "required",
                        password: {
                            required: true,
                            minlength: 6,
                            maxlength: 30
                        }
                    },
                    messages: {
                        email: "Please enter email",
                        password: {
                            required: "Please enter your password",
                            minlength: "Password must be minimum 6 characters",
                            maxlength: "Maximum length of password is 30 characters"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
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
            $(function() {
                $( "div.carousel-item" ).first().addClass( "active" );
               
            });
        </script>
    </body>
</html>