<?php
    require "local.php";
    if( isset($_POST['submit'] ) ) {
        $product_number = $_POST['product_number'];
        $username = $_POST['name'];
        $review = $_POST['review'];
        $feedback = $_POST['comment'];
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y/m/d');
        if( empty( $username ) ) {
            $username = 'Anonymous';
        }
        if( empty( $review ) ) {
            die("Please submit your review");
        }
        $sql = "INSERT INTO `reviews` (`review_id`, `product_number`, `reviewer_name`, `review`, `comment`, `date`) VALUES (NULL, '$product_number', '$username', '$review', '$feedback', '$date');";
        $verify = ["?review=success", "?review=failure"];
        $url = str_replace($verify,'',$_SERVER["HTTP_REFERER"]);
        if(mysqli_query($con, $sql)) {
            header('location:' . $url . '?review=success');
        }
        else {
            $url = $_SERVER["HTTP_REFERER"];
            header('location:' . $url . '?review=failure');
        }
    }
?>