<?php
// includes/sidebar.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$adminRole = $_SESSION['admin_role'] ?? '';
?>

<div class="sidebar">
  <ul>
    <li><a href="index.php">📊 Dashboard</a></li>
    <li><a href="reports.php">📝 Reports</a></li>

    <?php if ($adminRole === 'super'): ?>
      <li><a href="users.php">👥 Users</a></li>
      <li><a href="audit_logs.php">🧾 Audit Logs</a></li>
      <li><a href="deleted_reports.php">🗑️ Deleted Reports</a></li>
    <?php endif; ?>

    <li><a href="settings.php">⚙️ Settings</a></li>
    <li><a href="logout.php">🚪 Logout</a></li>
  </ul>
</div>
