<!-- done -->

<?php
// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }


require_once('pdo.php');
session_start();

if(isset($_POST['view'])){
    $_SESSION['c_id']=$_POST['c_id'];
    header('location:update_measurement.php');
    return;
}

if(isset($_POST['update'])){
    $_SESSION['o_id']=$_POST['o_id'];
    header('location:update_order.php');
    return;
}

if (isset($_POST['refresh'])){
    unset($_SESSION['c_id']);
    header('location: order_details.php');
    return;
}

if (isset($_POST['go_back'])){
    unset($_SESSION['c_id']);
    header('location: admin_page.php');
    return;
}

if(isset($_POST['search'])){
    $stmt = $pdo->prepare('SELECT c_phone from customer where c_phone = :phone');
            $stmt->execute(array(':phone'=>$_POST['c_phone']));
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("
        select o.o_id, c.c_name, o.o_type, o.o_status, o.delivery_date, b.paid,b.due,o.quantity,c.c_id
        from c_order as o
        left join customer as c on o.c_id = c.c_id
        left join bill as b on o.o_id = b.o_id
        where c.c_phone = :phone 
        order by o.o_id"
        );
    $stmt->execute(array(':phone'=>$_POST['c_phone']));
    $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
}else{
    $stmt = $pdo->query("
        select o.o_id, c.c_name, o.o_type, o.o_status, o.delivery_date, b.paid,b.due,o.quantity,c.c_id
        from c_order as o
        left join customer as c on o.c_id = c.c_id
        left join bill as b on o.o_id = b.o_id 
        order by o.o_id"
        );
    $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
}


?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customers Home Page</title>
    <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/order_details.css">
    <link rel="stylesheet" href="css/style1.css">
</head>
<body class="obg">

<div class="container-fluid justify-content-md-start row">
<h1 class='col-md-4'>Orders</h1>
<div class='col-md-8 '>
<form method="post" action="order_details.php" class="form-inline active-cyan-3 active-cyan-4 justify-content-md-end mt-3" >
    <input type='tel' name="c_phone" value = '' class="form-control form-control-sm ml-3 w-50" pattern="[6-9]{1}[0-9]{9}" title="Phone number with 6-9 and remaining 9 digit with 0-9" placeholder="Enter phone number">
    <button  type='submit'  name="search" class="btn btn-info btn-rounded btn-sm mx-1 my-0">SEARCH</button>
</form>
</div>
</div>


<hr>
<?php
if (empty($rows)){
    ?>
    <div class="no_order">
    <h1>No orders found!</h1>
</div>
    <form method="post">
    <button type="submit" class="btn mt-2  btn-md btn-custom   ml-2" name="refresh">Refresh</button></form></form> 
    <?php
}else{
    ?>

<div class="table-responsive">
<table class="table table-bordered  m-auto">
<thead class="th table-dark">
    <tr>
        <th>Order ID</th>
        <th>Customer name</th>
        <th>Type</th>
        <th>Status</th>
        <th>Quantity</th>
        <th>Delivery date</th>
        <th>Amount paid</th>
        <th>Due amount</th>
        <th>Measurement</th>
        <th>Order</th>
    </tr>
</thead>
<tbody class="table">
    <?php
    foreach($rows as $row ){
        ?>
        <tr><td>
        <?=$row['o_id']?>
        </td><td>
        <?=$row['c_name']?>
        </td><td>
        <?=$row['o_type']?>
        </td><td>
        <?=$row['o_status']?>
        </td><td>
        <?=$row['quantity']?>
        </td><td>
        <?=$row['delivery_date']?>
        </td><td>
        <?=$row['paid']?>
        </td><td>
        <?=$row['due']?>
        </td><td>
            <form method = 'post'>
                <input type= "hidden" value = "<?=$row['c_id']?>" name = "c_id">
                <div class='justify-content-sm-center'>
                    <button type='submit'  name ='view' class="btn btn-primary ">View</button>
                </div>
            </form>
        </td><td>
            <form method = 'post'>
            <input type= "hidden" value = "<?=$row['o_id']?>" name = "o_id">
            <button type= 'submit' class="btn btn-primary" name = 'update'>Update</button></form>
        </td></tr>
        <?php
        }?>
</tbody>
</table>
</div>
<hr>
    <form method="post">
        <div class='form-row justify-content-sm-center'>
            <button type="submit" class="btn btn-custom mr-3" name="go_back">
                Go back
            </button>
            <button type="submit" class="btn btn-md btn-custom" name="refresh">
                Refresh
            </button>
        </div>
    </form> 
    <?php
    }
?>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="fontawesome/js/all.js"></script>
<!--- End of Script Source Files -->
<hr>

</body>
</html>
