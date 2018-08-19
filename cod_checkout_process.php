<?php
    ob_start();
    session_start();
    require "local.php";
    require "check.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    require_once "credentials.php";
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        if ( isset ( $_POST['place'] ) ) {
            $order_number = protect($con, $_POST['order_number']);
            $order = base64_decode($_POST['order']);
            $total_price = protect($con, $_POST['total_price']);
            $name = protect($con, $_POST['name']);
            $email = protect($con, $_POST['email']);
            $mobile = protect($con, $_POST['mobile']);
            $payment_method = protect($con, $_POST['payment_method']);
            $billing_address = protect($con, $_POST['billing_address']);
            $delivery_address = protect($con, $_POST['delivery_address']);
            $encoded = base64_encode($order_number);

            $sql = "INSERT INTO `orders` (`o_id`, `order_number`, `name`, `email`, `mobile`, `billing_address`, `delivery_address`, `payment_method`, `payment_type`, `status`, `order_data`, `price`, `order_date`, `delivery_date`, `session`) VALUES (NULL, '$order_number', '$name', '$email', '$mobile', '$billing_address', '$delivery_address', '$payment_method', 'NULL', 'placed', '$order', '$total_price', CURDATE(), NULL, '$session_mail');";
            if(mysqli_query($con, $sql)) {
                mysqli_query($con, "DELETE FROM cart WHERE user_email = '$session_mail'");
                $ord = json_decode($order, true);
                for($j = 0; $j < count($ord); $j++) {
                    $pd = $ord[$j][0];
                    $qnt = $ord[$j][3];
                    mysqli_query($con, "UPDATE `products` SET in_stock = in_stock - $qnt WHERE product_number = '$pd';");
                }
                $name = "Mozkart";
                $html = "
                    <h1 style='text-align: center'>Order Successful!</h1>
                    <p style='text-align:center'>Your order has been placed successfully. Please use order number <b>". $order_number ."</b> for future queries. Your order will be shipped soon</p>
                    <p style='text-align:center'>Trace your order by using below link</p>
                    <a href='http://localhost/task8/index.php?track=". $encoded ."'> Trace order</a>
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
                $mail->addAddress($email, 'User');
                $mail->isHTML(true);
                $mail->Subject = 'ORDER SUCCESSFUL';
                $mail->Body = $html;
                if(!$mail->send()) {
                    header("Location: cart.php");
                }
                else {
                    header("Location: cod_success.php?success=" . $encoded);
                }
            }
            else {
                header("Location: cod_success.php?failure=" . $encoded);
            }
        }
        else {
            header("location: cart.php");
        }
    }
?>