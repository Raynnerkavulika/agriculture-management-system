<?php 
include "config.php";

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
}; 



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>system reports</title>

     <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
    

<!-- header begins here -->

<?php include "admin_header.php"; ?>


    <h2 class="title">Farm Reports</h2>


    <!-- farmers report -->
  <section class="user-management">

<h3 class="title" style="text-align: center;">Farmers report</h3>


  <!-- Farmers Table -->
    
  <table id="farmersTable">
      <thead>
        <tr>

          <th>Farmer Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Location</th>
          <th>Farm Type</th>
          <th>Date Added</th>
          <!-- <th>Actions</th> -->
        </tr>
      </thead>
      <tbody>
        <!-- Sample farmer rows (to be dynamically generated with php) -->
        
       <?php
       $select_farmer = $conn->prepare("SELECT * FROM `farmers`");
       $select_farmer->execute();
       if($select_farmer->rowCount()>0){
          while($fetch_farmer = $select_farmer->fetch(PDO::FETCH_ASSOC)){
      ?>
     
              <tr>
                <td><?= $fetch_farmer['farmer_name'];?></td>
                <td><?= $fetch_farmer['farmer_email'];?></td>
                <td><?= $fetch_farmer['farmer_number'];?></td>
                <td><?= $fetch_farmer['farm_location'];?></td>
                <td><?= $fetch_farmer['farm_type'];?></td>
                <td>01-01-2025</td>

                <!-- <td>
                  <div class="flex-btn">
                    <a href="edit_farmer.php?edit=<?= $fetch_farmer['id'];?>" class="option-btn">edit</a>
                    <a href="manage_farmer.php?delete=<?= $fetch_farmer['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
                  </div>
                </td> -->
              </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no farmer reports has been added yet!</p>';
            }
          ?>
        
      </tbody>
    </table>

    </section>

    <!-- farmers reports ends here -->


    <!-- workers reports Section starts here-->
  <section class="user-management">

<h3 class="title" style="text-align: center;">workers reports</h3>

<table id="workersTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Job Title</th>
          <th>Department</th>
          <th>Status</th>
          <th>Phone</th>
          <th>Salary</th>
          <!-- <th>Actions</th> -->
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
          <!-- <td>
          <div class="flex-btn">
          <a href="edit_worker.php?edit=<?= $fetch_worker['id'];?>" class="option-btn">edit</a>
          <a href="manage_worker.php?delete=<?= $fetch_worker['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
          </div>
          </td> -->
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no worker reports has been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>


<!-- workers report ends here -->



<!-- crop report starts here -->


    
  <section class="user-management">

<h3 class="title" style="text-align: center;">crop reports</h3>

<table id="cropsTable">
      <thead>
        <tr>
          <th>crop name</th>
          <th>planted date</th>
          <th>Expected yield(kg)</th>
          <th>actual yield(kg)</th>
          <th>status</th>
          <!-- <th>Actions</th> -->
        </tr>
      </thead>
      <tbody>
        <!-- Example crop row -->
        <?php
       $select_crop = $conn->prepare("SELECT * FROM `crops`");
       $select_crop->execute();
       if($select_crop->rowCount()>0){
          while($fetch_crop = $select_crop->fetch(PDO::FETCH_ASSOC)){

            
      ?>
       

        <tr>
          <td><?= $fetch_crop['crop_name'];?></td>
          <td><?= $fetch_crop['planted_date'];?></td>
          <td><?= $fetch_crop['expected_yield'];?></td>
          <td><?= $fetch_crop['actual_yield'];?></td>
          <td><?= $fetch_crop['status'];?></td>
          <td>
          <!-- <div class="flex-btn">
          <a href="edit_worker.php?edit=<?= $fetch_worker['id'];?>" class="option-btn">edit</a>
          <a href="manage_worker.php?delete=<?= $fetch_worker['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
          </div>
          </td> -->
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no crop reports has been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>
  



   <!-- livestock report starts here -->


    
  <section class="user-management">

<h3 class="title" style="text-align: center;">livestock reports</h3>

<table id="livestockTable">
      <thead>
        <tr>
          <th>animal type</th>
          <th>breed</th>
          <th>quantity</th>
          <th>birth date</th>
          <th>status</th>
          <!-- <th>Actions</th> -->
        </tr>
      </thead>
      <tbody>
        <!-- Example crop row -->
        <?php
       $select_livestock = $conn->prepare("SELECT * FROM `livestock`");
       $select_livestock->execute();
       if($select_livestock->rowCount()>0){
          while($fetch_livestock = $select_livestock->fetch(PDO::FETCH_ASSOC)){

            
      ?>
       

        <tr>
          <td><?= $fetch_livestock['animal_type'];?></td>
          <td><?= $fetch_livestock['breed'];?></td>
          <td><?= $fetch_livestock['quantity'];?></td>
          <td><?= $fetch_livestock['birth_date'];?></td>
          <td><?= $fetch_livestock['status'];?></td>
          <td>
          <!-- <div class="flex-btn">
          <a href="edit_worker.php?edit=<?= $fetch_worker['id'];?>" class="option-btn">edit</a>
          <a href="manage_worker.php?delete=<?= $fetch_worker['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
          </div>
          </td> -->
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no livestock reports has been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>

  
<!-- livestock report starts here -->


    
<section class="user-management">

<h3 class="title" style="text-align: center;">revenue reports</h3>

<table id="revenueTable">
      <thead>
        <tr>
          <th>sale date</th>
          <th>amount</th>
          <th>description</th>
          <!-- <th>Actions</th> -->
        </tr>
      </thead>
      <tbody>
        <!-- Example revenue row -->
        <?php
       $select_revenue = $conn->prepare("SELECT * FROM `revenue`");
       $select_revenue->execute();
       if($select_revenue->rowCount()>0){
          while($fetch_revenue = $select_revenue->fetch(PDO::FETCH_ASSOC)){

            
      ?>
       

        <tr>
          <td><?= $fetch_revenue['sale_date'];?></td>
          <td><?= $fetch_revenue['amount'];?></td>
          <td><?= $fetch_revenue['description'];?></td>
          <!-- <div class="flex-btn">
          <a href="edit_worker.php?edit=<?= $fetch_worker['id'];?>" class="option-btn">edit</a>
          <a href="manage_worker.php?delete=<?= $fetch_worker['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
          </div>
          </td> -->
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no revenue report has been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>

    
    <br>
    <a href="farm_analytics.php">📊 View Analytics</a>




<script src="script.js"></script>

</body>
</html>