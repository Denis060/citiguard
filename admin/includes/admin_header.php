<?php
// includes/admin_header.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$adminRole = $_SESSION['admin_role'] ?? '';
$adminEmail = $_SESSION['admin_email'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>CitiGuard Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/Citiguard/assets/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="admin-header">
  <div class="container d-flex justify-content-between align-items-center">
    <div class="brand d-flex align-items-center gap-3">
      <img src="/Citiguard/assets/img/logo.png" alt="CitiGuard Logo" style="height: 40px;">
      <h2 style="color: white; margin: 0;">CitiGuard Admin</h2>
    </div>
    <nav>
      <ul id="nav-menu" class="d-flex gap-3 list-unstyled mb-0">
        <li><a href="index.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li><a href="reports.php"><i class="fas fa-file-alt"></i> Reports</a></li>

        <?php if ($adminRole === 'super'): ?>
          <li><a href="users.php"><i class="fas fa-users-cog"></i> Users</a></li>
        <?php endif; ?>

        <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
        <li><a href="notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </nav>
  </div>
</header>
