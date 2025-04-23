<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'super') {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

// Handle search
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM logs";
if (!empty($search)) {
    $safeSearch = $conn->real_escape_string($search);
    $query .= " WHERE admin_email LIKE '%$safeSearch%' OR action LIKE '%$safeSearch%'";
}
$query .= " ORDER BY created_at DESC";

$logs = $conn->query($query);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h1>Audit Logs</h1>

    <p class="text-muted mb-3">All admin actions are recorded here for full transparency.</p>

    <!-- Search Bar -->
    <form method="GET" class="d-flex gap-2 mb-4 flex-wrap">
      <input type="text" name="search" class="form-control" placeholder="Search by admin or action..." value="<?= htmlspecialchars($search) ?>" />
      <button class="btn btn-outline-primary">Search</button>
      <a href="audit_logs.php" class="btn btn-outline-secondary">Reset</a>
    </form>
    <div class="mb-3">
  <a href="controller/export_logs.php?<?= http_build_query($_GET) ?>" class="btn btn-success">
    <i class="fas fa-file-csv"></i> Export Logs to CSV
  </a>
</div>

    <div class="table-responsive">
      <table class="admin-table table table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Admin Email</th>
            <th>Action</th>
            <th>IP Address</th>
            <th>Device</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($logs->num_rows === 0): ?>
            <tr><td colspan="6" class="text-center text-muted">No audit logs found.</td></tr>
          <?php else: ?>
            <?php $count = 1; ?>
            <?php while ($row = $logs->fetch_assoc()): ?>
              <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($row['admin_email']) ?></td>
                <td>
                  <span class="badge bg-info"><?= htmlspecialchars($row['action']) ?></span>
                </td>
                <td style="white-space: nowrap;"><?= htmlspecialchars($row['ip_address']) ?></td>
                <td style="max-width: 300px; word-wrap: break-word;"><?= htmlspecialchars($row['user_agent']) ?></td>
                <td><?= date('d M Y, g:i a', strtotime($row['created_at'])) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
