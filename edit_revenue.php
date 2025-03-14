<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_revenue'])){
    
  $id =$_POST['id'];
  $sale_date = $_POST["sale_date"];
  $amount = $_POST["amount"];
  $description = $_POST['description'];
  

    $update_revenue  = $conn->prepare("UPDATE `revenue` SET sale_date=?,amount=?,description=? WHERE id=?");
    $update_revenue->execute([$sale_date,$amount,$description,$id]);
    $message[] = 'revenue details has been updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit revenue</title>
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
    <h1 class="title">edit revenue</h1>

    <?php
      $update_id = $_GET['edit'];
      $select_revenue = $conn->prepare("SELECT * FROM `revenue` WHERE id =?");
      $select_revenue->execute([$update_id]);

      if($select_revenue->rowCount()){
        while($fetch_revenue = $select_revenue->fetch(PDO::FETCH_ASSOC)){

    
    ?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $fetch_revenue['id']; ?>">
      <div class="form-group">
        <label for="sale_date">Date:</label>
        <input type="date" name="sale_date"  value="<?= $fetch_revenue['sale_date']; ?>" required>
        </div>
        <div class="form-group">
        <label for="amount">Amount (KES):</label>
        <input type="number" name="amount" value="<?= $fetch_revenue['amount']; ?>" required>
        </div>
        <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" value="<?= $fetch_revenue['description']; ?>"></textarea>
        </div>

        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_revenue">
            <a href="add_revenue.php" class="option-btn">go back</a>
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
