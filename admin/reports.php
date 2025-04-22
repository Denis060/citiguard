<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';
require_once '../model/ReportModel.php';

$regions = $conn->query("SELECT id, name FROM regions ORDER BY name ASC");
$districts = $conn->query("SELECT id, name, region_id FROM districts ORDER BY name ASC");
$chiefdoms = $conn->query("SELECT id, name, district_id FROM chiefdoms ORDER BY name ASC");

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$reports = ReportModel::getAllReports($conn, $limit, $offset);
$totalReports = ReportModel::getTotalCount($conn);
$totalPages = ceil($totalReports / $limit);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="admin-container d-flex">
  <?php include 'includes/sidebar.php'; ?>

  <div class="container-fluid p-4">

    <main class="dashboard">
      <h1>Manage Reports</h1>

      <!-- Export Buttons -->
      <div class="export-buttons d-flex flex-wrap gap-2 mb-4">
        <a href="controller/export_pdf.php?<?= http_build_query($_GET) ?>" class="btn btn-outline-danger">
          <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="controller/export_csv.php?<?= http_build_query($_GET) ?>" class="btn btn-outline-success">
          <i class="fas fa-file-csv"></i> Export CSV
        </a>
      </div>

      <!-- FILTER FORM -->
      <form method="GET" class="filter-form row g-3 mb-4">
        <div class="col-md-2">
          <label for="id" class="form-label">Ticket ID</label>
          <input type="text" name="id" id="id" class="form-control" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
        </div>
        <div class="col-md-2">
          <label for="type" class="form-label">Type</label>
          <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($_GET['type'] ?? '') ?>">
        </div>
        <div class="col-md-2">
          <label for="region" class="form-label">Region</label>
          <select name="region" id="region" class="form-select">
            <option value="">-- All Regions --</option>
            <?php while ($r = $regions->fetch_assoc()): ?>
              <option value="<?= $r['id'] ?>" <?= ($_GET['region'] ?? '') == $r['id'] ? 'selected' : '' ?>>
                <?= $r['name'] ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label for="district" class="form-label">District</label>
          <select name="district" id="district" class="form-select">
            <option value="">-- All Districts --</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="chiefdom" class="form-label">Chiefdom</label>
          <select name="chiefdom" id="chiefdom" class="form-select">
            <option value="">-- All Chiefdoms --</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="from_date" class="form-label">Date From</label>
          <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
        </div>
        <div class="col-md-2">
          <label for="to_date" class="form-label">Date To</label>
          <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Apply Filters</button>
          <a href="reports.php" class="btn btn-secondary">Reset</a>
        </div>
      </form>

      <!-- Report Table -->
      <?php if (empty($reports)): ?>
        <div class="alert alert-warning">No reports found for the selected filters.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="admin-table table table-bordered table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Region</th>
                <th>District</th>
                <th>Chiefdom</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reports as $report): ?>
                <tr>
                  <td><?= htmlspecialchars($report['tracking_id']) ?></td>
                  <td><?= htmlspecialchars($report['type']) ?></td>
                  <td><?= htmlspecialchars($report['region_name'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($report['district_name'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($report['chiefdom_name'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($report['location']) ?></td>
                  <td><?= htmlspecialchars($report['date']) ?></td>
                  <td>
                    <span class="badge bg-<?= strtolower($report['status']) === 'pending' ? 'warning' : 'success' ?>">
                      <?= htmlspecialchars($report['status']) ?>
                    </span>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-info" href="view_report.php?id=<?= $report['id'] ?>">View</a>
                    <?php if ($report['status'] === 'Pending'): ?>
                      <a class="btn btn-sm btn-success" href="controller/mark_reviewed.php?id=<?= $report['id'] ?>">Mark Reviewed</a>
                    <?php endif; ?>
                    <?php if (in_array($_SESSION['admin_role'], ['admin', 'super'])): ?>
                      <a class="btn btn-sm btn-danger" href="controller/delete_report.php?id=<?= $report['id'] ?>"
                         onclick="return confirm('Are you sure you want to delete this report?')">
                        Delete
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <!-- Pagination -->
      <div class="pagination mt-4">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?page=<?= $i ?>" class="btn btn-sm <?= ($i == $page) ? 'btn-primary' : 'btn-outline-secondary' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>

    </main>
  </div>
</div>

<script src="js/filter-location.js"></script>
<?php include 'includes/admin_footer.php'; ?>
