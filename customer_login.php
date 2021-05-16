<?php
require_once"pdo.php";
session_start();
if ( isset($_POST['cancel'] ) ) {  
    header("Location:index.php");
    return;
}
if ( isset($_POST['phone']) ){
    unset($_SESSION['phone']);
    if (empty($_POST['phone'])) {
        $_SESSION['error'] = "Enter your phone number!!";
        header("Location:customer_login.php");
        return;
    } 
    else {
        $stmt =$pdo->prepare("SELECT c_phone,c_id from customer where c_phone = :phone");
        $stmt->execute(array(':phone'=>$_POST['phone']));
        $c_details = $stmt->fetch(PDO::FETCH_ASSOC);
        if($c_details){
            $_SESSION['c_id'] = $c_details['c_id'];
            $_SESSION['phone'] = $_POST['phone'];
            $_SESSION['sucess'] = "Login Sucessful!";
            header("Location: customer_page.php");
            return;
        }else{
            $_SESSION['error'] = "OOPS...Account not found!";
            header("Location:customer_login.php");
            return;
        }
    }
}

?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tailor Home Page</title>
    <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/customer_login.css">
</head>
<body>
<div class="cbg">
<div class="d-flex justify-content-center align-items-center login-container">
<form method="POST" action="customer_login.php" class="login-form text-left">
<h1 class="mb-4 font-weight-bold text-uppercase text-center">CUSTOMER LOGIN</h1>
<?php
if ( isset($_SESSION['sucess'])) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['sucess'])."</p>\n");
    unset($_SESSION['sucess']);
}
if ( isset($_SESSION['error'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<div class="form-group font-weight-bold">
    <label for="number">Enter Phone Number:</label>
    <input type="tel" name="phone" id="number" pattern="[6-9]{1}[0-9]{9}" title="Phone number with 6-9 and remaining 9 digit with 0-9" class="form-control rounded-pill form-control-lg">
</div>
<button type="submit" name="login" class="btn mt-2 rounded-pill btn-md btn-custom  text-uppercase">Log in</button>
<button type="submit" name="cancel" class="btn mt-2 ml-2 rounded-pill btn-md btn-custom  text-uppercase">Cancel</button>
</form>
</div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="fontawesome/js/all.js"></script>
<!--- End of Script Source Files -->
