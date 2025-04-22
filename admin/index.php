<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$adminEmail = $_SESSION['admin_email'];
$adminRole = $_SESSION['admin_role'];

require_once '../config/db.php';
require_once '../model/DashboardModel.php';

$totalReports     = DashboardModel::getTotalReports($conn);
$pendingReports   = DashboardModel::getPendingReports($conn);
$reviewedReports  = DashboardModel::getReviewedReports($conn);
$deletedReports   = DashboardModel::getDeletedReports($conn);
$topLocation      = DashboardModel::getTopLocation($conn);
$topType          = DashboardModel::getTopComplaintType($conn);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($adminEmail) ?>!</h1>

    <div class="dashboard-widgets" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
      <div class="widget card bg-light p-3 shadow-sm" style="min-width: 200px;"><h5>Total Reports</h5><strong><?= $totalReports ?></strong></div>
      <div class="widget card bg-warning p-3 shadow-sm" style="min-width: 200px;"><h5>Pending</h5><strong><?= $pendingReports ?></strong></div>
      <div class="widget card bg-success text-white p-3 shadow-sm" style="min-width: 200px;"><h5>Reviewed</h5><strong><?= $reviewedReports ?></strong></div>
      <div class="widget card bg-danger text-white p-3 shadow-sm" style="min-width: 200px;"><h5>Deleted</h5><strong><?= $deletedReports ?></strong></div>
      <div class="widget card bg-info p-3 shadow-sm" style="min-width: 200px;"><h5>Top Location</h5><strong><?= $topLocation ?></strong></div>
      <div class="widget card bg-secondary text-white p-3 shadow-sm" style="min-width: 200px;"><h5>Top Complaint Type</h5><strong><?= $topType ?></strong></div>
    </div>

    <!-- Chart Display -->
    <div class="chart-wrapper" style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 40px;">
      <div class="chart-box card p-3 shadow-sm" style="flex: 1 1 45%; min-width: 300px;">
        <h5>Monthly Report Trend</h5>
        <canvas id="monthlyChart"></canvas>
      </div>

      <div class="chart-box card p-3 shadow-sm" style="flex: 1 1 45%; min-width: 300px;">
        <h5>Reports by Type</h5>
        <canvas id="barChart" width="400" height="200"></canvas>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Dynamic Monthly Line Chart
    fetch('controller/get_monthly_report_data.php')
      .then(res => res.json())
      .then(data => {
        const lineCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(lineCtx, {
          type: 'line',
          data: {
            labels: data.months,
            datasets: [{
              label: 'Reports',
              data: data.totals,
              borderColor: 'rgb(75, 192, 192)',
              fill: false,
              tension: 0.3
            }]
          },
          options: { responsive: true }
        });
      })
      .catch(err => console.error('Monthly chart error:', err));

    // Bar chart from live data
    fetch('controller/get_report_type_data.php')
      .then(response => response.json())
      .then(data => {
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
          type: 'bar',
          data: {
            labels: data.types,
            datasets: [{
              label: 'Number of Reports',
              data: data.counts,
              backgroundColor: 'rgba(54, 162, 235, 0.6)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: { beginAtZero: true, ticks: { precision: 0 } }
            }
          }
        });
      })
      .catch(err => console.error('Bar chart error:', err));
    </script>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
