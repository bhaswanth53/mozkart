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
        $d = 'd-block';
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
        $d = 'd-none';
    }
    if (isset($_GET['product_view'])) {
        $view = protect($con, $_GET['product_view']);
        $select_product = mysqli_query($con, "SELECT * FROM `products` WHERE product_id = '$view'");
        $product = mysqli_fetch_array($select_product);
        $pnum = $product['product_number'];
        $cat = $product['product_category'];
        $images = json_decode($product['images'], true);
        $colors = json_decode($product['colors'], true);
        $specifications = json_decode($product['specifications'], true);
        $select_reviews = mysqli_query($con, "SELECT * FROM `reviews` WHERE product_number ='$pnum'");
        $numrows = mysqli_num_rows($select_reviews);
        $related = mysqli_query($con, "SELECT * FROM `products` WHERE product_category ='$cat'");
    }
    else {
        header('location: product.php');
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
                        <li class="nav-item d-block d-lg-none"><a class="nav-link" href="logut.php"><i class="fa fa-sign-out" style="font-size:24px"></i> Logout</a></li>
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
        <div class="container uk-margin-top">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="product.php">Shop</a></li>
                    <li class="breadcrumb-item"><a href="product.php?category=<?php echo $product['product_category']; ?>"><?php echo $product['product_category']; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $product['product_name']; ?></li>
                </ol>
            </nav>
        </div>
        <section class="ek">
            <div class="container pad">
                <div class="row">
                    <div class="col-md-4 col-lg-2 d-none">
                        <div class="row">
                            <div class="col-4 col-lg-12">
                                <a href="#" class="selected thumbnail" data-big="img/p1.jpg">
                                    <div class="thumbnail-image" style="background-image: url(img/p1.jpg)"></div>
                                </a>
                                </div>
                                <div class="col-4 col-lg-12">
                                <a href="#" class="thumbnail" data-big="img/p2.jpg">
                                    <div class="thumbnail-image" style="background-image: url(img/p2.jpg)"></div>
                                </a>
                                </div>
                                <div class="col-4 col-lg-12">
                                <a href="#" class="thumbnail" data-big="img/p3.jpg">
                                    <div class="thumbnail-image" style="background-image: url(img/p3.jpg)"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-5 d-none">
                        <main class="primary" style="background-image: url(<?php echo $images[0]; ?>)"></main>
                    </div>
                    <div class="col-md-12 col-lg-7">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <main class="primary" style="background-image: url(admin/<?php echo $images[0]; ?>)"></main>
                                </div>
                                <div class="col-12">
                                    <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider>
                                        <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                                            <?php
                                                foreach($images as $image) {
                                            ?>
                                            <li>
                                                <div class="uk-panel">
                                                    <a href="#" class="selected thumbnail" data-big="admin/<?php echo $image; ?>">
                                                        <div class="thumbnail-image" style="background-image: url(admin/<?php echo $image; ?>)"></div>
                                                    </a>
                                                </div>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                                        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div class="row">
                            <div class="col-12">
                                <p class="uk-text-large text-primary"><?php echo $product['product_name']; ?><br><span class="text-muted">&#8377;<?php echo $product['price_per_unit']; ?></span></p>
                            </div>
                            <div class="col-12">
                                <form action="item_process.php" method="POST">
                                    <!-- <p class="uk-text-small">Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.</p> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="uk-margin">
                                                <label>Quantity:</label>
                                                <input class="uk-input" type="number" min="<?php echo $product['min_quantity']; ?>" max="<?php echo $product['max_quantity']; ?>" value="<?php echo $product['min_quantity']; ?>" name="quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="uk-margin">
                                                <label>Wishlist</label>
                                                <select class="uk-select" name="wishlist_name">
                                                    <option value="">Select Wishlist</option>
                                                    <?php
                                                        $select_wp = mysqli_query($con, "SELECT * FROM wishlist WHERE user_email ='$session_mail'");
                                                        while($wp = mysqli_fetch_array($select_wp)) {
                                                    ?>
                                                    <option value="<?php echo $wp['wishlist']; ?>"><?php echo $wp['wishlist']; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="color-checkboxes">
                                        <?php
                                            foreach($colors as $color) {
                                        ?>
                                        <input class="color-checkbox__input" type="radio" name="color" id="col-<?php echo $color; ?>" value="<?php echo $color; ?>">
                                        <label class="color-checkbox Pink" for="col-<?php echo $color; ?>" id="col-Pink-label" style="background: <?php echo $color; ?>"></label>
                                        <?php
                                            }
                                        ?>		
                                    </div>
                                    <input type="hidden" name="product_number" value="<?php echo $product['product_number']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $product['price_per_unit']; ?>">
                                    <input type="hidden" name="product_image" value="<?php echo $images[0]; ?>">
                                    <input type="hidden" name="user_email" value="<?php echo $session_mail; ?>">
                                    <input type="submit" name="cart" class="btn btn-primary btn-round" value="Add to cart">
                                    <button type="submit" name="wish" class="btn btn-rose btn-fab btn-round"><i class="fa fa-heart"></i></button>
                                </div>
                            </form>
                            <div class="uk-margin-top mx-auto">
                            <!-- AddToAny BEGIN -->
                            <label>Share with</label>
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <!-- <a class="a2a_dd" href="https://www.addtoany.com/share"></a> -->
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_twitter"></a>
                                <a class="a2a_button_google_plus"></a>
                                <a class="a2a_button_email"></a>
                                <a class="a2a_button_linkedin"></a>
                                <a class="a2a_button_whatsapp"></a>
                            </div>
                            <script async src="//static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="dho">
            <div class="container pad">
                <ul class="uk-list-divider" uk-accordion>
                    <li>
                        <a class="uk-accordion-title" href="#">Description</a>
                        <div class="uk-accordion-content">
                            <?php echo $product['description']; ?>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title" href="">Specifications</a>
                        <div class="uk-accordion-content">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Specification Chart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($specifications as $specification) {
                                    ?>
                                    <tr>
                                        <td><?php echo $specification[0]; ?>r</td>
                                        <td><?php echo $specification[1]; ?></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </li>
                    <li>
                        <a class='uk-accordion-title' href="">Additional Information</a>
                        <div class="uk-accordion-content">
                            <?php echo $product['additional_information']; ?>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title" href="">Reviews</a>
                        <div class="uk-accordion-content">
                            <?php
                                if($numrows > 0) {
                                    while($review = mysqli_fetch_array($select_reviews)) {
                            ?>
                            <article class="uk-comment uk-margin">
                                <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                        <span class="uk-comment-avatar"><i class="material-icons" style="font-size:55px">account_circle</i></span>
                                    </div>
                                    <div class="uk-width-expand">
                                        <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#"><?php echo $review['reviewer_name']; ?></a></h4>
                                        <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                            <li><?php echo $review['date']; ?></li>
                                        </ul>
                                    </div>
                                </header>
                                <div class="uk-comment-body">
                                    <p class="font-size"><span class="text-primary">Review:</span><?php echo $review['review']; ?></p>
                                    <p class="font-size"><?php echo $review['comment']; ?></p>
                                </div>
                            </article>
                            <hr class="uk-divider-icon">
                            <?php
                                    }
                                }
                                else {
                                    echo "<p class='text-center text-primary uk-text-large'>No reviews yet!</p>";
                                }
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="<?php echo $d; ?>">
            <div class="container py-5">
                <h1 class="text-primary uk-text-center">Feedback Product</h1>
                <div class="">
                    <form action="review_process.php" class="uk-width-1-2@m uk-align-center" method="POST">
                        <input type="hidden" name="product_number" value="<?php echo $product['product_number']; ?>">
                        <div class="uk-margin">
                            <label for='name'>Name:</label>
                            <input type="text" name="name" class="uk-input" value="<?php echo $user_data['username']; ?>">
                        </div>
                        <div class="uk-margin">
                            <label for='review'>Review:</label>
                            <select class="uk-select" name="review">
                                <option>Excellent</option>
                                <option>Satisfied</option>
                                <option>Good</option>
                                <option>Average</option>
                                <option>Poor</option>
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label for="comment">Comment:</label>
                            <textarea class="uk-textarea" rows="5" name="comment"></textarea>
                        </div>
                        <input type="submit" name="submit" value="Feedback" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </section>
        <section class="third">
            <div class="container pad">
                <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider="autoplay: true">
                    <div class="container">
                        <h1 class="text-primary text-center">Related Products</h1>
                        <ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">
                            <?php
                                if(mysqli_num_rows($related) > 0) {
                                    while($related_product = mysqli_fetch_array($related)) {
                                        $img = json_decode($related_product['images'], true);
                            ?>
                            <li>
                                <div class="uk-panel">
                                    <div class="uk-card slide-card uk-card-default uk-card-hover" onclick="location.href = 'product_detail.php?product_view=<?php echo $related_product['product_id']; ?>';">
                                        <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-width-1-1">
                                            <img src="admin/<?php echo $img[0]; ?>" alt="" class="uk-width-1-1">
                                            <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                                <button class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</button>
                                            </div>
                                        </div>
                                        <div class="uk-card-footer">
                                            <p class="uk-text-large"><?php echo $related_product['product_name']; ?><br>&#8377;<?php echo $related_product['price_per_unit']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                                    }
                                }
                            ?>                
                        </ul>
                    </div>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover dir btn btn-primary" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover dir btn btn-primary" href="#" uk-slidenav-next uk-slider-item="next"></a>
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
            $('.thumbnail').on('click', function() {
                var clicked = $(this);
                var newSelection = clicked.data('big');
                var $img = $('.primary').css("background-image","url(" + newSelection + ")");
                clicked.parent().find('.thumbnail').removeClass('selected');
                clicked.addClass('selected');
                $('.primary').empty().append($img.hide().fadeIn());
            });
        </script>
        <script>
            $('.color-checkboxes').each(function(){
                $(this).find('input[type=radio]:first').attr('checked', true);
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
        <?php
            if($product['max_quantity'] <= $product['in_stock']) {
                $max_quantity = $product['max_quantity'];
            }
            else {
                $max_quantity = $product['in_stock'];
            }
        ?>
        <script>
            $("input[name='quantity']").on('input', function () {  
                var value = $(this).val();  
                if ((value !== '') && (value.indexOf('.') === -1)) {    
                    $(this).val(Math.max(Math.min(value, <?php echo $max_quantity; ?>), <?php echo $product['min_quantity']; ?>));
                }
            });
        </script>
    </body>
</html>