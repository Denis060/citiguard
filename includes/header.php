<?php
$path = (strpos($_SERVER['PHP_SELF'], '/view/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CitiGuard – Tok di Tru. Fix di System.</title>
  <link rel="stylesheet" href="<?= $path ?>assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    header {
      position: sticky;
      top: 0;
      z-index: 999;
      background-color: ##002f5f;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .language-switcher {
      margin-left: auto;
      margin-right: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <div class="container nav-container" style="display: flex; align-items: center; justify-content: space-between;">
      <div class="brand">
        <img src="<?= $path ?>assets/img/logo.png" alt="CitiGuard Logo" class="logo" />
        <div style="line-height: 1;">
          <h2 style="margin: 0;">CitiGuard</h2>
          <small style="color: #555; font-size: 0.8rem;">Tok di Tru. Fix di System.</small>
        </div>
      </div>

      <div class="language-switcher">
        <select onchange="alert('Language switching coming soon...')">
          <option value="en">English</option>
          <option value="kr">Krio</option>
        </select>
      </div>

      <button class="menu-toggle" onclick="toggleMenu()">☰</button>
      <nav>
        <ul id="nav-menu">
          <li><a href="<?= $path ?>index.php">Home</a></li>
          <li><a href="<?= $path ?>view/report.php">Report Misconduct</a></li>
          <li><a href="<?= $path ?>view/track.php">Track Report</a></li>
          <li><a href="<?= $path ?>view/rights.php">Know Your Rights</a></li>
          <li><a href="<?= $path ?>view/about.php">About</a></li>
          <li><a href="<?= $path ?>view/privacy.php">Privacy</a></li>
        </ul>
      </nav>
    </div>
  </header>
