<!-- done -->

<?php
// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }


require_once"pdo.php";
include "header.php";
session_start();

    if(empty($_SESSION['c_id'])){
        $_SESSION['from']="update_measurement.php";
        header('location: get_c_id.php');
        return;
    }

    if (isset($_POST['go_back'])){
        unset($_SESSION['c_id']);
        header('location: admin_page.php');
        return;
    }

    if(isset($_POST['update_measurement'])){
        //inserting pant meassurements
        $query = "UPDATE pant set 
                    mes_date=:p_mes_date,
                    length=:p_length,
                    waist=:p_waist,
                    knee_length=:p_knee_length,
                    hip=:p_hip,
                    thigh=:p_thigh,
                    bottom=:p_bottom
                    where c_id = :c_id";
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
            )
        );

        //inserting shirt meassurements
        $query = "UPDATE shirt set
                    mes_date=:s_mes_date,
                    chest=:s_chest,
                    arm_hole=:s_arm_hole,
                    sleeves_half=:s_sleeves_half,
                    sleeves=:s_sleeves,
                    shoulder=:s_shoulder,
                    length=:s_length,
                    cuff=:s_cuff,
                    neck=:s_neck,
                    hip=:s_hip,
                    waist=:s_waist
                    where c_id = :c_id";
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
        $_SESSION['sucess'] = "Measurements upated!!";
        header("Location:admin_page.php");
        return;
    }
   
    $stmt = $pdo->prepare("SELECT * from pant where c_id = :c_id");
    $stmt->execute(array(':c_id'=> $_SESSION['c_id']));
    $pant = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * from shirt where c_id = :c_id");
    $stmt->execute(array(':c_id'=> $_SESSION['c_id']));
    $shirt = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( isset($_SESSION['message'])) {
        echo('<p style="color: green;">'.htmlentities($_SESSION['message'])."
    </div>\n");
        unset($_SESSION['message']);
    }

$stmt = $pdo->Prepare("SELECT c_name, c_phone FROM customer WHERE c_id = :c_id");
$stmt->execute(array(':c_id'=>$_SESSION['c_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<div class="container-fluid justify-content-md-center">
    <h2>Customer Measurements</h2>

    <h6>Name: <?=$row['c_name']?><br>
    Phone Number: <?=$row['c_phone']?></h6>
</div>

<hr>
<div class="container-fluid justify-content-md-center">
    <h3>Pant Measurements:</h3>
</div>

<div class = 'container-fluid'>
    <form method="post" action="update_measurement.php">
        
        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="date" >Meassure Date:</label>
                <input class = 'form-control' type="date" id="date" value="<?=$pant['mes_date'] ?>" name="p_mes_date"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="length" >Length:</label>
                <input class = 'form-control' type="number" id="length" name="p_length" value="<?=$pant['length']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="waist" >Waist:</label>
                <input class = 'form-control' type="number" id="waist" name="p_waist" value="<?=$pant['waist'] ?>" min="0"/>
            </div>
        </div>
        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="knee_length" >Knee-Length:</label>
                <input class = 'form-control' type="number" id="knee_length" name="p_knee_length" value="<?=$pant['knee_length'] ?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="hip" >Hip:</label>
                <input class = 'form-control' type="number" id="hip" name="p_hip" value="<?=$pant['hip'] ?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="thigh" >Thigh:</label>
                <input class = 'form-control' type="number" id="thigh" name="p_thigh" value="<?=$pant['thigh'] ?>" min="0"/>
            </div>
        </div>
        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="bottom" >Bottom:</label>
                <input class = 'form-control' type="number" id="bottom" name="p_bottom" value="<?=$pant['bottom'] ?>" min="0"/>
            </div>
        </div>

    <hr>  
    <h3>Shirt Measurements:</h3>

        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="date" >Meassure Date:</label>
                <input class = 'form-control' type="date" id="date" value="<?=$shirt['mes_date']?>" name="s_mes_date"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="chest" >Chest:</label>
                <input class = 'form-control' type="number" id="chest" name="s_chest" value="<?=$shirt['chest']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="arm_hole" >Arm Hole:</label>
                <input class = 'form-control' type="number" id="arm_hole" name="s_arm_hole" value="<?=$shirt['arm_hole']?>" min="0"/>
            </div>
        </div>

        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="sleeves_half" >Sleeves Half:</label>
                <input class = 'form-control' type="number" id="sleeves_half" name="s_sleeves_half" value="<?=$shirt['sleeves_half']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="sleeves" >Sleeves:</label>
                <input class = 'form-control' type="number" id="sleeves" name="s_sleeves" value="<?=$shirt['sleeves']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="shoulder" >Shoulder:</label>
                <input class = 'form-control' type="number" id="shoulder" name="s_shoulder" value="<?=$shirt['shoulder']?>" min="0"/>
            </div>
        </div>

        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="length" >Length:</label>
                <input class = 'form-control' type="number" id="length" name="s_length" value="<?=$shirt['length']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="cuff" >Cuff:</label>
                <input class = 'form-control' type="number" id="cuff" name="s_cuff" value="<?=$shirt['cuff']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="neck" >Neck:</label>
                <input class = 'form-control' type="number" id="neck" name="s_neck" value="<?=$shirt['neck']?>" min="0"/>
            </div>
        </div>

        <div class='form-row justify-content-md-center'>
            <div class='form-group col-md-3'>
                <label for="	hip" >Hip:</label>
                <input class = 'form-control' type="number" id="hip" name="s_hip" value="<?=$shirt['hip']?>" min="0"/>
            </div>
            <div class='form-group col-md-3'>
                <label for="waist" >Waist:</label>
                <input class = 'form-control' type="number" id="waist" name="s_waist" value="<?=$shirt['waist']?>" min="0"/>
            </div>
        </div>

    <hr>
        <div class='form-row justify-content-sm-center'>
            <input class="btn btn-primary" type="submit" value="UPDATE" name="update_measurement">
            <div class="col-md-1"></div>
            <input class="btn btn-secondary" type="submit" name='go_back' value="Go back"> 
        </div>
    <hr>     
</form>
</div>
<?php include "footer.php";?>