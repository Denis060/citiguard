<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';
require_once '../model/ReportModel.php';

$deletedReports = ReportModel::getDeletedReports($conn);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard container-fluid">
    <h1>Deleted Reports (Trash)</h1>

    <!-- Filter Form -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <label for="id" class="form-label">Ticket ID</label>
        <input type="text" name="id" id="id" class="form-control" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <label for="type" class="form-label">Type</label>
        <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($_GET['type'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($_GET['location'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <label for="from_date" class="form-label">Date From</label>
        <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <label for="to_date" class="form-label">Date To</label>
        <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Apply Filters</button>
        <a href="deleted_reports.php" class="btn btn-secondary">Reset</a>
      </div>
    </form>

    <!-- Deleted Reports Table -->
    <div class="table-responsive">
      <table class="admin-table table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Location</th>
            <th>Date</th>
            <th>Status</th>
            <th>Deleted On</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($deletedReports) === 0): ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No deleted reports found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($deletedReports as $report): ?>
              <tr>
                <td><?= htmlspecialchars($report['tracking_id']) ?></td>
                <td><?= htmlspecialchars($report['type']) ?></td>
                <td><?= htmlspecialchars($report['location']) ?></td>
                <td><?= htmlspecialchars($report['date']) ?></td>
                <td>
                  <span class="badge bg-warning text-dark"><?= htmlspecialchars($report['status']) ?></span>
                </td>
                <td><?= isset($report['deleted_at']) ? htmlspecialchars($report['deleted_at']) : '—' ?></td>
                <td class="d-flex gap-2 flex-wrap">
                  <a href="controller/restore_report.php?id=<?= $report['id'] ?>" class="btn btn-sm btn-success">
                    Restore
                  </a>
                  <a href="controller/permanent_delete_report.php?id=<?= $report['id'] ?>" 
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Are you sure you want to permanently delete this report?')">
                    Delete Permanently
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
