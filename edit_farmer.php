<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_farmer'])){
    
  $id =$_POST['id'];
  $farmer_name = $_POST['farmer_name'];
  $farmer_name = filter_var($farmer_name,FILTER_SANITIZE_STRING);
  $farmer_email = $_POST['farmer_email'];
  $farmer_email = filter_var($farmer_email,FILTER_SANITIZE_STRING);
  $farm_location = $_POST['farm_location'];
  $farm_location = filter_var($farm_location,FILTER_SANITIZE_STRING);
  $farmer_number = $_POST['farmer_number'];
  $farmer_number = filter_var($farmer_number,FILTER_SANITIZE_STRING);
  $farm_type = $_POST['farm_type'];
  $farm_type = filter_var($farm_type,FILTER_SANITIZE_STRING);
  

    $update_farmer  = $conn->prepare("UPDATE `farmers` SET farmer_name=?,farmer_email=?,farm_location=?,farmer_number=?,farm_type=? WHERE id=?");
    $update_farmer->execute([$farmer_name,$farmer_email,$farm_location ,$farmer_number,$farm_type,$id]);
    $message[] = 'farmer updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit farmer</title>
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

<section class="edit-farmer">
    <h1 class="title">edit farmer</h1>

    <?php
      $update_id = $_GET['edit'];
      $select_farmer = $conn->prepare("SELECT * FROM `farmers` WHERE id =?");
      $select_farmer->execute([$update_id]);

      if($select_farmer->rowCount()){
        while($fetch_farmer = $select_farmer->fetch(PDO::FETCH_ASSOC)){

    
    ?>

     <form id="farmerForm" method="POST" action="">
     <input type="hidden" name="id" value="<?= $fetch_farmer['id'];?>">
        <div class="form-group">
          <label for="farmerName">Full Name</label>
          <input type="text" id="farmerName" name="farmer_name" value="<?= $fetch_farmer['farmer_name'];?>" required>
        </div>

        <div class="form-group">
          <label for="farmerEmail">Email</label>
          <input type="email" id="farmerEmail" value="<?= $fetch_farmer['farmer_email'];?>" name="farmer_email" required>
        </div>

        <div class="form-group">
          <label for="farmerPhone">Phone Number</label>
          <input type="tel" id="farmerPhone" value="<?= $fetch_farmer['farmer_number'];?>" name="farmer_number" required>
        </div>

        <div class="form-group">
          <label for="farmLocation">Farm Location</label>
          <input type="text" id="farmLocation" value="<?= $fetch_farmer['farm_location'];?>" name="farm_location" required>
        </div>

        <div class="form-group">
          <label for="farmType">Farm Type</label>
          <select id="farmType" name="farm_type" required>
            <option selected><?= $fetch_farmer['farm_type'];?></option>
            <option value="crop">Crop Farming</option>
            <option value="livestock">Livestock Farming</option>
            <option value="mixed">Mixed Farming</option>
          </select>
        </div>

        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_farmer">
            <a href="manage_farmer.php" class="option-btn">go back</a>
        </div>
      </form>

    <?php
}
        
}else{
   echo'<p class="empty">no farmers found!</p>';
}
    ?>
</section>




<?php include "footer.php"; ?>


<script src="script.js"></script>
</body>
</html>
