<?php
session_start();

// 🔐 Only Super Admins can access
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "An admin with this email already exists.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO admins (email, password, role) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $email, $hashedPassword, $role);
        if ($insert->execute()) {
            $success = "Admin account created successfully.";
        } else {
            $error = "Failed to create admin.";
        }
    }
}
?>

<?php include 'includes/admin_header.php'; ?>
<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1 class="page-title">Add New Admin</h1>

    <?php if ($success): ?>
      <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="alert danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="" class="form-container">
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Role:</label>
        <select name="role" class="form-control" required>
          <option value="admin">Admin</option>
          <option value="moderator">Moderator</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">➕ Add Admin</button>
    </form>
  </main>
</div>
<?php include 'includes/admin_footer.php'; ?>
