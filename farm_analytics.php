<?php
require 'config.php'; // Database connection

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};

// Fetch Revenue Data
$revenueData = $conn->query("SELECT sale_date, amount FROM revenue")->fetchAll(PDO::FETCH_ASSOC);
$revenueLabels = json_encode(array_column($revenueData, 'sale_date'));
$revenueValues = json_encode(array_column($revenueData, 'amount'));

// Fetch Crop Data
$cropData = $conn->query("SELECT crop_name, expected_yield FROM crops")->fetchAll(PDO::FETCH_ASSOC);
$cropLabels = json_encode(array_column($cropData, 'crop_name'));
$cropValues = json_encode(array_column($cropData, 'expected_yield'));

// Fetch Livestock Data
$livestockData = $conn->query("SELECT animal_type, quantity FROM livestock")->fetchAll(PDO::FETCH_ASSOC);
$livestockLabels = json_encode(array_column($livestockData, 'animal_type'));
$livestockValues = json_encode(array_column($livestockData, 'quantity'));

// Fetch Farmers Count
$farmersCount = $conn->query("SELECT COUNT(*) AS total FROM farmers")->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch Workers Count
$workersCount = $conn->query("SELECT COUNT(*) AS total FROM workers")->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch Tasks Count
$tasksCount = $conn->query("SELECT COUNT(*) AS total FROM tasks")->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch Farms Count
$farmsCount = $conn->query("SELECT COUNT(*) AS total FROM farms")->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Analytics</title>

          <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- custom css link -->
  <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .chart-container { width: 60%; margin: auto; }
        .stats { display: flex; justify-content: space-around; margin:10px 0; }
        .stats div { margin-top:2.7rem;padding: 20px; border-radius: .5rem; background: lightgray; font-size: 20px; }
    </style>
</head>
<body>

<?php include "admin_header.php";?>
    <h2 style="font-size:2.8rem;margin-top:2.3rem;">Farm Analytics</h2>

    <!-- Statistics Overview -->
    <div class="stats">
        <div>Farmers: <b><?= $farmersCount ?></b></div>
        <div>Workers: <b><?= $workersCount ?></b></div>
        <div>Tasks: <b><?= $tasksCount ?></b></div>
        <div>Farms: <b><?= $farmsCount ?></b></div>
    </div>

    <div class="chart-container">
        <h3>Revenue Trend</h3>
        <canvas id="revenueChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Crop Production</h3>
        <canvas id="cropChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Livestock Distribution</h3>
        <canvas id="livestockChart"></canvas>
    </div>

    <script>
        // Revenue Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: <?= $revenueLabels ?>,
                datasets: [{
                    label: 'Revenue (KES)',
                    data: <?= $revenueValues ?>,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.1)',
                    fill: true
                }]
            }
        });

        // Crop Production Chart
        new Chart(document.getElementById('cropChart'), {
            type: 'bar',
            data: {
                labels: <?= $cropLabels ?>,
                datasets: [{
                    label: 'Expected Yield (kg)',
                    data: <?= $cropValues ?>,
                    backgroundColor: 'green'
                }]
            }
        });

        // Livestock Distribution Chart
        new Chart(document.getElementById('livestockChart'), {
            type: 'pie',
            data: {
                labels: <?= $livestockLabels ?>,
                datasets: [{
                    label: 'Quantity',
                    data: <?= $livestockValues ?>,
                    backgroundColor: ['red', 'blue', 'yellow', 'purple', 'orange']
                }]
            }
        });
    </script>


<script src="script.js"></script>
</body>
</html>
