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
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Agricultural Management</title>
   <!-- font awesome cdn link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
<?php include "admin_header.php"; ?>

  <main>
      <h3 class="title" style="margin-left:5rem;">Farm Overview</h3>
    <section class="overview">
      
      <div class="stat-card">
              <?php
                    $select_farm = $conn->prepare("SELECT * FROM `farms`");
                    $select_farm->execute();
                    $number_of_farm = $select_farm->rowCount();
              ?>
              <h3><?= $number_of_farm;?></h3>
              <p>total farms</p>
      </div>
      <div class="stat-card">
              <?php
                    $select_farmer = $conn->prepare("SELECT * FROM `farmers`");
                    $select_farmer->execute();
                    $number_of_farmer = $select_farmer->rowCount();
              ?>
        <h3><?= $number_of_farmer?></h3>
        <p>Total Farmers</p>
      </div>
      <div class="stat-card">
              <?php
                    $select_worker = $conn->prepare("SELECT * FROM `workers`");
                    $select_worker->execute();
                    $number_of_worker = $select_worker->rowCount();
              ?>
        <h3><?= $number_of_worker?></h3>
        <p>Total Workers</p>
      </div>
      <div class="stat-card">
              <?php
                    $select_revenue = $conn->prepare("SELECT * FROM `revenue`");
                    $select_revenue->execute();
                    $total_revenue = $select_revenue->rowCount();
              ?>

              <h3>Sh <?= $total_revenue;?>/=</h3>
              <p>total revenue</p>
      </div>
    </section>

    <section class="task-assignment">
      <h2 class="title">Recent Task Assignments</h2>
      <table>
        <tr>
          <th>Task</th>
          <th>Assigned To</th>
          <th>Deadline</th>
          <th>Status</th>
        </tr>
        <tr>
          <td>Water Crops</td>
          <td>Farmer 1</td>
          <td>2025-02-19</td>
          <td>Completed</td>
        </tr>
        <tr>
          <td>Feed Livestock</td>
          <td>Worker 3</td>
          <td>2025-02-18</td>
          <td>Pending</td>
        </tr>
      </table>
    </section>

    <section class="user-management">
      <h2 class="title">User Management</h2>
      
      <div class="flex-btn">
        <a href="manage_farmer.php" class="btn">add farmer</a>
        <a href="manage_worker.php" class="option-btn">add worker</a>
      </div>

      <h3 style="margin-top: 2.4rem;font-size:1.6rem;">Farmers list</h3>
      <table>
        <tr>
          <th>Name</th>
          <th>Farm Location</th>
          <th>phone number</th>
          <th>Farm type</th>
        </tr>
        <tr>

                <?php
                    $select_farmer = $conn->prepare("SELECT * FROM `farmers`");
                    $select_farmer->execute();
                    $fetch_farmer = $select_farmer->fetch(PDO::FETCH_ASSOC);
        
                ?>
          <td><?= $fetch_farmer['farmer_name'];?></td>
          <td><?= $fetch_farmer['farm_location'];?></td>
          <td><?= $fetch_farmer['farmer_number'];?></td>
          <td><?= $fetch_farmer['farm_type'];?></td>
        </tr>
      </table>

      <h3 style="margin-top: 2.4rem;font-size:1.6rem;">Workers list</h3>
      <table>
        <tr>
          <th>Name</th>
          <th>Assigned Tasks</th>
          <th>status</th>
          <th>phone number</th>
        </tr>
        <tr>
                <?php
                    $select_worker = $conn->prepare("SELECT * FROM `workers`");
                    $select_worker->execute();
                    $fetch_worker = $select_worker->fetch(PDO::FETCH_ASSOC);
        
                ?>
          <td><?= $fetch_worker['full_name'];?></td>
          <td><?= $fetch_worker['department'];?></td>
          <td><?= $fetch_worker['status'];?></td>
          <td><?= $fetch_worker['phone'];?></td>
        </tr>
      </table>
    </section>

    <section class="analytics">
      <h2 class="title">Farm Analytics</h2>
      <div class="charts">
        <!-- Placeholder for charts (you can integrate tools like Chart.js here) -->
        <div class="chart">Farm Revenue Trend</div>
        <div class="chart">Crop Growth Analysis</div>
        <div class="chart">Livestock Health Monitoring</div>
      </div>
    </section>
  </main>

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
