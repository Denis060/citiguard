<?php
// includes/admin_header.php

// ✅ This should be loaded before include if not already
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
  <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
    <div class="brand" style="display: flex; align-items: center; gap: 10px;">
      <img src="/Citiguard/assets/img/logo.png" alt="CitiGuard Logo" class="logo" style="height: 40px;">
      <h2 style="color: #0f3b61;">CitiGuard Admin</h2>
    </div>
    <nav>
      <ul id="nav-menu" style="display: flex; gap: 15px;">
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="reports.php">Reports</a></li>

        <?php if ($adminRole === 'super'): ?>
          <li><a href="users.php">Users</a></li>
        <?php endif; ?>

        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
</header>
