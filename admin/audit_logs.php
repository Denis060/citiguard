<?php
// admin/audit_logs.php

session_start();

// 🔐 Only Super Admins allowed
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

// Fetch all logs
$logs = $conn->query("SELECT * FROM logs ORDER BY created_at DESC");
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>Audit Logs</h1>

    <p style="margin-bottom: 15px; color: #666;">All actions performed by admins are recorded here for transparency and accountability.</p>

    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Admin Email</th>
            <th>Action</th>
            <th>IP Address</th>
            <th>Device</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <?php $count = 1; ?>
          <?php while ($row = $logs->fetch_assoc()): ?>
            <tr>
              <td><?= $count++ ?></td>
              <td><?= htmlspecialchars($row['admin_email']) ?></td>
              <td><?= htmlspecialchars($row['action']) ?></td>
              <td><?= htmlspecialchars($row['ip_address']) ?></td>
              <td><?= htmlspecialchars($row['user_agent']) ?></td>
              <td><?= date('F j, Y, g:i a', strtotime($row['created_at'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
