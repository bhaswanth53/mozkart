<?php
	session_start();
	if ( !empty($_SESSION['admin'] ) ) {
		$session_mail = $_SESSION['admin'];
        require "local.php";
        require "check.php";
        $select = mysqli_query($con, "SELECT * FROM `user` ORDER BY `id` DESC");
		if (isset($_GET['view'])) {
            if( empty($_GET['view'])){
                header("location: index.php");
            }
            else {
                $oid = protect($con, base64_decode($_GET['view']));
                $select_order = mysqli_query($con, "SELECT * FROM `orders` WHERE o_id = '$oid'");
                $order = mysqli_fetch_array($select_order);
                $link = str_replace("/task8/admin/", "", $_SERVER['REQUEST_URI']);
            }
        }
        else {
            header("location: index.php");
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
                    <h1 class="page-header">Order Info</h1>
                </div>
            </div>
            <h3>Order Number: <?php echo $order['order_number']; ?></h3><br>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Payment Mode</th>
                            <th>Total Items</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo $order['name']; ?></td>
                            <td><?php
                                echo $order['payment_method'];
                            ?></td>
                            <td><?php
                                $item = json_decode($order['order_data'], true);
                                echo count($item);
                            ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>&#8377;<?php echo $order['price']; ?></td>
                            <td><?php
                                $delivery_date = $order['delivery_date'];
                                if($delivery_date == NULL) {
                                    $delivery_date = "Processing";
                                }
                                echo $delivery_date;
                            ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <h3>Items:</h3>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product Number</th>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $data = json_decode($order['order_data'], true);
                            foreach($data as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item[0]; ?></td>
                            <td><?php echo $item[1]; ?></td>
                            <td><div style="width: 25px; height: 20px; background-color: <?php echo $item[2]; ?>"></div></td>
                            <td><?php echo $item[3]; ?></td>
                            <td>&#8377;<?php echo $item[4]; ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div><br><br>
            <form action="order_action.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order['o_id']; ?>">
                <div class="btn-group">
                    <input type="submit" name="dispatched" class="btn btn-primary" value="dispatched">
                    <input type="submit" name="shipped" class="btn btn-warning" value="Shipped">
                    <input type="submit" name="deliver" class="btn btn-success" value="delivered">
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

</body>
</html>
