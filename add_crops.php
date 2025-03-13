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
    <title>add crops</title>

      <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
    

<?php include "admin_header.php";?>


<section class="add-crop">
      <h2 class="title">Add Crop</h2>
    <form action="" method="POST">
        <div class="form-group">
        <label for="farm_id">Farm:</label>
        <select name="farm_id" required>
            <option value="">Select Farm</option>
           //<?php
            //$farms = $pdo->query("SELECT id, name FROM farms");
           // while ($farm = $farms->fetch(PDO::FETCH_ASSOC)) {
           //     echo "<option value='{$farm['id']}'>{$farm['name']}</option>";
           // }
            //?>
        </select>
        </div>
        <div class="form-group">
        <label for="crop_name">Crop Name:</label>
        <input type="text" name="crop_name" required>
        </div>
        <div class="form-group">
        <label for="planted_date">Planted Date:</label>
        <input type="date" name="planted_date">
         </div>
         <div class="form-group">
        <label for="expected_yield">Expected Yield (kg):</label>
        <input type="number" name="expected_yield">
        </div>
        <div class="form-group">
        <label for="actual_yield">Actual Yield (kg):</label>
        <input type="number" name="actual_yield">
         </div>
         <div class="form-group">
        <label for="status">Status:</label>
        <select name="status">
            <option value="Planted">Planted</option>
            <option value="Growing">Growing</option>
            <option value="Harvested">Harvested</option>
        </select>
        </div>
        <input type="submit" value="add crop" name="add_crop" class="btn">
    </form>
      </section>

</body>
</html>