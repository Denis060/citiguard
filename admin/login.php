<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Retrieve and clear login error from session
$login_error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login – CitiGuard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <style>
    body {
      background-color: #f4f6f9;
    }

    .login-container {
      max-width: 400px;
      margin: 100px auto;
      background-color: white;
      padding: 40px 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    .login-container h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 25px;
    }

    .login-container label {
      font-weight: bold;
      display: block;
      margin-bottom: 8px;
      color: #333;
    }

    .login-container input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .login-container button {
      width: 100%;
      padding: 12px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color: #00509e;
    }

    .error-msg {
      background: #ffe3e3;
      color: #d8000c;
      padding: 10px;
      margin-bottom: 15px;
      border-left: 4px solid #d8000c;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>CitiGuard Admin Login</h2>

  <?php if ($login_error): ?>
    <div class="error-msg"><?= htmlspecialchars($login_error) ?></div>
  <?php endif; ?>

  <form method="post" action="auth.php">
    <label for="email">Admin Email</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
