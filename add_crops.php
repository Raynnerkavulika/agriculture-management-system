<?php  
include "config.php";
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_crop = $conn->prepare("DELETE FROM `crops` WHERE id=?");
  $delete_crop->execute([$delete_id]);
  $message[] ="crop has been deleted successfully";
}; 

if(isset($_POST['add_crop'])){
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

  $select_crop = $conn->prepare("SELECT * FROM `crops` WHERE crop_name = ?");
  $select_crop->execute([$crop_name]);

  if($select_crop->rowCount() >0){
      $message[] = "crop has already been added to the system";       
  }else{
     $insert_crop = $conn->prepare("INSERT INTO `crops`(crop_name,planted_date,expected_yield,actual_yield) VALUES(?,?,?,?)");
     $insert_crop->execute([$crop_name,$planted_date,$expected_yield,$actual_yield]);
     $message[] = "crop has been added successfully to the system";
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add crops</title>

      <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
    

<?php include "admin_header.php";?>

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


<section class="add-crop">
      <h2 class="title">Add Crop</h2>
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
        <div class="form-group">
        <label for="crop_name">Crop Name:</label>
        <input type="text" name="crop_name" required>
        </div>
        <div class="form-group">
        <label for="planted_date">Planted Date:</label>
        <input type="date" name="planted_date" required>
         </div>
         <div class="form-group">
        <label for="expected_yield">Expected Yield (kg):</label>
        <input type="number" name="expected_yield" required>
        </div>
        <div class="form-group">
        <label for="actual_yield">Actual Yield (kg):</label>
        <input type="number" name="actual_yield">
         </div>
         <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Planted">Planted</option>
            <option value="Growing">Growing</option>
            <option value="Harvested">Harvested</option>
        </select>
        </div>
        <input type="submit" value="add crop" name="add_crop" class="btn">
    </form>
      </section>


      <section class="user-management">

<h3 class="title" style="text-align: center;">crop list</h3>

<table id="cropsTable">
      <thead>
        <tr>
          <th>crop name</th>
          <th>planted date</th>
          <th>Expected yield(kg)</th>
          <th>actual yield(kg)</th>
          <th>status</th>
          <th>Action</th>
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
              <div class="flex-btn">
                      <a href="edit_crops.php?edit=<?= $fetch_crop['id'];?>" class="option-btn">edit</a>
                      <a href="add_crops.php?delete=<?= $fetch_crop['id'];?>" class="delete-btn" onclick="return confirm('delete this crop?');">delete </a>
              </div>
          </td>
          <td>
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no crop have been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>

</body>
</html>