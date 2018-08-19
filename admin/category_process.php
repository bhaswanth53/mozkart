<?php
    require "local.php";
    require "check.php";
    error_reporting(E_ALL ^ E_NOTICE);
    function check($filename, $filetype) {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $extension = end(explode(".", $filename));
        if ((($filetype == "image/gif") || ($filetype == "image/jpeg") || ($filetype == "image/jpg") || ($filetype == "image/png")) && in_array($extension, $allowedExts)) {
            return true;
        }
        else {
            return false;
        }
    }
    if( isset ($_POST['submit'] ) ) {
        $category_name = protect($con, $_POST['category_name']);
        $category_img_one = $_FILES['category_img_one'];
        $category_img_two = $_FILES['category_img_two'];
        if( empty( $category_name ) ) {
            echo "<script>
                alert('Category name must not be empty');
                window.location.href=window.history.back();
                </script>";
        }
        else if( empty( $category_img_one ) || check($category_img_one['name'], $category_img_one['type']) != true ) {
            //die("Invalid file type, Only Images are allowed");
            echo "<script>
                alert('First Image must not be empty and Must be in the given extensions JPG, JPEG, GIF, PNG');
                window.location.href=window.history.back();
                </script>";
        }
        else if( empty( $category_img_two ) || check($category_img_two['name'], $category_img_two['type']) != true ) {
            //die("Invalid file type, Only Images are allowed");
            echo "<script>
                alert('Second Image must not be empty and Must be in the given extensions JPG, JPEG, GIF, PNG');
                window.location.href=window.history.back();
                </script>";
        }
        else {
            $filepath1 = 'categories/'. $category_img_one['name'];
            $filepath2 = 'categories/'. $category_img_two['name'];
            move_uploaded_file($category_img_one['tmp_name'], $filepath1);
            move_uploaded_file($category_img_two['tmp_name'], $filepath2);
            $sql = "INSERT INTO `categories` (`category_id`, `category_name`, `category_img_one`, `category_img_two`) VALUES (NULL, '$category_name', '$filepath1', '$filepath2');";
            mysqli_query($con, $sql);
            header('location: category.php?success');
        }
    }
    else {
        header('location: category.php');
    }
?>