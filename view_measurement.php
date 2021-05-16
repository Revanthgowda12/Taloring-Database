<!-- done -->
<!-- no error -->

<?php
// if(!isset($_SESSION['LOGIN'])){
//     $_SESSION['errors']="Access denied.";
//     header("Location:admin_login.php");
// }

require_once"pdo.php";
session_start();
if(isset($_POST['go_back'])){
    header('Location:'.$_SESSION['from']);
    return;
}
    $stmt = $pdo->prepare("SELECT * from pant where c_id = :c_id");
    $stmt->execute(array(':c_id'=> $_SESSION['c_id']));
    $pant = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * from shirt where c_id = :c_id");
    $stmt->execute(array(':c_id'=> $_SESSION['c_id']));
    $shirt = $stmt->fetch(PDO::FETCH_ASSOC);

    
?>
<html>
<head><title>Measurements</title></head>
<body>
<?php
$stmt = $pdo->Prepare("SELECT c_name, c_phone FROM customer WHERE c_id = :c_id");
$stmt->execute(array(':c_id'=>$_SESSION['c_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo("Name: ".$row['c_name']);
echo("Phone Number: ".$row['c_phone']);
?>

<h1>Customer Measurements</h1>

<P>Meassure Date: <?=$pant['mes_date'] ?></p>
<p>Length: <?=$pant['length']?></p>
<p>Waist: <?=$pant['waist'] ?></p>
<p>Knee-Length: <?=$pant['knee_length'] ?></p>
<p>Hip: <?=$pant['hip'] ?></p>
<p>Thigh: <?=$pant['thigh'] ?></p>
<p>Bottom: <?=$pant['bottom'] ?></p>
<p>Additional Comments: <?=$pant['p_comment']?></p>

<h2>Shirt Measurements:</h2>
<p>Meassure Date: <?=$shirt['mes_date']?></p>
<p>Chest: <?=$shirt['chest']?></p>
<p>Arm Hole: <?=$shirt['arm_hole']?></p>
<p>Sleeves Half: <?=$shirt['sleeves_half']?></p>
<p>Sleeves: <?=$shirt['sleeves']?></p>
<p>Shoulder: <?=$shirt['shoulder']?></p>
<p>Length: <?=$shirt['length']?></p>
<p>Cuff: <?=$shirt['cuff']?></p>
<p>Neck: <?=$shirt['neck']?></p>
<p>Hip: <?=$shirt['hip']?></p>
<p>Waist: <?=$shirt['waist']?></p>
<p>Additional Comments: <?=$shirt['s_comment']?></p>
<form method="post">
    <input type="submit" value="Go back" name="go_back">
</form>
</body>
</html>