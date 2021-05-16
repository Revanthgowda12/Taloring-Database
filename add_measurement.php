<!-- done -->
<?php

// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }


require_once "pdo.php";
include 'header.php';


session_start();
    if(empty($_SESSION['c_id'])){
        $_SESSION['from']="add_measurement.php";
        header('location: get_c_id.php');
        return;
    }
    
    if(isset($_POST['add_later'])){
        unset($_SESSION['c_id']);
        $_SESSION['sucess'] = $_SESSION['sucess'] . "Measurements not added!!";
        header('location: admin_page.php');
        return;
    }

    //check if the customer measurement already entered
    $stmt =$pdo->prepare('SELECT * FROM pant where c_id = :c_id');
    $stmt->execute(array(':c_id'=>$_SESSION['c_id']));
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($check)){
        $_SESSION['message']="Customer measurement already entered";
        header('location:update_measurement.php');
        return;
    }

    if(isset($_POST['submit'])){
        //inserting pant meassurements
        $query = "Insert into pant
                    (mes_date,length,waist,knee_length,hip,thigh,bottom,c_id) 
                    Values
                    (:p_mes_date,:p_length,:p_waist,:p_knee_length,:p_hip,:p_thigh,:p_bottom,:c_id)";
        $p_stmt = $pdo->prepare($query);
        $p_stmt->execute(array(
            ':p_mes_date'=>$_POST['p_mes_date'],
            ':p_length'=>$_POST['p_length'],
            ':p_waist' =>$_POST['p_waist'],
            ':p_knee_length'=>$_POST['p_knee_length'],
            ':p_hip'=>$_POST['p_hip'],
            ':p_thigh'=>$_POST['p_thigh'],
            ':p_bottom'=>$_POST['p_bottom'],
            ':c_id'=>$_SESSION['c_id']
            

        ));

        //inserting shirt meassurements
        $query = "Insert into shirt(mes_date,chest,arm_hole,sleeves_half,sleeves,shoulder,length,cuff,neck,hip,waist,c_id) 
        Values
        (:s_mes_date,
        :s_chest,:s_arm_hole,:s_sleeves_half,:s_sleeves,:s_shoulder,:s_length,:s_cuff,:s_neck,:s_hip,:s_waist,:c_id)";
        $p_stmt = $pdo->prepare($query);
        $p_stmt->execute(array(
            ':s_mes_date'=>$_POST['s_mes_date'],
            ':s_chest'=>$_POST['s_chest'],
            ':s_arm_hole' =>$_POST['s_arm_hole'],
            ':s_sleeves_half'=>$_POST['s_sleeves_half'],
            ':s_sleeves'=>$_POST['s_sleeves'],
            ':s_shoulder'=>$_POST['s_shoulder'],
            ':s_length'=>$_POST['s_length'],
            ':s_cuff'=>$_POST['s_cuff'],
            ':s_neck'=>$_POST['s_neck'],
            ':s_hip'=>$_POST['s_hip'],
            ':s_waist'=>$_POST['s_waist'],
            ':c_id'=>$_SESSION['c_id']
        ));
        unset ($_SESSION['c_id']);
        $_SESSION['sucess'] = $_SESSION['sucess'] . "Measurements added!!";
        header("Location:admin_page.php");
        return;
    }

$stmt = $pdo->query("SELECT c_name, c_phone FROM customer WHERE c_id = {$_SESSION['c_id']}");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="css/style1.css">
</head>

<!-- page heading  -->
<div class="container-fluid justify-content-md-center">
    <h2>Customer Measurements</h2>
    <!-- customer name and phone no -->
    <h6>
        Name: <?=$row['c_name']?><br>
        Phone Number: <?=$row['c_phone']?>
    </h6>
</div>

<hr>

<div class="container-fluid justify-content-md-center">
    <h3>Pant Measurements:</h3>
</div>

<div class = 'container-fluid'>
<form method="post"> 

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="date" >Meassure Date</label>
            <input class = 'form-control' type="date" id="date" value="<?php echo date('Y-m-d'); ?>" name="p_mes_date" min=0/>
        </div>
        <div class='form-group col-md-3'>
            <label for="length" >Length:</label>
            <input class = 'form-control' type="number" id="length" name="p_length" min=0/>
        </div>
        <div class='form-group col-md-3'>
            <label for="waist" >Waist:</label>
            <input class ='form-control' type="number" id="waist" name="p_waist" min=0/>
        </div>
    </div>

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="knee_length" >Knee-Length:</label>
            <input class ='form-control' min=0 type="number" id="knee_length" name="p_knee_length"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="hip" >Hip:</label>
            <input class ='form-control' min=0 type="number" id="hip" name="p_hip"/>
        </div>
    
        <div class='form-group col-md-3'>
            <label for="thigh" >Thigh:</label>
            <input class ='form-control' min=0 type="number" id="thigh" name="p_thigh"/>
        </div>
    </div>

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="bottom" >Bottom:</label>
            <input class ='form-control' min=0 type="number" id="bottom" name="p_bottom"/>
        </div>
    </div>

    

<hr>
<h3>Shirt Measurements:</h3>

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="date" >Meassure Date:</label>
            <input class ='form-control' min=0 type="date" id="date" value="<?php echo date('Y-m-d'); ?>" name="s_mes_date"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="chest" >Chest:</label>
            <input class ='form-control' min=0 type="number" id="chest" name="s_chest"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="arm_hole" >Arm Hole:</label>
            <input class ='form-control' min=0 type="number" id="arm_hole" name="s_arm_hole"/>
        </div>
    </div>

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="sleeves_half" >Sleeves Half:</label>
            <input class ='form-control' min=0 type="number" id="sleeves_half" name="s_sleeves_half"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="sleeves" >Sleeves:</label>
            <input class ='form-control' min=0 type="number" id="sleeves" name="s_sleeves"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="shoulder" >Shoulder:</label>
            <input class ='form-control' min=0 type="number" id="shoulder" name="s_shoulder"/>
        </div>
    </div>

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="length" >Length:</label>
            <input class ='form-control' min=0 type="number" id="length" name="s_length"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="cuff" >Cuff:</label>
            <input class ='form-control' min=0 type="number" id="cuff" name="s_cuff"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="neck" >Neck:</label>
            <input class ='form-control' min=0 type="number" id="neck" name="s_neck"/>
        </div>
    </div>

    <div class='form-row justify-content-md-center'>
        <div class='form-group col-md-3'>
            <label for="hip" >Hip:</label>
            <input class ='form-control' min=0 type="number" id="hip" name="s_hip"/>
        </div>

        <div class='form-group col-md-3'>
            <label for="waist" >Waist:</label>
            <input class ='form-control' min=0 type="number" id="waist" name="s_waist"/>
        </div>
    </div>

    <hr>
    <div class='form-row justify-content-sm-center'>
        <input class="btn btn-primary" type="submit" value="SUBMIT" name="submit">
        <div class="col-md-1"></div>
        <input class="btn btn-secondary" type="submit" name='add_later' value="ADD LATER"> 
    </div>

</form>
</div>
<hr>
<?php include 'footer.php'?>