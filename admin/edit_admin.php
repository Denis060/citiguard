<?php
session_start();

// Super Admin only
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: users.php");
    exit();
}

// Prevent editing self
if ($_SESSION['admin_id'] == $id) {
    header("Location: users.php");
    exit();
}

// Fetch user
$stmt = $conn->prepare("SELECT id, email, role FROM admins WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin || $admin['role'] === 'super') {
    header("Location: users.php"); // Can't edit Super Admin
    exit();
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newRole = $_POST['role'];

    if (!in_array($newRole, ['admin', 'moderator'])) {
        $errors[] = "Invalid role selected.";
    }

    if (empty($errors)) {
        $update = $conn->prepare("UPDATE admins SET role = ? WHERE id = ?");
        $update->bind_param("si", $newRole, $id);
        $update->execute();

        $success = "Admin role updated successfully.";
        $admin['role'] = $newRole;
    }
}
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard" style="max-width: 600px;">
    <h1>Edit Admin Role</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow-sm">
      <p><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></p>

      <form method="POST">
        <label for="role" class="form-label">Change Role:</label>
        <select name="role" id="role" class="form-select">
          <option value="admin" <?= $admin['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          <option value="moderator" <?= $admin['role'] === 'moderator' ? 'selected' : '' ?>>Moderator</option>
        </select>

        <button type="submit" class="btn btn-warning mt-3">Update Role</button>
        <a href="users.php" class="btn btn-secondary mt-3">Cancel</a>
      </form>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
