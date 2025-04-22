<?php
session_start();

// 🔐 Super Admin only
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

// 🔍 Search Logic
$search = $_GET['search'] ?? '';
$query = "SELECT id, email, role, created_at FROM admins";
if (!empty($search)) {
    $query .= " WHERE email LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$query .= " ORDER BY created_at DESC";

$result = $conn->query($query);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>Manage Admin Users</h1>

    <!-- Search + Add -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <form method="GET" class="d-flex gap-2 flex-wrap">
        <input type="text" name="search" class="form-control" placeholder="Search by email..." value="<?= htmlspecialchars($search) ?>" />
        <button class="btn btn-outline-primary">Search</button>
        <a href="users.php" class="btn btn-outline-secondary">Reset</a>
      </form>
      <a href="add_admin.php" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add New Admin
      </a>
    </div>

    <!-- Users Table -->
    <div class="table-responsive">
      <table class="admin-table table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="5" class="text-center text-muted">No admin accounts found.</td></tr>
          <?php else: ?>
            <?php $index = 1; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $index++ ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                  <span class="badge 
                    <?= $row['role'] === 'super' ? 'bg-dark' : 
                        ($row['role'] === 'admin' ? 'bg-primary' : 'bg-info') ?>">
                    <?= ucfirst($row['role']) ?>
                  </span>
                </td>
                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                <td class="d-flex gap-2 flex-wrap">
                  <a href="view_admin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-secondary">View</a>
                  <?php if (
                    $_SESSION['admin_email'] !== $row['email'] &&
                    $row['role'] !== 'super'
                  ): ?>
                    <a href="edit_admin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="controller/delete_admin.php?id=<?= $row['id'] ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                  <?php elseif ($_SESSION['admin_email'] === $row['email']): ?>
                    <span class="text-muted">(You)</span>
                  <?php else: ?>
                    <span class="text-muted">(Protected)</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
