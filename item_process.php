<?php
    require "local.php";
    require "check.php";
    $product_number = protect($con, $_POST['product_number']);
    $product_name = protect($con, $_POST['product_name']);
    $product_image = protect($con, $_POST['product_image']);
    $color = protect($con, $_POST['color']);
    $quantity = protect($con, $_POST['quantity']);
    $user_email = protect($con, $_POST['user_email']);
    $wishlist = protect($con, $_POST['wishlist_name']);
    $price = protect($con, $_POST['product_price']);
    if( empty($color) ) {
        die("Please select color");
    }

    if( isset( $_POST['cart'] ) ) {
        $check = mysqli_query($con, "SELECT * FROM cart WHERE product_number = '$product_number' AND user_email = '$user_email'");
        if(mysqli_num_rows($check) > 0) {
            header("location: cart.php");
        }
        else {
            $check_stock = mysqli_query($con, "SELECT * FROM products WHERE product_number = '$product_number'");
            $selpro = mysqli_fetch_array($check_stock);
            $stock = $selpro['in_stock'];
            if($quantity <= $stock) {
                $sql = "INSERT INTO `cart` (`cart_id`, `product_number`, `product_name`, `product_image`, `quantity`, `color`, `user_email`, `price`) VALUES (NULL, '$product_number', '$product_name', '$product_image', '$quantity', '$color', '$user_email', '$price');";
                if(mysqli_query($con, $sql)) {
                    header('location: cart.php');
                }
                else {
                    die(mysqli_error($con));
                }
            }
            else {
                die("Out of stock");
            }
        }
    }
    if( isset($_POST['wish'] ) ) {
        if( empty( $wishlist ) ) {
            $wishlist = "General";
            $sel = mysqli_query($con, "SELECT * FROM wishlist WHERE wishlist = '$wishlist' AND user_email = '$user_email'");
            if(mysqli_num_rows($sel) == 0) {
                mysqli_query($con, "INSERT INTO `wishlist` (`w_id`, `wishlist`, `user_email`) VALUES (NULL, '$wishlist', '$user_email');");
            }
        }
        $test = mysqli_query($con, "SELECT * FROM wishlist_product WHERE wishlist='$wishlist' AND user_email = '$user_email' AND product_number = '$product_number'");
        if(mysqli_num_rows($test) > 0) {
            header("location: wishlist.php");
        }
        else {
            $sqli = "INSERT INTO `wishlist_product` (`wp_id`, `wishlist`, `user_email`, `product_number`) VALUES (NULL, '$wishlist', '$user_email', '$product_number');";
            if(mysqli_query($con, $sqli)) {
                header("location: wishlist.php");
            }
            else {
                die(mysqli_error($con));
            }
        }
    }
    else {
        header('location:' . $_SERVER["HTTP_REFERER"]);
    }
?>