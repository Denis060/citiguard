<?php
// admin/deleted_reports.php

session_start();

// ✅ Secure access: only 'admin' or 'super'
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
  <form method="GET" class="filter-form" style="margin-bottom: 20px;">
  <div style="flex: 1; min-width: 160px;">
  <label for="id" style="font-weight: 600;">Ticket ID:</label><br>
  <input type="text" name="id" id="id" class="form-control" placeholder="e.g. CITI-680273D1E97AD" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
</div>

  <label>Type:</label>
  <input type="text" name="type" placeholder="e.g. Verbal Abuse" value="<?= htmlspecialchars($_GET['type'] ?? '') ?>">

  <label>Location:</label>
  <input type="text" name="location" placeholder="e.g. Freetown" value="<?= htmlspecialchars($_GET['location'] ?? '') ?>">

  <label>Date From:</label>
  <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">

  <label>Date To:</label>
  <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">

  <button type="submit">Filter</button>
  <a href="deleted_reports.php"><button type="button">Reset</button></a>
</form>
  <main class="dashboard">
    <h1>Deleted Reports (Trash)</h1>

    <div class="table-responsive">
      <table class="admin-table">
        <thead>
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
              <td colspan="7">No deleted reports found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($deletedReports as $report): ?>
              <tr>
                <td><?= htmlspecialchars($report['tracking_id']) ?></td>
                <td><?= htmlspecialchars($report['type']) ?></td>
                <td><?= htmlspecialchars($report['location']) ?></td>
                <td><?= htmlspecialchars($report['date']) ?></td>
                <td><span class="status"><?= htmlspecialchars($report['status']) ?></span></td>
                <td><?= isset($report['deleted_at']) ? htmlspecialchars($report['deleted_at']) : '—' ?></td>
                <td>
                  <!-- Restore and Permanently Delete buttons -->
                  <a href="controller/restore_report.php?id=<?= $report['id'] ?>" class="btn-view">Restore</a>
                  <a href="controller/permanent_delete_report.php?id=<?= $report['id'] ?>" class="btn-delete" onclick="return confirm('Permanently delete this report?')">Delete Permanently</a>
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
