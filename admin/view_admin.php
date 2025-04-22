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

$stmt = $conn->prepare("SELECT id, email, role, created_at FROM admins WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    header("Location: users.php");
    exit();
}
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>Admin Details</h1>

    <div class="card p-4 shadow-sm" style="max-width: 500px;">
      <p><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></p>
      <p><strong>Role:</strong> 
        <span class="badge <?= $admin['role'] === 'super' ? 'bg-dark' : ($admin['role'] === 'admin' ? 'bg-primary' : 'bg-info') ?>">
          <?= ucfirst($admin['role']) ?>
        </span>
      </p>
      <p><strong>Created At:</strong> <?= date('d M Y', strtotime($admin['created_at'])) ?></p>

      <a href="users.php" class="btn btn-secondary mt-3">← Back to Admin List</a>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
