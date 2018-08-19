<?php
    error_reporting(E_ALL ^ E_WARNING);
	session_start();
	if ( !empty($_SESSION['admin'] ) ) {
		$session_mail = $_SESSION['admin'];	
		require "local.php";
		require "check.php";
		if( isset( $_POST['submit'] ) ) {
			$id = protect($con, $_POST['id']);
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
			$files_count=0;
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
			}
		 


			$files_count=count(array_filter($images));
			if(isset($_POST['product_img'] ) && !empty($_POST['product_img'] )  ){
				for($k = 0; $k < count($_POST['product_img']); $k++) {
					$images[$files_count] = $_POST['product_img'][$k];
					$files_count++;
				}
			}
			
	/*         if( !empty($_POST['product_img'] ) ) {
				for($k = count($images); $k < count($_POST['product_img']); $k++) {
					$images[$k] = $_POST['product_img'][$k];
				}
			}  */
			/*if( !empty($_POST['product_img'] ) ) {
				for($k = 0; $k < count($_POST['product_img']); $k++) {
					array_push($images, $_POST['product_img'][$i]);
				}
			}*/
			if( empty($product_color )) {
				echo "<script>
                alert('Please enter availability colors of product');
                window.location.href=window.history.back();
                </script>";
			}
			if( empty($product_description )) {
				echo "<script>
                alert('Please describe your product');
                window.location.href=window.history.back();
                </script>";
			}

			for($j=0; $j < count($_POST['specification_name']); $j++) {
				$specifications[$j] = array($_POST['specification_name'][$j], $_POST['specification_value'][$j]);
			}
			//die(print_r($_POST['product_img']));


			$product_gallery = json_encode(array_filter($images));
			$specifications = json_encode($specifications);
			$update = mysqli_query($con,"UPDATE products SET product_name='$product_name', product_category='$product_category', price_per_unit='$price_per_unit', in_stock='$stock', min_quantity='$min_quantity', max_quantity='$max_quantity', images='$product_gallery', colors='$product_color', specifications='$specifications', `description` ='$product_description', additional_information='$additional_information' where product_id='$id'");
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
	}
	else {
		header("location: login.php");
	}
?>