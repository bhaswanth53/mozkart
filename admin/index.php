<?php
	session_start();
	if ( !empty($_SESSION['admin'] ) ) {
		$session_mail = $_SESSION['admin'];
        require "local.php";
        require "check.php";
        $select = mysqli_query($con, "SELECT * FROM `user` ORDER BY `id` DESC");
        $select_orders = mysqli_query($con, "SELECT * FROM `orders` ORDER BY o_id DESC");
		if (isset($_GET['delete'])) {
			$rid = protect($con, $_GET['delete']);
			$que = mysqli_query($con, "DELETE FROM colors WHERE id = $rid");
			header('location: colors.php');
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <h3>Product Sales</h3>
                            <span><i class="fa fa-calendar"></i> This Month</span>
                            <h1 class="text-primary">0</h1>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <h3>Total Sales</h3>
                            <span><i class="fa fa-calendar"></i> This Month</span>
                            <h1 class="text-primary">0</h1>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <h3>Total Earnings</h3>
                            <span><i class="fa fa-calendar"></i> This Month</span>
                            <h1 class="text-primary">0</h1>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <h3>Average Sale</h3>
                            <span><i class="fa fa-calendar"></i> This Month</span>
                            <h1 class="text-primary">0</h1>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Orders:</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="info">
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>No.Of Items</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($order = mysqli_fetch_array($select_orders)) {
                        ?>
                        <tr>
                            <td><?php echo $order['order_number']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo $order['email']; ?></td>
                            <td><?php  
                                $items = json_decode($order['order_data'], true);
                                echo count($items);
                                
                            ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="order_view.php?view=<?php echo base64_encode($order['o_id']); ?>" class="" title="view Order"><i class="fa fa-eye"></i> View</a>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <h3>Users:</h3>
            <select class  ="btn btn-default" name="state" id="maxRows">
                <option value="5000">ALL</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="70">70</option>
                <option value="100">100</option>
            </select>
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped table-class" id= "users">
                    <thead>
                        <tr class="info">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($user = mysqli_fetch_array($select)) {
                        ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['mobile']; ?></td>
                            <td><?php echo $user['joined_date']; ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class='pagination-container' >
                <nav>
                    <ul class="pagination">
                    <!--	Here the JS Function Will Add the Rows -->
                    </ul>
                </nav>
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


</body>
</html>
