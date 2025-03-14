<?php  
include "config.php";
session_start();


$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
}; 

if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_user = $conn->prepare("DELETE FROM `farmers` WHERE id=?");
  $delete_user->execute([$delete_id]);
  $message[] ="farmer has been deleted successfully";
}; 


if(isset($_POST['add_farmer'])){
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

   $select_farmer = $conn->prepare("SELECT * FROM `farmers` WHERE farmer_name = ?");
   $select_farmer->execute([$farmer_name]);

   if($select_farmer ->rowCount() >0){
       $message[] = 'farmer already exist';
   }else{
      $insert_farmer = $conn->prepare("INSERT INTO `farmers`(farmer_name,farmer_email,farm_location,farmer_number,farm_type) VALUES(?,?,?,?,?)");
      $insert_farmer->execute([$farmer_name,$farmer_email,$farm_location,$farmer_number,$farm_type]);

      $message[] = "farmer inserted successfully";
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

?>


<?php  include "admin_header.php"; ?>
  <section class="manage-farmer">
    <h3 class="title" style="text-align: center;">manage farmer</h3>

    <div class="box-container">
      <div class="box">
              <?php
                    $select_farmer = $conn->prepare("SELECT * FROM `farmers`");
                    $select_farmer->execute();
                    $number_of_farmer = $select_farmer->rowCount();
              ?>

              <h3><?= $number_of_farmer;?></h3>
              <p>total farmers</p>
      </div>

      <div class="box">
              <?php
                    $select_farmer = $conn->prepare("SELECT * FROM `farmers` WHERE status = ?");
                    $select_farmer->execute(['active']);
                    $number_of_active_farmer = $select_farmer->rowCount();
              ?>

               <h3><?= $number_of_active_farmer;?></h3>
              <p>active farmers</p>
      </div>

      <div class="box">
              <?php
                    $select_farmer = $conn->prepare("SELECT * FROM `farmers` WHERE status = ?");
                    $select_farmer->execute(['inactive']);
                    $number_of_inactive_farmer = $select_farmer->rowCount();
              ?>

               <h3><?= $number_of_inactive_farmer;?></h3>
              <p>inactive farmers</p>
      </div>
    </div>
  </section>


  <section class="add-farmer">
      <h2>Add New Farmer</h2>
      <form id="farmerForm" method="post" action="">
        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" id="fullName" name="farmer_name" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="farmer_email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="farmer_number" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
          <label for="jobTitle">farm location</label>
          <input type="text" id="farmLocation" name="farm_location" placeholder="Enter farm location" required>
        </div>

        <div class="form-group">
          <label for="department">farm type</label>
          <select id="farmType" class="box" name="farm_type" required>
            <option value="crop">Crop Farming</option>
            <option value="livestock">Livestock Farming</option>
            <option value="mixed">Mixed Farming</option>
          </select>
        </div>
        <input type="submit" class="btn" value="add farmer" name="add_farmer">

      </form>

      
    </section>



  <!-- Farmers List Section -->
  <section class="user-management">

  <h3 class="title" style="text-align: center;">Farmers list</h3>


    <!-- Farmers Table -->
      
    <table id="farmersTable">
        <thead>
          <tr>

            <th>Farmer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Farm Type</th>
            <th>Actions</th>
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
                  <td>
                    <div class="flex-btn">
                      <a href="edit_farmer.php?edit=<?= $fetch_farmer['id'];?>" class="option-btn">edit</a>
                      <a href="manage_farmer.php?delete=<?= $fetch_farmer['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
                    </div>
                  </td>
                </tr>

            <?php
                }
              }else{
                echo'<p class="empty">no farmers have been added yet!</p>';
              }
            ?>
          
        </tbody>
      </table>

      </section>



      <?php include "footer.php"; ?>


      <script src="script.js"></script>
</body>
</html>