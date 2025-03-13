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
    <title>add revenue</title>
      <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
    

<?php include "admin_header.php";?>


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

</body>
</html>