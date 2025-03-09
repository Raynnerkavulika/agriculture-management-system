<?php  
include "config.php";
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
}; 

if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_worker = $conn->prepare("DELETE FROM `workers` WHERE id=?");
  $delete_worker->execute([$delete_id]);
  $message[] ="worker has been deleted successfully";
}; 


if(isset($_POST['add_worker'])){
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

   $select_worker = $conn->prepare("SELECT * FROM `workers` WHERE full_name = ?");
   $select_worker->execute([$full_name]);

   if($select_worker ->rowCount() >0){
       $message[] = 'worker already exist';
   }else{
      $insert_worker = $conn->prepare("INSERT INTO `workers`(full_name,email,phone,job_title,department,salary) VALUES(?,?,?,?,?,?)");
      $insert_worker->execute([$full_name,$email,$phone,$job_title,$department,$salary]);

      $message[] = "worker has been inserted successfully";
   }


}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

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

?>  -


<?php  include "admin_header.php"; ?>
  <section class="manage-worker">
    <h3 class="title" style="text-align: center;">manage worker</h3>

    <div class="box-container">
      <div class="box">
              <?php
                    $select_worker = $conn->prepare("SELECT * FROM `workers`");
                    $select_worker->execute();
                    $number_of_worker = $select_worker->rowCount();
              ?>

              <h3><?= $number_of_worker;?></h3>
              <p>total workers</p>
      </div>

      <div class="box">
              <?php
                    $select_worker = $conn->prepare("SELECT * FROM `workers` WHERE status = ?");
                    $select_worker->execute(['active']);
                    $number_of_active_worker = $select_worker->rowCount();
              ?>

               <h3><?= $number_of_active_worker;?></h3>
              <p>active workers</p>
      </div>

      <div class="box">
              <?php
                    $select_worker = $conn->prepare("SELECT * FROM `workers` WHERE status = ?");
                    $select_worker->execute(['inactive']);
                    $number_of_inactive_worker = $select_worker->rowCount();
              ?>

               <h3><?= $number_of_inactive_worker;?></h3>
              <p>inactive workers</p>
      </div>
    </div>
  </section>


  <section class="add-worker">
      <h2>Add New worker</h2>

       <!-- Form to Add Worker -->
      <form id="addWorkerForm" method="post" action="">
        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" id="fullName" name="full_name" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
          <label for="jobTitle">Job Title</label>
          <input type="text" id="jobTitle" name="job_title" placeholder="Enter job title" required>
        </div>

        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" id="department" name="department" placeholder="Enter department" required>
        </div>

        <div class="form-group">
          <label for="salary">Salary</label>
          <input type="number" id="salary" name="salary" placeholder="Enter salary (optional)">
        </div>

        <input type="submit" class="btn" value="add worker" name="add_worker">
      </form>

    </section>



  <!-- Farmers List Section -->
  <section class="user-management">

  <h3 class="title" style="text-align: center;">workers list</h3>

  <table id="workersTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Job Title</th>
            <th>Department</th>
            <th>Status</th>
            <th>Phone</th>
            <th>Salary</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example worker row -->
          <?php
         $select_worker = $conn->prepare("SELECT * FROM `workers`");
         $select_worker->execute();
         if($select_worker->rowCount()>0){
            while($fetch_worker = $select_worker->fetch(PDO::FETCH_ASSOC)){

              
        ?>
         

          <tr>
            <td><?= $fetch_worker['full_name'];?></td>
            <td><?= $fetch_worker['job_title'];?></td>
            <td><?= $fetch_worker['department'];?></td>
            <td><?= $fetch_worker['status'];?></td>
            <td><?= $fetch_worker['phone'];?></td>
            <td><?= $fetch_worker['salary'];?></td>
            <td>
            <div class="flex-btn">
            <a href="edit_worker.php?edit=<?= $fetch_worker['id'];?>" class="option-btn">edit</a>
            <a href="manage_worker.php?delete=<?= $fetch_worker['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
            </div>
            </td>
          </tr>

            <?php
                }
              }else{
                echo'<p class="empty">no workers have been added yet!</p>';
              }
            ?>
        </tbody>
      </table>
</section>



<?php include "footer.php"; ?>

  

<script src="script.js"></script>
</body>
</html>