<!-- todo -->
<!-- no errors -->

<?php
// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['access']="Access denied.";
//     header("Location:admin_login.php");
// }

session_start();
require_once"pdo.php";
include "header.php";
?>

	<link rel="stylesheet" href="css/admin_page.css">
</head>
<body>
<div class="bg">
<?php
//login sucess message not printing
if ( isset($_SESSION['sucess'])) {
    echo('<p style="color: white;"><h2>'.htmlentities($_SESSION['sucess'])."</h2></p>\n");
    unset($_SESSION['sucess']);
}
?>
<div class="container my_container">
    <div class="row my_row">
    <div class="col-md-2 col-sm-2 my_col"><a href="add_customer.php" class="btn btn-info " role="button">Add Customer</a></div>
    <div class="col-md-2  col-sm-2 my_col"><a href="order_details.php" class="btn btn-info" role="button">Order Details</a></div>
    </div>
    <div class="row my_row">
    <div class="col-md-2 col-sm-2 my_col"><a href="add_order.php" class="btn btn-info" role="button">New Order</a></div>
    <div class="col-md-2  col-sm-2 my_col"><a href="add_measurement.php" class="btn btn-info" role="button">Add measurement</a></div>
    </div>
    <div class="row my_row">
    <div class="col-md-2 col-sm-2 my_col"><a href="update_measurement.php" class="btn btn-info" role="button">Update measurement</a></div>
    <div class="col-md-2 col-sm-2 my_col"><a href="logout.php"class="btn btn-info" role="button"> Logout</a></div>
    </div>
    
</div>
</div>
    <script src="js/jquery-3.3.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="fontawesome/js/all.js"></script>
</body>
</html>