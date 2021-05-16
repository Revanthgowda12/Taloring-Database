<!-- done -->
<?php
// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }

session_start();
require_once"pdo.php";
if(isset($_POST['phone'])){
    //checking if the phone.no is entered
    if(empty($_POST['phone'])){
        $_SESSION['error']="Enter phone number";
            header('Location: get_c_id.php');
            return;
    }else{
    //checking if the phone.no is present in database
    $phone = $_POST['phone'];
    $stmt = $pdo->prepare("SELECT c_id from customer where c_phone = :phone");
    $stmt->execute(array(':phone'=>$_POST['phone']));
    $c_id = $stmt->fetch(PDO::FETCH_ASSOC);
    if($c_id){
        $_SESSION['c_id']=$c_id['c_id'];
        header('Location: '.$_SESSION['from']);
        return;
    }else{
        $_SESSION['error']="Customer with this phone number is not present!";
        header('Location: get_c_id.php');
        return;
    }}
}
?>


<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/gcid.css">
</head>
<body>
<div class="gbg">
<div class="d-flex justify-content-md-end align-items-center login-container">
    <div class="justify-content-md-end">
        <form method="POST" action="get_c_id.php" class="login-form text-left">
        <?php
        if(isset($_SESSION['error'])){
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);  
        }
        ?>
        <!--<? echo $_SESSION['from'];?>-->
        <div class="form-group font-weight-bold">
                <label for="phone" style="font-size:20px; color:white;">Enter phone number: </lablel>
                <input id="phone" name="phone" type="tel" pattern="[6-9]{1}[0-9]{9}" title="Phone number with 6-9 and remaining 9 digit with 0-9" class="form-control rounded-pill form-control-lg">
        </div>    
            <button type="submit" name="submit" class="btn mt-1 rounded-pill btn-md btn-custom  text-uppercase" >Submit</button>
        </form>
    </div>
</div>
</div>

<?php
include'footer.php';
?>