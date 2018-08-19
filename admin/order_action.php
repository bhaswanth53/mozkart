<?php
    session_start();
    require "local.php";
    require "check.php";
    $order_id = protect($con, $_POST['order_id']);
    if( isset( $_POST['dispatched'] ) ) {
        $sql = "UPDATE `orders` SET status = 'dispatched' WHERE o_id = '$order_id'";
        if(mysqli_query($con, $sql)) {
            echo "<script>
                alert('Dispatched order!');
                window.location.href=window.history.back();
                </script>";
        }
        else {
            die(mysqli_error($con));
        }
    }
    else if( isset( $_POST['shipped'] ) ) {
        $sql = "UPDATE `orders` SET status = 'shipped' WHERE o_id = '$order_id'";
        if(mysqli_query($con, $sql)) {
            echo "<script>
                alert('Shipped order!');
                window.location.href=window.history.back();
                </script>";
        }
        else {
            die(mysqli_error($con));
        }
    }
    else if( isset( $_POST['deliver'] ) ) {
        $sql = "UPDATE `orders` SET status = 'delivered' WHERE o_id = '$order_id'";
        if(mysqli_query($con, $sql)) {
            echo "<script>
                alert('Successfully delivered order!');
                window.location.href=window.history.back();
                </script>";
        }
        else {
            die(mysqli_error($con));
        }
    }
    else {
        header("location: index.php");
    }
?>