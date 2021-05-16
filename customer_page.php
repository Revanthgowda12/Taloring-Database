<?php

// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:customer_login.php");
// }

session_start();
require_once"pdo.php";
include "header.php";
if ( ! isset($_SESSION['c_id']) ) {
    $_SESSION['error']="Access denied!!";
    header("Location:customer_login.php");
    return;
}

?>

	<link rel="stylesheet" href="css/customer_page.css">
</head>
<body class="cbg">
<?php
if ( isset($_SESSION['sucess'])) {
    echo('<p style="color:green;">'.htmlentities($_SESSION['sucess'])."</p>\n");
    unset($_SESSION['sucess']);
}

$stmt = $pdo->prepare("SELECT c_name, c_phone FROM `customer` WHERE c_id= :c_id");
$stmt->execute(array(':c_id'=>$_SESSION['c_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo'<div class="np mx-2 " >';
echo("Name: ".$row['c_name']."<br>");
echo("Phone: ".$row['c_phone']."<br>");
echo'</div>';
?>
<hr class="hrole">
<div class="table-responsive">
<table class="table table-bordered  m-auto" style="width:99%;  ">
<thead class="th table-dark">
<tr>
    <th>Order Type</th>
    <th>Quantity</th>
    <th>Ordered Date</th>
    <th>Delivery Date</th>
    <th>Total amount</th>
    <th>Amount paid</th>
    <th>Due amount</th>
    <th>Order Status</th>
</tr>
</thead>
<?php

$stmt = $pdo->prepare("
select o.o_type, o.quantity, o.o_date, o.delivery_date, b.total, b.paid, b.due, o.o_status  
from c_order as o
left join customer as c on o.c_id = c.c_id
left join bill as b on o.o_id = b.o_id
where c.c_id = :c_id"
);
$stmt->execute(array(':c_id'=>$_SESSION['c_id']));
$rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
//echo '<pre>';
//print_r($rows);
//echo "</pre>";
?>
<tbody class="tb">
<?php
foreach($rows as $row ){
    echo "<tr><td>";
    echo $row['o_type'];
    echo "</td><td>";
    echo $row['quantity'];
    echo "</td><td>";
    echo $row['o_date'];
    echo "</td><td>";
    echo $row['delivery_date'];
    echo "</td><td>";
    echo $row['total'];
    echo "</td><td>";
    echo $row['paid'];
    echo "</td><td>";
    echo $row['due'];
    echo "</td><td>";
    echo $row['o_status'];
    echo "</td></tr>";
}
?>
</tbody>
</table>
</div>
<a href="logout.php" class="btn mt-2  btn-md btn-custom   ml-2"> Logout</a>

<?php
include "footer.php";
?>
