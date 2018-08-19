<?php
	session_start();
	if ( !empty($_SESSION['admin'] ) ) {
		$session_mail = $_SESSION['admin'];
        require "local.php";
        require "check.php";
        $select = mysqli_query($con, "SELECT * FROM `categories`");
		if (isset($_GET['delete'])) {
			$rid = protect($con, $_GET['delete']);
			$que = mysqli_query($con, "DELETE FROM categories WHERE category_id = $rid");
			header('location: category.php');
			// $ques = mysqli_query($con, "SELECT * FROM `story` WHERE query_id = $rid") or die(mysqli_error($con));
		}
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
                    <h1 class="page-header">Categories</h1>
                </div>
            </div>
            <form class="" action="category_process.php" method="POST" name="add_cat" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_name">Category Name:</label>
                    <input type="text" class="form-control" id="category_name" name="category_name">
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="category_img_one">First Image:</label>
                        <input type="file" name="category_img_one">
                    </div>
                    <div class="col-sm-6">
                        <label for="category_img_two">Second Image:</label>
                        <input type="file" name="category_img_two">
                    </div>
                </div>
                <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
            </form>
            <br>
            <div>
                <h3>Categories</h3>
                <div class="table-responsive">
                    <table class="table" id="categories">
                        <thead>
                            <tr>
                            <th>Category Name</th>
                            <th>First Image</th>
                            <th>Second Image</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($category = mysqli_fetch_array($select)) {
                            ?>
                            <tr>
                               <td class="lead"><?php echo $category['category_name']; ?></td>
                               <td><img src="<?php echo $category['category_img_one']; ?>" class="img-rounded" style="height: 100px; width: 100px"></td>
                               <td><img src="<?php echo $category['category_img_two']; ?>" class="img-rounded" style="height: 100px; width: 100px"></td>
                               <td><a href="category.php?delete=<?php echo $category['category_id']; ?>" class="btn btn-danger"><i class="fa fa-close"></i></a></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
<script src="js/pagination.js"></script>
<script>
    $("input[name='category_img_one']").on('change', function() {
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
				alert("First image is not a valid MIME type");
				this.value='';
		}
	});
    $("input[name='category_img_two']").on('change', function() {
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
				alert("Second image is not a valid MIME type");
				this.value='';
		}
	});
</script>
<script>
    $(function() {
        $("form[name='add_cat']").on('submit', function() {
            var input = $("input[name='category_name']").val();
            var img_one = $("input[name='category_img_one']").val();
            var img_two = $("input[name='category_img_two']").val();
            if (input.length == 0) {
                alert("Category name shouldn't be empty");
                event.preventDefault();
            }
            else if(img_one.length == 0) {
                alert("First image shouldn't be empty");
                event.preventDefault();
            }
            else if(img_two.length == 0) {
                alert("Second image shouldn't be empty");
                event.preventDefault();
            }
            else {
                $(this).submit();
            }
        });
    });
</script>

</body>
</html>
