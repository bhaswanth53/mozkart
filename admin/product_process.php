<?php
    error_reporting(E_ALL ^ E_WARNING); 
    require "local.php";
    require "check.php";
    if( isset( $_POST['submit'] ) ) {

        $product_number = protect($con, $_POST['product_number']);
        $product_name = protect($con, $_POST['product_name']);
        $product_category = protect($con, $_POST['product_category']);
        $price_per_unit = protect($con, $_POST['price_per_unit']);
        $stock = protect($con, $_POST['stock']);
        $min_quantity = protect($con, $_POST['min_quantity']);
        $max_quantity = protect($con, $_POST['max_quantity']);
        $product_image = $_FILES['product_image']['name'];
        $product_color = json_encode($_POST['product_color']);
        $product_description = protect($con, $_POST['product_description']);
        $additional_information = protect($con, $_POST['additional_information']);
        $images = array();
        $specifications = array();
        if ( empty($product_number) ) {
            echo "<script>
                alert('product number should not be empty');
                window.location.href=window.history.back();
                </script>";
        }
        else if( !empty($product_number) ) {
            $sel = mysqli_query($con, "SELECT * FROM `products` WHERE product_number = '$product_number'");
            $numrows = mysqli_num_rows($sel);
            if($numrows >0) {
                echo "<script>
                alert('Product number already exists');
                window.location.href=window.history.back();
                </script>";
            }
        }
        if( empty($product_name )) {
            echo "<script>
                alert('Please enter product name');
                window.location.href=window.history.back();
                </script>";
        }
        if( empty($price_per_unit )) {
            echo "<script>
                alert('Please enter price per each unit');
                window.location.href=window.history.back();
                </script>";
        }
        if( empty($stock )) {
            echo "<script>
                alert('Please enter items available in stock');
                window.location.href=window.history.back();
                </script>";
        }
        if ( empty($min_quantity) ) {
            echo "<script>
                alert('Please enter minimim quantity of product to be purchased');
                window.location.href=window.history.back();
                </script>";
        }
        if ( empty($max_quantity) ) {
            echo "<script>
                alert('Please enter maximum quantity of product to be purchased');
                window.location.href=window.history.back();
                </script>";
        }
        if ($max_quantity > $stock) {
            echo "<script>
                alert('Maximum quantity of product must be less tha or equal to stock');
                window.location.href=window.history.back();
                </script>";
        }
        if(isset($_FILES['product_image']['name']) && !empty($_FILES['product_image']['name'])) {
            print_r($_FILES);
            if(!file_exists('gallery')) {
                mkdir('gallery', 0755);
            }
            for ($i=0; $i < count($_FILES['product_image']['name']); $i++) 
            {
                if($_FILES['product_image']['name'][$i] == "") {
                    $filepath = "";
                }
                else {
                    $filepath = 'gallery/'. $_FILES['product_image']['name'][$i];
                }
                move_uploaded_file($_FILES['product_image']['tmp_name'][$i], $filepath);
                $images[$i] = $filepath;
            }
            $product_gallery = json_encode(array_filter($images));
        }
        else if(!isset($_FILES['product_image']['name']) && empty($_FILES['product_image']['name'])){
            $product_gallery = 0;
        }
        if( empty($product_color )) {
            echo "<script>
                alert('Please select availability colors of product');
                window.location.href=window.history.back();
                </script>";
        }
        if( empty($product_description )) {
            echo "<script>
                alert('Please describe your ptoduct');
                window.location.href=window.history.back();
                </script>";
        }

        for($j=0; $j < count($_POST['specification_name']); $j++) {
            $specifications[$j] = array(protect($con, $_POST['specification_name'][$j]), protect($con, $_POST['specification_value'][$j]));
        }
        $specifications = json_encode($specifications);
        $sql ="INSERT INTO `products` (`product_id`, `product_number`, `product_name`, `product_category`, `price_per_unit`, `in_stock`, `min_quantity`, `max_quantity`, `images`, `colors`, `specifications`, `description`, `additional_information`, `availability_status`) VALUES (NULL, '$product_number', '$product_name', '$product_category', '$price_per_unit', '$stock', '$min_quantity', '$max_quantity', '$product_gallery', '$product_color', '$specifications', '$product_description', '$additional_information', 1);";
        mysqli_query($con, $sql);
        header('location: add_product.php');
    }
?>