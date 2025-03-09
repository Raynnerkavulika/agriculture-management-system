<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_farm'])){
    
  $id =$_POST['id'];
   $farm_name = $_POST['farm_name'];
   $farm_location = $_POST['farm_location'];
   $farm_size = $_POST['farm_size']; 
   $owner_id = $_POST['owner_id']; 
  

    $update_farm  = $conn->prepare("UPDATE `farms` SET farm_name=?,farm_location=?,farm_size=?,owner_id=? WHERE id=?");
    $update_farm->execute([$farm_name,$farm_location,$farm_size,$owner_id,$id]);
    $message[] = 'farm has been updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit farm</title>
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

<section class="edit-farm">
    <h1 class="title">edit farm</h1>

    <?php
      $update_id = $_GET['edit'];
      $select_farm = $conn->prepare("SELECT * FROM `farms` WHERE id =?");
      $select_farm->execute([$update_id]);

      if($select_farm->rowCount()){
        while($fetch_farm = $select_farm->fetch(PDO::FETCH_ASSOC)){

    
    ?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $fetch_farm['id'];?>">
    <div class="form-group">
        <label for="name">Farm Name:</label>
        <input type="text" value="<?= $fetch_farm['farm_name'];?>" name="farm_name" required>
    </div>
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" value="<?= $fetch_farm['farm_location'];?>" name="farm_location" required>
    </div>
    <div class="form-group">
        <label for="size">Size (in acres/hectares):</label>
        <input type="number" step="0.01" value="<?= $fetch_farm['farm_size'];?>" name="farm_size" required>
    </div>
    <div class="form-group">
        <label for="owner">Owner (Farmer):</label>
        <select name="owner_id">
            <option value=""><?= $fetch_farm['owner_id'];?></option>
            <?php foreach ($farmers as $farmer): ?>
                <option value="<?= $farmer['id'] ?>"><?= $farmer['farmer_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_farm">
            <a href="manage_farm.php" class="option-btn">go back</a>
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
