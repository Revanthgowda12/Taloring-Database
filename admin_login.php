<!-- done -->


<?php
session_start();
require_once"pdo.php";
    // if(isset($_SESSION['access'])){
    //     echo $_SESSION['access'];
    //     unset($_SESSION['access']);
    // }


    if(isset($_SESSION['errors'])){
        array_push($errors,$_SESSION['errors']);
        unset($_SESSION['errors']);
    }
    if(isset($_POST['login'])){
        if(empty($_POST['name'])){
            array_push($errors,"Username is required!");
        }
        if(empty($_POST['pw'])){
            array_push($errors,"Password is required!");
        }
        if(count($errors)==0){
            $stmt =$pdo->query("SELECT * FROM shop WHERE s_id=1");
            $login=$stmt->fetch(PDO::FETCH_ASSOC);
            $salt = 'revanth@12';
            $check = hash('md5', $salt.$_POST['pw']);
            if ( $check === $login['s_password'] && $_POST['name'] === $login['s_owner']  ) {
                $_SESSION['LOGIN'] = $_POST['name'];
                $_SESSION['sucess'] = "Login Sucessful";
                header("Location: admin_page.php");
                return;
            } else {
                $_SESSION['errors']="Incorrect username or password";
                header("Location:admin_login.php");
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
	<link rel="stylesheet" href="css/admin_login.css">
</head>
<body>
<div class="bg">
<div class="d-flex justify-content-center align-items-center login-container">
    <form method="post" action="admin_login.php" class="login-form text-left">
            <h1 class="mb-4 font-weight-bold text-uppercase text-center">Tailor Login</h1>
            <?php
            include "errors.php"
            ?>
            
                <div class="form-group font-weight-bold">
                    <label for="nam" >Username:</label>
                    <input type="text" name="name" id="nam" class="form-control rounded-pill form-control-lg" >
                </div>
                <div class="form-group font-weight-bold">
                    <label for="pd">Password:</label>
                    <input type="password" name="pw" id="pd" class="form-control rounded-pill form-control-lg" >
                </div>
                <button type="submit" name="login" class="btn mt-5 rounded-pill btn-lg btn-custom btn-block text-uppercase">Log in</button>
    </form>
</div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script src="fontawesome/js/all.js"></script>
<!--- End of Script Source Files -->
