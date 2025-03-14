<?php  
include "config.php";
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};

if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_revenue = $conn->prepare("DELETE FROM `revenue` WHERE id=?");
  $delete_revenue->execute([$delete_id]);
  $message[] ="revenue details have been deleted successfully";
}; 


if(isset($_POST["add_revenue"])){

  $sale_date = $_POST["sale_date"];
  $amount = $_POST["amount"];
  $description = $_POST['description'];

  $select_revenue = $conn->prepare("SELECT * FROM `revenue` WHERE sale_date = ?");
  $select_revenue->execute([$sale_date]);

  if($select_revenue->rowCount() >0){
      $message[] = "This revenue details have been added to the system already";       
  }else{
     $insert_revenue = $conn->prepare("INSERT INTO `revenue`(sale_date,amount,description) VALUES(?,?,?)");
     $insert_revenue->execute([$sale_date,$amount,$description]);
     $message[] = "revenue details have been added successfully to the system";
  }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add revenue</title>
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

<section class="add-revenue">
      <h2>Add Revenue</h2>
    <form action="" method="POST">
      <div class="form-group">
        <label for="sale_date">Date:</label>
        <input type="date" name="sale_date" required>
        </div>
        <div class="form-group">
        <label for="amount">Amount (KES):</label>
        <input type="number" name="amount" required>
        </div>
        <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description"></textarea>
        </div>
        <input type="submit" class="btn" name="add_revenue" value="add revenue">
    </form>
      </section>

<section class="user-management">

<h3 class="title" style="text-align: center;">revenue list</h3>

<table id="revenueTable">
      <thead>
        <tr>
          <th>sale date</th>
          <th>amount</th>
          <th>description</th>
          <th>Action</th>
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
          <td>
                  <div class="flex-btn">
                      <a href="edit_revenue.php?edit=<?= $fetch_revenue['id'];?>" class="option-btn">edit</a>
                      <a href="add_revenue.php?delete=<?= $fetch_revenue['id'];?>" class="delete-btn" onclick="return confirm('delete this revenue details');">delete </a>
                  </div>
          </td>
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no revenue details has been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>


</body>
</html>