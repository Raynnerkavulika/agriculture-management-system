<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_livestock'])){
    
  $id =$_POST['id'];
  $animal_type = $_POST['animal_type'];
  $animal_type = filter_var($animal_type,FILTER_SANITIZE_STRING);
  $breed = $_POST['breed'];
  $breed = filter_var($breed,FILTER_SANITIZE_STRING);
  $quantity = $_POST['quantity']; 
  $quantity = filter_var($quantity,FILTER_SANITIZE_STRING);
  $birth_date = $_POST['birth_date']; 
  $birth_date = filter_var($birth_date,FILTER_SANITIZE_STRING);
  $status = $_POST['status'];
  $status = filter_var($status,FILTER_SANITIZE_STRING);
  

    $update_livestock  = $conn->prepare("UPDATE `livestock` SET animal_type=?,breed=?,quantity=?,birth_date=?,status=? WHERE id=?");
    $update_livestock->execute([$animal_type,$breed,$quantity,$birth_date,$status,$id]);
    $message[] = 'livestock details has been updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit livestock</title>
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

<section class="edit-livestock">
    <h1 class="title">edit livestock</h1>

    <?php
      $update_id = $_GET['edit'];
      $select_livestock = $conn->prepare("SELECT * FROM `livestock` WHERE id =?");
      $select_livestock->execute([$update_id]);

      if($select_livestock->rowCount()){
        while($fetch_livestock = $select_livestock->fetch(PDO::FETCH_ASSOC)){

    
    ?>

     <form action="" method="POST">
      <!-- <div class="form-group">
        <label for="farm_id">Farm:</label>
        <select name="farm_id" required>
            <option value="">Select Farm</option>
           // <?php
           // $farms = $pdo->query("SELECT id, name FROM farms");
           // while ($farm = $farms->fetch(PDO::FETCH_ASSOC)) {
           //     echo "<option value='{$farm['id']}'>{$farm['name']}</option>";
            //}
           // ?>
        </select>
        </div>         -->
        <input type="hidden" name="id" value="<?= $fetch_livestock['id'];?>">
        <div class="form-group">
        <label for="animal_type">Animal Type:</label>
        <input type="text" name="animal_type" value="<?= $fetch_livestock['animal_type'];?>" required>
        </div>
        <div class="form-group">
        <label for="breed">Breed:</label>
        <input type="text" value="<?= $fetch_livestock['breed'];?>" name="breed">
        </div>
        <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" value="<?= $fetch_livestock['quantity'];?>" name="quantity" required>
        </div>
        <div class="form-group">
        <label for="birth_date">Birth Date:</label>
        <input type="date" value="<?= $fetch_livestock['birth_date'];?>" name="birth_date">
        </div>
        <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" value="<?= $fetch_livestock['status'];?>">
            <option value="Healthy">Healthy</option>
            <option value="Sick">Sick</option>
            <option value="Sold">Sold</option>
        </select>
        </div>
        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_livestock">
            <a href="add_livestock.php" class="option-btn">go back</a>
        </div>
      </form>

    <?php
}
        
}else{
   echo'<p class="empty">no livestock details found!</p>';
}
    ?>
</section>




<?php include "footer.php"; ?>


<script src="script.js"></script>
</body>
</html>
