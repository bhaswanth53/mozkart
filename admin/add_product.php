<?php
	session_start();
	if ( !empty($_SESSION['admin'] ) ) {
		$session_mail = $_SESSION['admin'];
		require "local.php";
		$select_color = mysqli_query($con, "SELECT * FROM `colors`");
		$select_category = mysqli_query($con, "SELECT * FROM `categories`");
	}
	else {
		header("location: login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">
    <link href="css/own.css" rel="stylesheet" type="text/css">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Startmin</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown navbar-inverse">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                    </li>
                    <li>
                        <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-cube fa-fw"></i> UI Components<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="colors.php"><i class="fa fa-cog"></i> Manage Colors</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-cube fa-fw"></i> Products<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="products.php"><i class="fa fa-cog"></i> Manage Products</a>
                            </li>
                            <li>
                                <a href="add_product.php"><i class="fa fa-plus-circle"></i> Add Product</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="category.php"><i class="fa fa-dashboard fa-fw"></i> Categories</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-gift fa-fw"></i> Offers<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="offers.php"><i class="fa fa-cog"></i> Manage Offers</a>
                            </li>
                            <li>
                                <a href="add_offer.php"><i class="fa fa-plus-circle"></i> Add Offer</a>
                            </li>
                        </ul>
                    </li>
                    <!--<li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>-->
                </ul>

            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Products</h1>
                </div>
            </div>
            <h2>Add Product</h2><br>
            <form class="form-horizontal" action="product_process.php" method="POST" enctype="multipart/form-data" name="product_add">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="product_number">Product Number:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_number" name="product_number" placeholder="Product_number">
                        <input type="checkbox" id="random">Generate Automatically
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="product_name">Product Name:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Prodct Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="category" class="col-sm-2 control-label">Category:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="category" name="product_category">
                            <?php
                                while($category = mysqli_fetch_array($select_category)) {
                            ?>
                            <option><?php echo $category['category_name']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="price_per_unit">Price Per Unit:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="price_per_unit" name="price_per_unit" placeholder="Price Per Unit">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="stock">Stock:</label>
                    <div class="col-sm-10"> 
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="In Stock">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="min_quantity">Minimum Quantity:</label>
                    <div class="col-sm-10"> 
                        <input type="number" class="form-control" id="min_quantity" name="min_quantity" placeholder="Minimum Quantity">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="max_quantity">Maximum Quantity:</label>
                    <div class="col-sm-10"> 
                        <input type="number" class="form-control" id="max_quantity" name="max_quantity" placeholder="Maximum Quantity">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="product_image[]">Product Images:</label>
                    <div class="col-sm-10 gallery_wrap" id="gallery">
                        <div class="img-wrap">
                            <input type="file" class="form-control pr_image" id="product_image[]" name="product_image[]">
                            <a href="javascript:void(0);" class="btn btn-info" id="add_image"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="product_color[]">Product Colors:</label>
                    <div class="col-sm-10">
                        <div class="color-checkboxes">
                            <?php
                                while($color = mysqli_fetch_array($select_color)) {
                            ?>
                            <input class="color-checkbox__input" type="checkbox" id="col-<?php echo $color['id']; ?>" value="<?php echo $color['color_code']; ?>" name="product_color[]"/>
                            <label class="color-checkbox" for="col-<?php echo $color['id']; ?>" id="col-Pink-label" style="background: <?php echo $color['color_code']; ?>"></label>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="specifications">Specifications:</label>
                    <div class="col-sm-10 sp_wrap">
                        <div class="spec-wrap">
                            <input type="text" class="form-control" id="specification_name[]" name="specification_name[]" placeholder="Name">
                            <input type="text" class="form-control" id="specification_value[]" name="specification_value[]" placeholder="Value">
                            <a href="javascript:void(0);" class="btn btn-info" id="add_spec"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="product_description">Description:</label>
                    <div class="col-sm-10"> 
                        <textarea class="form-control" rows="5" id="product_description" name="product_description" placeholder="Product Description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="additional_information">Additional Information:</label>
                    <div class="col-sm-10"> 
                        <textarea class="form-control" rows="5" id="additional_information" name="additional_information" placeholder="Additional Information"></textarea>
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-primary btn-large" value="Submit" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
    var addHobby = $('#add_image'); //Add button selector
    var hobbywrapper = $('.gallery_wrap'); //Input field wrapper
    var hobbyHTML = '<div class="img-wrap"><input type="file" class="form-control pr_image" id="product_image[]" name="product_image[]"><a href="javascript:void(0);" class="btn btn-info" id="add_image"><i class="fa fa-plus"></i></a><a href="javascript:void(0);" class="btn btn-danger" id="remove_image"><i class="fa fa-close"></i></a></div>'; //New input field html 
    var y = 1; //Initial field counter is 1
    $(hobbywrapper).on('click', '#add_image', function(){ //Once add button is clicked
        y++; //Increment field counter
        $(hobbywrapper).append(hobbyHTML); // Add field html
    });
    $(hobbywrapper).on('click', '#remove_image', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        y--; //Decrement field counter
    });
    $('#gallery').on('change', '.pr_image', function() {
		var ext = this.value.match(/\.(.+)$/)[1];
		switch(ext)
		{
			case 'jpg':
			case 'jpeg':
			case 'JPEG':
			case 'bmp':
			case 'png':
			case 'gif':
				$(this).css('color', 'green');
				break;
			default:
				alert("Images only!");
				this.value='';
		}
	});
});

</script>
<script>
    $(document).ready(function(){
    var addColor = $('#add_color'); //Add button selector
    var colorwrapper = $('.select_wrap'); //Input field wrapper
    var colorHTML = '<div class="color-wrap"><select class="form-control" id="color[]" name="color[]"><option style="background-color: green">Color</option><option style="background-color: red">Color</option><option style="background-color: yellow">Color</option></select><a href="javascript:void(0);" class="btn btn-info" id="add_color"><i class="fa fa-plus"></i></a><a href="javascript:void(0);" class="btn btn-danger" id="remove_color"><i class="fa fa-close"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(colorwrapper).on('click', '#add_color', function(){ //Once add button is clicked
        x++; //Increment field counter
        $(colorwrapper).append(colorHTML); // Add field html
    });
    $(colorwrapper).on('click', '#remove_color', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        y--; //Decrement field counter
    });
});

