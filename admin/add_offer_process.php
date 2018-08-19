<?php
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "../vendor/autoload.php";
    if(file_exists("../vendor/autoload.php")){
        echo "S";
    }else{
        echo "dsfds";
    }
    require_once "../credentials.php";
    if ( isset( $_POST['submit'] ) ) {
        $coupon_code = base64_encode(protect($con, $_POST['coupon_code']));
        $offer_title = protect($con, $_POST['offer_title']);
        $offer_description = protect($con, $_POST['offer_description']);
        $discount = protect($con, $_POST['discount_price']);
        $expiry_date = protect($con, $_POST['expiry_date']);
        $date = date("Y-m-d");
        $check = mysqli_query($con, "SELECT * FROM offers WHERE coupon_code = '$coupon_code'");
        if( mysqli_num_rows($check) > 0) {
            die("Coupon code already exists");
        }
        if( empty( $coupon_code ) ) {
            die("Coupon code shouldn't be empty");
        }
        if( empty( $offer_title ) ) {
            die("Offer title shouldn't be empty");
        }
        if( empty( $offer_description ) ) {
            die("Please describe your offer");
        }
        if( empty( $discount ) ) {
            die("Please enter discount price in percentage");
        }
        if( empty( $expiry_date ) ) {
            die("Please choose empiry date of offer");
        }
        else if( $expiry_date < $date) {
            die("Invalid date");
        }
        $sql = "INSERT INTO `offers` (`offer_id`, `coupon_code`, `offer_title`, `offer_description`, `discount_price`, `expiry_date`) VALUES (NULL, '$coupon_code', '$offer_title', '$offer_description', '$discount', '$expiry_date');";
        if(mysqli_query($con, $sql)) {
            $subscribers = mysqli_query($con, "SELECT * FROM subscribers");
            $name = "Mozkart";
            $html = "
                <h3 style='text-align: center'>" . $offer_title ."</h3>
                <p style='text-align: center'>" . $offer_description . "</p>
                <p style='text-align: center'> Discount(in percentage) " . $discount . "</p>
                <h3 style='text-align: center'> Coupon Code: " . $coupon_code ."</h3>
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
            while($subscriber = mysqli_fetch_array($subscribers)) {
                echo $subscriber['subscriber_email'];
                $mail->addAddress($subscriber['subscriber_email'], 'User');
            }
            $mail->isHTML(true);
            $mail->Subject = 'New Offer From Mozkart';
            $mail->Body = $html;
            $mail->send();
            header("Location: offers.php");
        }
        else {
            die(mysqli_error($con));
        }
    }
    else {
        header("location: add_offer.php");
    }
?>