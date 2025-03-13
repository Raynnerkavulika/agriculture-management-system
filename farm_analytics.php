<?php
require 'config.php'; // Database connection

// Fetch Revenue Data
// $revenueQuery = $pdo->query("SELECT MONTH(sale_date) AS month, SUM(amount) AS total FROM revenue GROUP BY MONTH(sale_date)");
// $revenueData = [];
// while ($row = $revenueQuery->fetch(PDO::FETCH_ASSOC)) {
//     $revenueData[] = $row;
// }

// Fetch Crop Yield Data
// $cropQuery = $pdo->query("SELECT crop_name, SUM(actual_yield) AS total_yield FROM crops GROUP BY crop_name");
// $cropData = [];
// while ($row = $cropQuery->fetch(PDO::FETCH_ASSOC)) {
//     $cropData[] = $row;
// }

// Fetch Livestock Data
// $livestockQuery = $pdo->query("SELECT animal_type, COUNT(id) AS total FROM livestock GROUP BY animal_type");
// $livestockData = [];
// while ($row = $livestockQuery->fetch(PDO::FETCH_ASSOC)) {
//     $livestockData[] = $row;
// }

// Fetch Worker Performance Data
// $workerQuery = $conn->query("SELECT worker_id, SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed FROM tasks GROUP BY worker_id");
// $workerData = [];
// while ($row = $workerQuery->fetch(PDO::FETCH_ASSOC)) {
//     $workerData[] = $row;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Analytics Report</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Farm Analytics Report</h2>
    
    <div class="chart-container">
    <div class="chart-box">
        <h3>Revenue Trend</h3>
        <canvas id="revenueChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Crop Yield</h3>
        <canvas id="cropChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Livestock Count</h3>
        <canvas id="livestockChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Worker Performance</h3>
        <canvas id="workerChart"></canvas>
    </div>
</div>

    
    <script>
        // Revenue Chart
        const revenueData = <?php echo json_encode($revenueData); ?>;
        const revenueLabels = revenueData.map(row => 'Month ' + row.month);
        const revenueValues = revenueData.map(row => row.total);
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{ label: 'Revenue', data: revenueValues, backgroundColor: 'blue' }]
            }
        });

        // Crop Yield Chart
        const cropData = <?php echo json_encode($cropData); ?>;
        const cropLabels = cropData.map(row => row.crop_name);
        const cropValues = cropData.map(row => row.total_yield);
        new Chart(document.getElementById('cropChart'), {
            type: 'bar',
            data: {
                labels: cropLabels,
                datasets: [{ label: 'Crop Yield', data: cropValues, backgroundColor: 'green' }]
            }
        });

        // Livestock Chart
        const livestockData = <?php echo json_encode($livestockData); ?>;
        const livestockLabels = livestockData.map(row => row.animal_type);
        const livestockValues = livestockData.map(row => row.total);
        new Chart(document.getElementById('livestockChart'), {
            type: 'pie',
            data: {
                labels: livestockLabels,
                datasets: [{ label: 'Livestock Count', data: livestockValues, backgroundColor: ['red', 'yellow', 'brown'] }]
            }
        });

        // Worker Performance Chart
        const workerData = <?php echo json_encode($workerData); ?>;
        const workerLabels = workerData.map(row => 'Worker ' + row.worker_id);
        const workerValues = workerData.map(row => row.completed);
        new Chart(document.getElementById('workerChart'), {
            type: 'bar',
            data: {
                labels: workerLabels,
                datasets: [{ label: 'Tasks Completed', data: workerValues, backgroundColor: 'orange' }]
            }
        });
    </script>
</body>
</html>
