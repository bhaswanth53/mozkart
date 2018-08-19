<?php
    ob_start();
    session_start();
    if(!empty($_SESSION["email"])) {
        $session_mail = $_SESSION['email'];
        if( isset ($_POST['proceed'] ) ) {
            $order = base64_decode($_POST['order']);
            $name = $_POST['firstname'];
            $email = $_POST['email'];
            $mobile = $_POST['phone'];
            $total_price = $_POST['amount'];
            $payment_method = $_POST['payment_method'];
            $payment_type = $_POST['payment_type'];
            $delivery_address = $_POST['delivery_address'];
            $sql = "INSERT INTO `orders` (`o_id`, `order_number`, `name`, `email`, `mobile`, `billing_address`, `delivery_address`, `payment_method`, `payment_type`, `status`, `order_data`, `price`) VALUES (NULL, '$order_number', '$name', '$email', '$mobile', 'NULL', '$delivery_address', '$payment_method', '$payment_type', 'NULL', '$order', '$total_price');";
            mysqli_query($con, $sql) or die(mysqli_error($con));
        }
        if(!empty($_POST)) {
            //print_r($_POST);
        foreach($_POST as $key => $value) {    
            $posted[$key] = $value;	
        }
        }
        $formError = 0;
        if(empty($posted['txnid'])) {
        // Generate random transaction id
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        } else {
        $txnid = $posted['txnid'];
        }
        $hash = '';
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if(empty($posted['hash']) && sizeof($posted) > 0) {
        if(
                empty($posted['key'])
                || empty($posted['txnid'])
                || empty($posted['amount'])
                || empty($posted['firstname'])
                || empty($posted['email'])
                || empty($posted['phone'])
                || empty($posted['productinfo'])
                || empty($posted['surl'])
                || empty($posted['furl'])
                
        ) {
            $formError = 1;
        } else {
            //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';	
            foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
            }

            $hash_string .= $SALT;

            //echo $hash_string;
            
            $hash = strtolower(hash('sha512', $hash_string));
            
            $action = $PAYU_BASE_URL . '/_payment';
        }
        } elseif(!empty($posted['hash'])) {
        $hash = $posted['hash'];
        $action = $PAYU_BASE_URL . '/_payment';
        }
    }
?>