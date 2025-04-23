<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

// 🔄 Mark all as read
$conn->query("UPDATE notifications SET is_read = 1 WHERE is_read = 0");

// Fetch all notifications
$notifications = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>Notifications</h1>

    <?php if ($notifications->num_rows === 0): ?>
      <div class="alert alert-info">No notifications available.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover admin-table">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Type</th>
              <th>Message</th>
              <th>Report ID</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; while ($row = $notifications->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><span class="badge bg-info"><?= htmlspecialchars($row['type']) ?></span></td>
                <td><?= htmlspecialchars($row['message']) ?></td>
                <td>
                  <?php if ($row['report_id']): ?>
                    <a href="view_report.php?id=<?= $row['report_id'] ?>">View Report</a>
                  <?php else: ?>—
                  <?php endif; ?>
                </td>
                <td><?= date('d M Y, g:i a', strtotime($row['created_at'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
