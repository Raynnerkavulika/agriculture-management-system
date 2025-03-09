<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farm Analytics - Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
<?php include "admin_header.php";?>

  <main>
    <section class="analytics-section">
      <h2>Farm Performance Overview</h2>
      
      <!-- Overview Stats -->
      <div class="overview-stats">
        <div class="stat-card">
          <h3>Total Crops Planted</h3>
          <p id="totalCrops">1200</p>
        </div>
        <div class="stat-card">
          <h3>Total Harvested Crops</h3>
          <p id="totalHarvested">800</p>
        </div>
        <div class="stat-card">
          <h3>Total Livestock</h3>
          <p id="totalLivestock">350</p>
        </div>
        <div class="stat-card">
          <h3>Total Revenue</h3>
          <p id="totalRevenue">Ksh 1,500,000</p>
        </div>
      </div>

      <!-- Graphs and Charts -->
      <div class="charts-container">
        <div class="chart">
          <h3>Crop Yield Analysis (Last 6 Months)</h3>
          <canvas id="cropYieldChart"></canvas>
        </div>
        <div class="chart">
          <h3>Revenue vs. Expenses</h3>
          <canvas id="revenueExpenseChart"></canvas>
        </div>
      </div>

      <!-- Data Filters -->
      <div class="filters">
        <label for="timePeriod">Select Time Period:</label>
        <select id="timePeriod">
          <option value="weekly">Weekly</option>
          <option value="monthly">Monthly</option>
          <option value="yearly">Yearly</option>
        </select>

        <label for="cropType">Select Crop Type:</label>
        <select id="cropType">
          <option value="all">All</option>
          <option value="maize">Maize</option>
          <option value="beans">Beans</option>
          <!-- Add more crops here -->
        </select>
      </div>

      <!-- Alerts and Notifications -->
      <div class="alerts">
        <h3>Alerts</h3>
        <ul>
          <li>Next harvest due in 5 days</li>
          <li>Livestock medical checkup required</li>
        </ul>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Farm Analytics</p>
  </footer>

  <script src="scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
