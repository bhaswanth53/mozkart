<?php
    require "local.php";
    function protect($con, $string) {
        $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
        $string = mysqli_real_escape_string($con, trim(strip_tags(addslashes($string))));
        return $string;
    }
?>