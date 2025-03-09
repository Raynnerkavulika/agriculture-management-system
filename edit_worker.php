<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_worker'])){
    
  $id =$_POST['id'];
  $full_name = $_POST['full_name'];
   $full_name = filter_var($full_name,FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email,FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone,FILTER_SANITIZE_STRING);
   $job_title = $_POST['job_title'];
   $job_title = filter_var($job_title,FILTER_SANITIZE_STRING);
   $department = $_POST['department'];
   $department = filter_var($department,FILTER_SANITIZE_STRING);
   $salary = $_POST['salary'];
   $salary = filter_var($salary,FILTER_SANITIZE_STRING);

    $update_worker  = $conn->prepare("UPDATE `workers` SET full_name=?,email=?,phone=?,job_title=?,department=?,salary=? WHERE id=?");
    $update_worker->execute([$full_name,$email,$phone,$job_title,$department,$salary,$id]);
    $message[] = 'worker updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit worker</title>
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

<section class="edit-worker">
    <h1 class="title">edit worker</h1>

    <?php
      $edit_id = $_GET['edit'];
      $select_worker = $conn->prepare("SELECT * FROM `workers` WHERE id =?");
      $select_worker->execute([$edit_id]);

      if($select_worker->rowCount()){
        while($fetch_worker = $select_worker->fetch(PDO::FETCH_ASSOC)){

    
    ?>

<form id="addWorkerForm" method="post" action="">
<input type="hidden" name="id" value="<?= $fetch_worker['id'];?>">
<div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" id="fullName" name="full_name" value="<?= $fetch_worker['full_name'];?>" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= $fetch_worker['email'];?>" placeholder="Enter email" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" value="<?= $fetch_worker['phone'];?>" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
          <label for="jobTitle">Job Title</label>
          <input type="text" id="jobTitle" name="job_title" value="<?= $fetch_worker['job_title'];?>" placeholder="Enter job title" required>
        </div>

        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" id="department" name="department" value="<?= $fetch_worker['department'];?>" placeholder="Enter department" required>
        </div>

        <div class="form-group">
          <label for="salary">Salary</label>
          <input type="number" id="salary" name="salary" value="<?= $fetch_worker['salary'];?>" placeholder="Enter salary (optional)">
        </div>

        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_worker">
            <a href="manage_worker.php" class="option-btn">go back</a>
        </div>
      </form>

    <?php
}
        
}else{
   echo'<p class="empty">no worker found!</p>';
}
    ?>
</section>



<?php include "footer.php"; ?>


<script src="script.js"></script>
</body>
</html>
