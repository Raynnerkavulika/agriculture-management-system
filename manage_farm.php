<?php  
include "config.php";
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
}; 


if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_farm = $conn->prepare("DELETE FROM `farms` WHERE id=?");
  $delete_farm->execute([$delete_id]);
  $message[] ="farm has been deleted successfully";
}; 


// Fetch farmers for the dropdown
$query = "SELECT id, farmer_name FROM farmers";
$stmt = $conn->prepare($query);
$stmt->execute();
$farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['add_farm'])){
   $farm_name = $_POST['farm_name'];
   $farm_name = filter_var($farm_name,FILTER_SANITIZE_STRING);
   $farm_location = $_POST['farm_location'];
   $farm_location = filter_var($farm_location,FILTER_SANITIZE_STRING);
   $farm_size = $_POST['farm_size']; 
   $farm_size = filter_var($farm_size,FILTER_SANITIZE_STRING);
   $owner_id = $_POST['owner_id']; 

   $select_farm = $conn->prepare("SELECT * FROM `farms` WHERE farm_name = ?");
   $select_farm->execute([$farm_name]);

   if($select_farm->rowCount() >0){
       $message[] = "farm already exist";       
   }else{
      $insert_farm = $conn->prepare("INSERT INTO `farms`(farm_name,farm_location,farm_size,owner_id) VALUES(?,?,?,?)");
      $insert_farm->execute([$farm_name,$farm_location,$farm_size,$owner_id]);
      $message[] = "farm has been inserted successfully";
   }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>manage farm</title>

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
  <section class="manage-farm">
    <h3 class="title" style="text-align: center;">manage farm</h3>

    <div class="box-container">
      <div class="box">
              <?php
                    $select_farm = $conn->prepare("SELECT * FROM `farms`");
                    $select_farm->execute();
                    $number_of_farm = $select_farm->rowCount();
              ?>

              <h3><?= $number_of_farm;?></h3>
              <p>total farms</p>
      </div>

      <div class="box">
              <?php
                    $select_farm = $conn->prepare("SELECT * FROM `farms` WHERE status = ?");
                    $select_farm->execute(['active']);
                    $number_of_active_farm = $select_farm->rowCount();
              ?>

               <h3><?= $number_of_active_farm;?></h3>
              <p>active farms</p>
      </div>

      <div class="box">
              <?php
                    $select_farm = $conn->prepare("SELECT * FROM `farms` WHERE status = ?");
                    $select_farm->execute(['inactive']);
                    $number_of_inactive_farm = $select_farm->rowCount();
              ?>

               <h3><?= $number_of_inactive_farm;?></h3>
              <p>inactive farms</p>
      </div>
    </div>
  </section>


  <section class="add-farm">
      <h2>Add New Farm</h2>

    <form action="" method="POST">
    <div class="form-group">
        <label for="name">Farm Name:</label>
        <input type="text" name="farm_name" required>
    </div>
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" name="farm_location" required>
    </div>
    <div class="form-group">
        <label for="size">Size (in acres/hectares):</label>
        <input type="number" step="0.01" name="farm_size" required>
    </div>
    <div class="form-group">
        <label for="owner">Owner (Farmer):</label>
        <select name="owner_id" required>
            <option value="">Select Farmer</option>
            <?php foreach ($farmers as $farmer): ?>
                <option value="<?= $farmer['id'] ?>"><?= $farmer['farmer_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="submit" name="add_farm" class="btn" value="add farm">
    </form>

      
    </section>



  <!-- Farmers List Section -->
  <section class="user-management">

  <h3 class="title" style="text-align: center;">Farmers list</h3>


    <!-- Farmers Table -->
      
    <table id="farmersTable">
        <thead>
          <tr>

            <th>Farm Name</th>
            <th>Location</th>
            <th>size</th>
            <th>owner id(farmer)</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample farm rows (to be dynamically generated with php) -->
          
         <?php
         $select_farm = $conn->prepare("SELECT * FROM `farms`");
         $select_farm->execute();
         if($select_farm->rowCount()>0){
            while($fetch_farm = $select_farm->fetch(PDO::FETCH_ASSOC)){
        ?>
       
                <tr>
                  <td><?= $fetch_farm['farm_name'];?></td>
                  <td><?= $fetch_farm['farm_location'];?></td>
                  <td><?= $fetch_farm['farm_size'];?></td>
                  <td><?= $fetch_farm['owner_id'];?></td>

                  <td>
                    <div class="flex-btn">
                      <a href="edit_farm.php?edit=<?= $fetch_farm['id'];?>" class="option-btn">edit</a>
                      <a href="manage_farm.php?delete=<?= $fetch_farm['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
                    </div>
                  </td>
                </tr>

            <?php
                }
              }else{
                echo'<p class="empty">no farms have been added yet!</p>';
              }
            ?>
          
        </tbody>
      </table>

      </section>



      <?php include "footer.php"; ?>


      <script src="script.js"></script>
</body>
</html>