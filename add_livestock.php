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
    <title>adding a livestock</title>
      <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
    

<?php include "admin_header.php";?>



<section class="add-livestock">
      <h2>Add Livestock</h2>
    <form action="" method="POST">
      <div class="form-group">
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
        </div>        
        <div class="form-group">
        <label for="animal_type">Animal Type:</label>
        <input type="text" name="animal_type" required>
        </div>
        <div class="form-group">
        <label for="breed">Breed:</label>
        <input type="text" name="breed">
        </div>
        <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required>
        </div>
        <div class="form-group">
        <label for="birth_date">Birth Date:</label>
        <input type="date" name="birth_date">
        </div>
        <div class="form-group">
        <label for="status">Status:</label>
        <select name="status">
            <option value="Healthy">Healthy</option>
            <option value="Sick">Sick</option>
            <option value="Sold">Sold</option>
        </select>
        </div>
        <input type="submit" class="btn" name="add_livestock" value="add livestock">
    </form>
      </section>
</body>
</html>