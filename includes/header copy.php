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
</head>
<body>
  <header>
    <div class="container nav-container">
      <div class="brand">
        <img src="<?= $path ?>assets/img/logo.png" alt="CitiGuard Logo" class="logo" />
        <h2>CitiGuard</h2>
      </div>
      <button class="menu-toggle" onclick="toggleMenu()">☰</button>
      <nav>
        <ul id="nav-menu">
          <li><a href="<?= $path ?>index.php">Home</a></li>
          <li><a href="<?= $path ?>view/report.php">Report Misconduct</a></li>
          <li><a href="<?= $path ?>view/rights.php">Know Your Rights</a></li>
          <li><a href="<?= $path ?>view/about.php">About</a></li>
          <li><a href="<?= $path ?>view/privacy.php">Privacy</a></li>
        </ul>
      </nav>
    </div>
  </header>