</script>
<script>
    $(document).ready(function(){
    var addSpec = $('#add_sppec'); //Add button selector
    var specwrapper = $('.sp_wrap'); //Input field wrapper
    var specHTML = '<div class="spec-wrap"><input type="text" class="form-control" id="specification_name[]" name="specification_name[]" placeholder="Name"><input type="text" class="form-control" id="specification_value[]" name="specification_value[]" placeholder="Value"><a href="javascript:void(0);" class="btn btn-info" id="add_spec"><i class="fa fa-plus"></i></a><a href="javascript:void(0);" class="btn btn-danger" id="remove_spec"><i class="fa fa-close"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(specwrapper).on('click', '#add_spec', function(){ //Once add button is clicked
        x++; //Increment field counter
        $(specwrapper).append(specHTML); // Add field html
    });
    $(specwrapper).on('click', '#remove_spec', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        y--; //Decrement field counter
    });
});

</script>
<script>
    function randomstring() {
        var chars = "0123456789";
        var string_length = 10;
        var randomstring ="";
        for( var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random()*chars.length);
            randomstring += chars.substring(rnum, rnum+1);
        }
        return randomstring;
    }
    $('#random').on('click', function(){
        if($(this).prop("checked") === true){
            $("#product_number").val(randomstring());
        }
        else {
            $("#product_number").val('');
        }
    });
</script>
<script>
    $("input[name='min_quantity']").on('input', function () {  
        var value = $(this).val();  
        var min = 1;
        var stock = $("input[name='stock']").val();
        if ((value !== '') && (value.indexOf('.') === -1)) {    
            $(this).val(Math.max(Math.min(value, stock), 1));
        }
    });
    $("input[name='max_quantity']").on('input', function () {  
        var value = $(this).val();  
        var min = $("input[name='min_quantity']").val();
        var stock = $("input[name='stock']").val();
        if ((value !== '') && (value.indexOf('.') === -1)) {    
            $(this).val(Math.max(Math.min(value, stock), min));
        }
    });
</script>
<script>
	$(function() {
		$("form[name='product_add']").validate({
			rules: {
				product_number: {
                    required: true,
                    number: true
                },
				product_name: "required",
                price_per_unit: "required",
                stock: {
                    required: true,
                    number: true
                },
                min_quantity: {
                    required: true,
                    number: true
                },
                max_quantity: {
                    required: true,
                    number: true
                },
                product_description: "required"
			},
			messages: {
				product_number: {
                    required: "Product number shouldn't be empty",
                    number: "Product number must be an integer value"
                },
                product_name: "Please enter product name",
                price_per_unit: "Please enter price per each unit",
                stock: {
                    required: "Please enter the no.of items in stock",
                    number: "Must be integer value"
                },
                min_quantity: {
                    required: "Enter minimim no.of units to be purchased",
                    number: "Must be an integer"
                },
                max_quantity: {
                    required: "Enter the purchase limit of item",
                    number: "Must be an integer"
                },
                product_description: "Describe the product"
			},
			submitHandler: function(form) {
			  form.submit();
			}
		});
	});
</script>

</body>
</html>
