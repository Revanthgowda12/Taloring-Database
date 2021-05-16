<!--Done-->
<!-- no error -->
<?php 
// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }


require_once"pdo.php";
session_start();
if(empty($_SESSION['o_id'])){
    array_push($errors,"order ID not set");
}

if(isset($_POST['add_order'])){
    if(empty($_POST['o_quantity'])){
        array_push($errors,'Order quantity not set');
    }
    if(empty($_POST['total'])){
        array_push($errors,'total not set');
    }
    if(count($errors)==0){
        $stmt = $pdo->prepare("UPDATE c_order SET 
                                o_date=:o_date,
                                o_type=:o_type,
                                quantity=:o_quantity,
                                delivery_date=:delivery_date,
                                o_status=:o_status
                                where 
                                o_id=:o_id");
        $stmt->execute(array(
            ':o_date' =>$_POST['o_date'],
            ':o_type'=>$_POST['o_type'],
            ':o_quantity' =>$_POST['o_quantity'],
            ':delivery_date' =>$_POST['delivery_date'],
            ':o_id'=>$_SESSION['o_id'],
            ':o_status'=>$_POST['o_status']
            )
        );

        // //select s_id from shop
        // $sel = $pdo->query("SELECT s_id FROM `shop`");
        // $row = $sel->fetch(PDO::FETCH_ASSOC);
        //insert into bill table
        $sql ="UPDATE bill SET
                total=:total,
                paid=:paid,
                due=:due
                WHERE o_id=:o_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':total' =>$_POST['total'],
            ':paid'=>$_POST['paid'],
            ':due' => ($_POST['total']-$_POST['paid']),
            ':o_id'=> $_SESSION['o_id']
            )
        );

        unset($_SESSION['o_id']);
        $_SESSION['sucess'] ="Order updated";
        header('Location:order_details.php');
        exit;
    }
}
// if ( isset($_SESSION['sucess'])) {
//     echo('<p style="color: green;">'.htmlentities($_SESSION['sucess'])."</p>\n");
//     unset($_SESSION['sucess']);
// }
include 'errors.php';

$stmt = $pdo->prepare('SELECT * FROM c_order WHERE o_id= :o_id');
$stmt->execute(array(':o_id'=> $_SESSION['o_id']));
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM bill WHERE o_id= :o_id');
$stmt->execute(array(':o_id'=> $_SESSION['o_id']));
$pay = $stmt->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// echo $_SESSION['o_id'];
// print_r($order);
// print_r($pay);
// echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css\style1.css">
</head>
<body>
    <div class = 'container border-container'>
        <form method="POST">
            <div class='form-row justify-content-md-center'>
                <div class='form-group col-md-6'>
                    <label for="o_date">Order date:</label> 
                    <input class='form-control' type="date" name="o_date" value="<?=$order['o_date']?>" id="o_date"/>
                </div>
            
                <div class='form-group col-md-6'>
                    <label for="o_type">Order Type:</label>
                    <select class='form-control' id="o_type" name="o_type" selected="<?=$order['o_type']?>">
                        <option value="shirt">Shirt</option>
                        <option value="pant">Pant</option></select>
                </div>
            </div>
            
            <div class='form-row justify-content-md-center'>
                <div class='form-group col-md-6'>
                    <label for="o_quantity">Quantity:</label>
                    <input class='form-control' type="number" name="o_quantity"  id="o_quantity" min=1 value="<?=$order['quantity']?>">
                </div>
                <div class='form-group col-md-6'>
                    <label for="delivery_date">Delivery date:</label>
                    <input class='form-control' type="date" id="delivery_date" value="<?=$order['delivery_date']?>" name="delivery_date"/>
                </div>
            </div>  

            <div class='form-row justify-content-md-center'>
                <div class='form-group'>
                    <label for="status">Status:</label>
                    <select class='form-control' id="status" name="o_status" selected = "<?=$order['status']?>" >
                    <option value="todo">TODO</option>
                    <option value="stitching">STITCHING</option>
                    <option value="ready">READY  </option>
                    </select>
                </div>
            </div>

            <h2 class='justify-content-md-center'>Enter Amount Details:</h2>
            <div class='form-row justify-content-md-center'>
                <div class='form-group col-md-6'>
                    <label for="total">Total:</label>
                    <input class='form-control' type="number" name="total"  id="total" min="0" value="<?=$pay['total']?>"">
                </div>

                <div class='form-group col-md-6'>
                    <label for="paid">Paid:</label>
                    <input class='form-control' type="number" name="paid"  id="paid"  min="0" value="<?=$pay['paid']?>">
                </div>
            </div>

            <!-- <p>
                <label for="due">Due:</label>
                <input type="number" name="due"  id="due" min="0"></p> -->  
            <div class=' form-row justify-content-sm-center'> 
                <input class='btn btn-primary'  type="submit" value="SUBMIT" name="add_order">
            </div>
        </form>
    </div>
</body>
</html>