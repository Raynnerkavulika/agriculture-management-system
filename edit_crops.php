<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_crop'])){
    
  $id =$_POST['id'];
  $crop_name = $_POST['crop_name'];
  $crop_name = filter_var($crop_name,FILTER_SANITIZE_STRING);
  $planted_date = $_POST['planted_date'];
  $planted_date = filter_var($planted_date,FILTER_SANITIZE_STRING);
  $expected_yield = $_POST['expected_yield']; 
  $expected_yield = filter_var($expected_yield,FILTER_SANITIZE_STRING);
  $actual_yield = $_POST['actual_yield']; 
  $actual_yield = filter_var($actual_yield,FILTER_SANITIZE_STRING);
  $status = $_POST['status'];
  $status = filter_var($status,FILTER_SANITIZE_STRING);
  

    $update_crop  = $conn->prepare("UPDATE `crops` SET crop_name=?,planted_date=?,expected_yield=?,actual_yield=?,status=? WHERE id=?");
    $update_crop->execute([$crop_name,$planted_date,$expected_yield,$actual_yield,$status,$id]);
    $message[] = 'crop has been updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit crop</title>
     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

     <!-- custom css link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php  
   if(isset($message)){
    foreach($message as $message){
        echo'
        <div class="message">
            <span>'.$message.'</span>
        </div>
        ';
    }
   }

?>
<!-- admin header starts -->
<?php include('admin_header.php'); ?>
<!-- admin header ends -->

<section class="edit-crop">
    <h1 class="title">edit crop</h1>

    <?php
      $update_id = $_GET['edit'];
      $select_crop = $conn->prepare("SELECT * FROM `crops` WHERE id =?");
      $select_crop->execute([$update_id]);

      if($select_crop->rowCount()){
        while($fetch_crop = $select_crop->fetch(PDO::FETCH_ASSOC)){

    
    ?>

    <form action="" method="POST">
        <!-- <div class="form-group">
        <label for="farm">Farm:</label>
        <select name="farm_id" required>
            <option value="">Select Farm</option>
           //<?php
            //$farms = $pdo->query("SELECT id, name FROM farms");
           // while ($farm = $farms->fetch(PDO::FETCH_ASSOC)) {
           //     echo "<option value='{$farm['id']}'>{$farm['name']}</option>";
           // }
            //?>
        </select>
        </div> -->
        <input type="hidden" name="id" value="<?= $fetch_crop['id']; ?>">
        <div class="form-group">
        <label for="crop_name">Crop Name:</label>
        <input type="text" name="crop_name" value="<?= $fetch_crop['crop_name']; ?>" required>
        </div>
        <div class="form-group">
        <label for="planted_date">Planted Date:</label>
        <input type="date" value="<?= $fetch_crop['planted_date']; ?>" name="planted_date">
         </div>
         <div class="form-group">
        <label for="expected_yield">Expected Yield (kg):</label>
        <input type="number" value="<?= $fetch_crop['expected_yield']; ?>" name="expected_yield">
        </div>
        <div class="form-group">
        <label for="actual_yield">Actual Yield (kg):</label>
        <input type="number" value="<?= $fetch_crop['actual_yield']; ?>" name="actual_yield">
         </div>
         <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" value="<?= $fetch_crop['status']; ?>">
            <option value="Planted">Planted</option>
            <option value="Growing">Growing</option>
            <option value="Harvested">Harvested</option>
        </select>
        </div>
        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_crop">
            <a href="add_crops.php" class="option-btn">go back</a>
        </div>
      </form>

    <?php
}
        
}else{
   echo'<p class="empty">no crop details found!</p>';
}
    ?>
</section>




<?php include "footer.php"; ?>


<script src="script.js"></script>
</body>
</html>
