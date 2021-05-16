<?php 

// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }

require_once"pdo.php";
session_start();

if(empty($_SESSION['c_id'])){
    $_SESSION['from']="add_order.php";
    header('location: get_c_id.php');
    return;
}

if (isset($_POST['go_back'])){
    unset($_SESSION['c_id']);
    header('location: admin_page.php');
    return;
}

if(isset($_POST['view_measurement'])){
    $_SESSION['from']='add_order.php';
    header('location: view_measurement.php');
    return;
}

    if(isset($_POST['add_order'])){
        if(empty($_POST['o_quantity'])){
            array_push($errors,'Order quantity not set');
        }
        if(empty($_POST['total'])){
            array_push($errors,'total not set');
        }
        if(count($errors)==0){
        //select s_id from shop
        //$sel = $pdo->query("SELECT s_id FROM `shop`");
        //$row = $sel->fetch(PDO::FETCH_ASSOC);

        //stored procedures
        $sql="CALL `getShopId`();";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //insert into  c_order table
        $sql ="INSERT INTO c_order(o_date,o_type,quantity,delivery_date,c_id,o_status,s_id) values(:o_date,:o_type,:o_quantity,:delivery_date,:c_id,:o_status,:s_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':o_date' =>$_POST['o_date'],
            ':o_type'=>$_POST['o_type'],
            ':o_quantity' =>$_POST['o_quantity'],
            ':delivery_date' =>$_POST['delivery_date'],
            ':c_id'=>$_SESSION['c_id'],
            ':o_status'=>$_POST['o_status'],
            ':s_id' =>$row[0]['s_id'],
            )
        );
        $o_id = $pdo->lastInsertId();
        //insert into bill table
        $sql ="INSERT INTO bill(total,paid,due,c_id,s_id,o_id) values(:total,:paid,:due,:c_id,:s_id,:o_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':total' =>$_POST['total'],
            ':paid'=>$_POST['paid'],
            ':due' =>$_POST['total']-$_POST['paid'],
            ':s_id' =>$row[0]['s_id'],
            ':c_id'=>$_SESSION['c_id'],
            ':o_id'=>$o_id
            )
        );
        unset($_SESSION['c_id'],$_SESSION['from']);
        $_SESSION['sucess'] ="Order placed";
        header('Location:admin_page.php');
        exit;
    }
    }
    ?>
    <?php

if ( isset($_SESSION['sucess'])) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['sucess'])."</p>\n");
    unset($_SESSION['sucess']);
}
include 'errors.php';
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

    <div class="container-fluid justify-content-md-start">
        <h1 class="text-center">New order</h1>
    </div>
    <hr>
    <div class = 'container border-container'>
        <form method="POST">
            <div class='form-row justify-content-md-center'>
                <div class='form-group col-md-6'>
                    <label for="o_date">Order date:</label> 
                    <input class='form-control' type="date" name="o_date" value="<?php echo date('Y-m-d'); ?>" id="o_date"/>
                </div>
            
                <div class='form-group col-md-6'>
                    <label for="o_type">Order Type:</label>
                    <select class='form-control' id="o_type" name="o_type" >
                        <option value="shirt"selected>Shirt</option>
                        <option value="pant">Pant</option></select>
                </div>
            </div>
            
            <div class='form-row justify-content-md-center'>
                <div class='form-group col-md-6'>
                    <label for="o_quantity">Quantity:</label>
                    <input class='form-control' type="number" name="o_quantity"  id="o_quantity" min=1 value='1'>
                </div>
                <div class='form-group col-md-6'>
                    <label for="delivery_date">Delivery date:</label>
                    <input class='form-control' type="date" id="delivery_date" value="<?php echo date('Y-m-d'); ?>" name="delivery_date"/>
                </div>
            </div>  

            <div class='form-row justify-content-md-center'>
                <div class='form-group'>
                    <label for="status">Status:</label>
                    <select class='form-control' id="status" name="o_status" >
                    <option value="todo" selected>TODO</option>
                    <option value="stitching">STITCHING</option>
                    <option value="ready">READY  </option>
                    </select>
                </div>
            </div>

            <h2 class='justify-content-md-center'>Enter Amount Details:</h2>
            <div class='form-row justify-content-md-center'>
                <div class='form-group col-md-6'>
                    <label for="total">Total:</label>
                    <input class='form-control' type="number" name="total"  id="total" min="0" value='0'>
                </div>

                <div class='form-group col-md-6'>
                    <label for="paid">Paid:</label>
                    <input class='form-control' type="number" name="paid"  id="paid"  min="0" value="0">
                </div>
            </div>

            <!-- <p>
                <label for="due">Due:</label>
                <input type="number" name="due"  id="due" min="0"></p> -->  
            <div class=' form-row justify-content-sm-center'> 
                <input class="btn btn-primary" type="submit" value="SUBMIT" name="add_order">
                <div class="col-md-1"></div>
                <input class="btn btn-secondary" type="submit" name='go_back' value="Go back"> 
            </div>
        </form>
    </div>
</body>
</html>