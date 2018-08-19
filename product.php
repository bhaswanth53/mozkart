<?php
    session_start();
    require "local.php";
    require "check.php";
    $select = mysqli_query($con, "SELECT * FROM `colors`");
    $select_category = mysqli_query($con, "SELECT * FROM `categories`");
    //$select_product = mysqli_query($con, "SELECT * FROM `products` WHERE availability_status = 1");
    $sel_product = mysqli_query($con, "SELECT MIN(  `price_per_unit` ) AS  `lowest` , MAX(  `price_per_unit` ) AS  `highest` FROM  `products`");
   
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


    $sql="SELECT * FROM `products` where availability_status = 1 AND in_stock > 0" ;

    
    if( isset( $_POST['filter'] ) ) {
        $min = round($_POST['min']);
        $max = round($_POST['max']);
        //$select_product = mysqli_query($con, WHERE  ");
        $sql=$sql." AND price_per_unit >= $min AND price_per_unit <= $max";
    }
    if (isset($_GET['category'])) {
        $category = protect($con, $_GET['category']);
        if ( $category == "All") {
            $category = "All Products";
            $sql=$sql;
            $sel_product = mysqli_query($con, "SELECT MIN(  `price_per_unit` ) AS  `lowest` , MAX(  `price_per_unit` ) AS  `highest` FROM  `products`");
        }
        else { 
            $sql=$sql." AND product_category = '$category'";
            $sel_product = mysqli_query($con, "SELECT MIN(  `price_per_unit` ) AS  `lowest` , MAX(  `price_per_unit` ) AS  `highest` FROM  `products` WHERE product_category = '$category'");
        }
    }
    else {
        $category = "All Products";
    }

    $select_product = mysqli_query($con, $sql);


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
        $check = mysqli_query($con, "SELECT * FROM cart WHERE product_number = '$product_number' AND user_email = '$session_mail'");
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
    $price = mysqli_fetch_array($sel_product);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Products</title>
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="css/style.css"/>
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
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
        <div class="page-header header-filter clear-filter purple-filter one" data-parallax="false" style="background-image: url('./img/2.jpg')">
            <div class="container uk-inline">
                <div class="uk-position-center text-center" uk-scrollspy="cls:uk-animation-fade">
                    <p class="uk-text-small">Collection 2018</p>
                    <h1 class="uk-heading-divider text-white uk-text-uppercase"><?php echo $category; ?></h1>
                    <p class="uk-text-large">New Arrivals Collection 2018</p>
                </div>
            </div>
        </div>
        <section class="two">
            <div class="container pad">
                <div class="row">
                    <div class="col-lg-3">
                        <h3 class="text-primary">Categories</h3>
                        <ul class="uk-list">
                            <li><a class="uk-link-text" href="product.php?category=All">All</a></li>
                            <?php
                                while($category = mysqli_fetch_array($select_category)) {
                            ?>
                            <li><a class="uk-link-text" href="product.php?category=<?php echo $category['category_name']; ?>"><?php echo $category['category_name']; ?></a><li>
                            <?php
                                }
                            ?>
                        </ul>
                        <h3 class="text-primary uk-heading-divider">Filter</h3>
                        <p class="bold h5">Price</p>
                        <div id="sliderDouble" class="slider slider-primary"></div>
                        <!--<div id="slider-range"></div>-->
                        <!-- <p class="uk-align-center" id="amount"><span id="amount-min"><?php //echo $price['lowest']; ?></span> - <span id="amount-max"><?php //echo $price['highest']; ?></span></p> -->
                        <form action ="" method="POST" class="uk-grid-small" uk-grid>
                            <div class="uk-inline uk-width-1-2">
                                <span class="uk-form-icon px-5">&#8377;</span>
                                <input name="min" class="uk-input uk-width-1-1" id="amount-min" value="<?php  echo $price['lowest']; ?>" readonly>
                            </div>
                            <div class="uk-inline uk-width-1-2">
                                <span class="uk-form-icon px-5">&#8377;</span>
                                <input name="max" class="uk-input uk-width-1-1" id="amount-max" value="<?php  echo $price['highest']; ?>" readonly>
                            </div><br>
                            <input type="submit" name="filter" value="filter" class="btn btn-primary btn-round btn-sm">
                        </form>
                        <hr>
                        <!-- <h3 class="text-primary">Colors</h3> -->
                        <!--<input id="1" class="checkbox" type="checkbox" value="red"></input>
                        <label for="1"></label>
                        <input id="2" class="checkbox" type="checkbox" value="orange"></input>
                        <label for="2"></label>
                        <input id="3" class="checkbox" type="checkbox" value="yellow"></input>
                        <label for="3"></label>-->
                        
                        <form action="" method="POST" class="pad">
                            <!--<div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>
                                    <input class="uk-input bg-transparent" type="text" placeholder="search...">
                                </div>
                            </div> -->   
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">search</i>
                                </span>
                                </div>
                                <input type="text" class="form-control" id="search-product" placeholder="search">
                            </div>            
                        </form>
                    </div>
                    <div class="col-lg-9">
                        <!-- <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="uk-margin">
                                    <select class="uk-select">
                                        <option>Default Sorting</option>
                                        <option>Popularity</option>
                                        <option>Newest</option>
                                        <option>Oldest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="uk-margin">
                                    <select class="uk-select">
                                        <option>Price</option>
                                        <option>Low to High</option>
                                        <option>High to Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <p class="uk-text-small text-right my-2">Showing 1–12 of 16 results</p>
                            </div>
                        </div> -->
                        <div class="row pad" id="itemsContainer">
                            <?php
                                while($product = mysqli_fetch_array($select_product)) {
                                    $image = json_decode($product['images'], true);
                                    $stock = $product['in_stock'];
                                    $pid = $product['product_id'];
                                    if($stock != 0) {
                                        $mes = "<span class='uk-text-success'>Yes</span>";
                                    }
                                    else {
                                        $mes = "<span class='uk-text-danger'>No!</span>";
                                    }
                            ?>
                            <div class="col-sm-6 col-lg-4 pad name item" data-price="<?php echo $product['price_per_unit']; ?>">
                                <div class="uk-card slide-card uk-card-default uk-card-hover" onclick="location.href = 'product_detail.php?product_view=<?php echo $pid; ?>';">
                                    <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-width-1-1">
                                        <img src="admin/<?php echo $image[0]; ?>" alt="" class="uk-width-1-1">
                                        <div class="uk-transition-slide uk-overlay uk-position-bottom uk-width-1-1 uk-height-1-1 uk-overlay-default">
                                            <a href="product.php?cart=<?php echo $pid ?>" class="btn btn-primary btn-round uk-align-center uk-position-center">Add to cart</a>
                                        </div>
                                    </div>
                                    <div class="uk-card-footer">
                                        <p class="uk-text-large"><?php echo $product['product_name']; ?><br><span class="font-size price">&#8377;<?php echo $product['price_per_unit']; ?></span></p>
                                        <label>In stock: <?php echo $mes; ?></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination">
                                <!--<li class="page-item disabled">
                                <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                                </li>-->
                            </ul>
                        </nav>
                        <ul class="pagination"></li>
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
        <?php
            if (isset($_POST['min']) && isset($_POST['max'])) {
                $min = $_POST['min'];
                $max = $_POST['max'];
            }
            else {
                $min = $price['lowest'];
                $max = $price['highest'];
            }
        ?>
        <script src="./assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
        <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/moment.min.js"></script>
        <script src="./assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
        <script src="./assets/js/material-kit.js?v=2.0.3" type="text/javascript"></script>
        <script src="js/scroll.js" type="text/javascript"></script>
        <script src="//getuikit.com/assets/uikit/dist/js/uikit.js?nc=7576"></script>
        
        <script src="js/page.js" type="text/javascript"></script>
        <script>
            //filter_color
            $('#filter-group9').ready(function(){
                $('#1').toggleClass('ch_red');
                $('#2').toggleClass('ch_orange');
                $('#3').toggleClass('ch_yellow');
                $('#4').toggleClass('ch_green');
                $('#5').toggleClass('ch_blue');
                $('#6').toggleClass('ch_violet');
                $('li > label:contains(0)').toggleClass('none');
            });
        </script>
        <!--<script>
            $('.tab-content').on('click','.sortByPrice',function(){

                var sorted = $('.name').sort(function(a,b){
                    return (ascending ==
                        (convertToNumber($(a).find('.price').html()) < 
                            convertToNumber($(b).find('.price').html()))) ? 1 : -1;
                });
                ascending = ascending ? false : true;

                $('.name').html(sorted);
            });

            var convertToNumber = function(value){
                return parseFloat(value.replace('$',''));
            }
        </script>-->
        <script type="text/javascript">
           var slider2 = document.getElementById('sliderDouble');

            noUiSlider.create(slider2, {
                start: [ <?php echo $min; ?>, <?php echo $max; ?> ],
                connect: true,
                range: {
                    min:  <?php echo $price['lowest']; ?>,
                    max:  <?php echo $price['highest']; ?>
                }
            });

            var skipValues = [
                document.getElementById('amount-min'),
                document.getElementById('amount-max')
            ];
            slider2.noUiSlider.on('update', function( values, handle ) {
                skipValues[handle].value = values[handle];
            });
        </script>
        <!--<script>
            $(function() {
                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: 20000,
                    values: [0, 10000],
                    animate: true,
                    step: 5,
                    slide: function(event, ui) {
                        $("#amount-min").text(ui.values[0]);
                        $("#amount-max").text(ui.values[1]);
                    
                    }
                });

                $("#amount-min").text($("#slider-range").slider("values", 0));
                $("#amount-max").text($("#slider-range").slider("values", 1));
                
            });

        </script>-->
        <script>
            $(document).ready(function(){
                $("#search-product").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#itemsContainer .item").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
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
    </body>
</html>