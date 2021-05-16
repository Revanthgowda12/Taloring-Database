<!-- done -->
<?php

// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }


session_start();
require_once"pdo.php";
include "header.php";
    if(isset($_SESSION['errors'])){
        array_push($errors,$_SESSION['errors']);
        unset($_SESSION['errors']);
    }

    if (isset($_POST['add_customer'])){
        $_SESSION['name']=$_POST['c_name'];
        $_SESSION['address']=$_POST['c_address'];
        $_SESSION['phone']=$_POST['c_phone'];
        $_SESSION['mail']=$_POST['c_mail'];
        if(empty($_POST['c_name'])){
            array_push($errors,'Customer name is required');
        }
        if(empty($_POST['c_address'])){
            array_push($errors,'Customer address is required');
        }
        if(empty($_POST['c_phone'])){
            array_push($errors,'Customer phone.no is required');
        }
        if(empty($_POST['c_mail'])){
            array_push($errors,'Customer mail is required');
        }
        if(count($errors)==0){
            
            $stmt = $pdo->prepare('SELECT c_phone from customer where c_phone = :phone');
            $stmt->execute(array(':phone'=>$_POST['c_phone']));
            $check = $stmt->fetch(PDO::FETCH_ASSOC);

            if(empty($check)){
                //inserting into table if phone.no is unique
                $sql ="INSERT INTO customer(c_name,c_address,c_phone,c_mail) values(:name,:address,:phone,:mail)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                ':name' =>$_POST['c_name'],
                ':address' =>$_POST['c_address'],
                ':phone' =>$_POST['c_phone'],
                ':mail' =>$_POST['c_mail']
                ));
                $_SESSION['sucess'] ="New Customer ".$_POST['c_name']." added. ";

                //passing customer id to session for future use 
                $stmt = $pdo->prepare("SELECT c_id from customer where c_phone = :phone");
                $stmt->execute(array(':phone'=>$_SESSION['phone']));
                $c_id = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['c_id']=$c_id['c_id'];
                header('location:add_measurement.php');
            }else{
                //error if phone.no is already present
                $_SESSION['errors']="Phone number already entered. Enter a different number";
                unset($_SESSION['phone']);
                header('Location:add_customer.php');
                return;
            }
        }
        
    }

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
unset($_SESSION['name'],$_SESSION['address'],$_SESSION['mail'],$_SESSION['phone']);
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
<h1 class="text-center">Customer Details</h1>
</div>

<hr>
<?PHP
include 'errors.php';
?>
<div class = 'container border-container'>
<form method="post" action="add_customer.php">

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-6'>
            <label for="c_name">Name:</label> 
            <input class = 'form-control' type="text" name="c_name" id="c_name" size="20" value="<?=htmlentities($name)?>"/>
        </div>

        <div class='form-group col-md-6'>
            <label for="c_phone">Mobile Number:</label>
            <input class = 'form-control' type="tel" name="c_phone" id="c_phone" pattern="[6-9]{1}[0-9]{9}" title="Phone number with 6-9 and remaining 9 digit with 0-9" value="<?=htmlentities($phone) ?>">
        </div>
    </div>

    <div class='justify-content-md-start'>
        <label for="c_address">Address:</label> 
        <input class = 'form-control' type="text" name="c_address" id="c_address" size="50" value="<?=htmlentities($address) ?>"/>
    </div>

    <div class='justify-content-md-start'>
        <label for="c_mail">Email:</label>
        <input class = 'form-control' type="mail" name="c_mail" id="c_mail" title="Invalid email address" size="20" value="<?=htmlentities($mail) ?>"/>
    </div>

    <div class='form-row justify-content-sm-center mt-3'>
    <input class='btn btn-primary' type="submit" name='add_customer' value="SUBMIT">
</div>
</form>
</div>