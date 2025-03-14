<?php  
include "config.php";
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};

if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_livestock = $conn->prepare("DELETE FROM `livestock` WHERE id=?");
  $delete_livestock->execute([$delete_id]);
  $message[] ="livestock has been deleted successfully";
}; 

if(isset($_POST['add_livestock'])){
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

  $select_livestock = $conn->prepare("SELECT * FROM `livestock` WHERE animal_type = ?");
  $select_livestock->execute([$animal_type]);

  if($select_livestock->rowCount() >0){
      $message[] = "This livestock has already been added to the system";       
  }else{
     $insert_livestock = $conn->prepare("INSERT INTO `livestock`(animal_type,breed,quantity,birth_date,status) VALUES(?,?,?,?,?)");
     $insert_livestock->execute([$animal_type,$breed,$quantity,$birth_date,$status]);
     $message[] = "livestock has been added successfully to the system";
  }

}

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

<section class="add-livestock">
      <h2>Add Livestock</h2>
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
        <input type="date" name="birth_date" required>
        </div>
        <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Healthy">Healthy</option>
            <option value="Sick">Sick</option>
            <option value="Sold">Sold</option>
        </select>
        </div>
        <input type="submit" class="btn" name="add_livestock" value="add livestock">
    </form>
      </section>

      <!-- livestock list starts here -->


    
  <section class="user-management">

<h3 class="title" style="text-align: center;">livestock list</h3>

<table id="livestockTable">
      <thead>
        <tr>
          <th>animal type</th>
          <th>breed</th>
          <th>quantity</th>
          <th>birth date</th>
          <th>status</th>
          <th>Action</th>
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
                  <div class="flex-btn">
                      <a href="edit_livestock.php?edit=<?= $fetch_livestock['id'];?>" class="option-btn">edit</a>
                      <a href="add_livestock.php?delete=<?= $fetch_livestock['id'];?>" class="delete-btn" onclick="return confirm('delete this livestock');">delete </a>
                  </div>
          </td>
          <td>
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no livestock has been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>
</body>
</html>