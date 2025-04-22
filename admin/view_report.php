<?php
session_start();

// 🔐 Only logged-in users with admin/super role can access
if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';
require_once '../model/ReportModel.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    include 'includes/admin_header.php';
    echo "<main class='dashboard'><h2>Invalid Report ID</h2></main>";
    include 'includes/admin_footer.php';
    exit();
}

$report_id = intval($_GET['id']);

// ✅ Fetch report using JOIN to get region, district, chiefdom names
$sql = "
SELECT 
    r.*, 
    rg.name AS region_name, 
    d.name AS district_name, 
    c.name AS chiefdom_name
FROM reports r
LEFT JOIN regions rg ON r.region = rg.id
LEFT JOIN districts d ON r.district = d.id
LEFT JOIN chiefdoms c ON r.chiefdom = c.id
WHERE r.id = ?
LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();
$report = $result->fetch_assoc();

if (!$report) {
    include 'includes/admin_header.php';
    echo "<main class='dashboard'><h2>Report not found</h2></main>";
    include 'includes/admin_footer.php';
    exit();
}

include 'includes/admin_header.php';
?>

<div class="admin-container">
  <?php include 'includes/sidebar.php'; ?>

  <main class="dashboard">
    <h2>Report Details – <?= htmlspecialchars($report['tracking_id']) ?></h2>

    <div class="report-details card">
      <p><strong>Type:</strong> <?= htmlspecialchars($report['type']) ?></p>
      <p><strong>Date:</strong> <?= htmlspecialchars($report['date']) ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($report['location']) ?></p>
      <p><strong>Submitted On:</strong> <?= date("F j, Y, g:i a", strtotime($report['timestamp'])) ?></p>

      <!-- ✅ Display full location info -->
      <p>
        <strong>Region:</strong> <?= htmlspecialchars($report['region_name'] ?? '—') ?> | 
        <strong>District:</strong> <?= htmlspecialchars($report['district_name'] ?? '—') ?> | 
        <strong>Chiefdom:</strong> <?= htmlspecialchars($report['chiefdom_name'] ?? '—') ?>
      </p>

      <p><strong>Status:</strong>
        <span class="status <?= strtolower($report['status']) ?>">
          <?= htmlspecialchars($report['status']) ?>
        </span>
      </p>
      <p><strong>Description:</strong></p>
      <div class="description-box"><?= nl2br(htmlspecialchars($report['description'])) ?></div>

      <?php if (!empty($report['contact'])): ?>
        <p><strong>Contact:</strong> <?= htmlspecialchars($report['contact']) ?></p>
      <?php endif; ?>

      <?php if (!empty($report['evidence'])): ?>
        <div class="evidence-box">
          <strong>Evidence:</strong><br>
          <?php
            $basename = basename($report['evidence']);
            $fullPath = "../uploads/$basename";
            $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
              echo "<img src='$fullPath' alt='evidence' style='max-width: 300px; border-radius: 6px;'>";
            } elseif (in_array($ext, ['mp3', 'wav'])) {
              echo "<audio controls><source src='$fullPath' type='audio/$ext'></audio>";
            } elseif (in_array($ext, ['mp4', 'webm'])) {
              echo "<video controls width='300'><source src='$fullPath' type='video/$ext'></video>";
            } else {
              echo "<a href='$fullPath' download class='btn-download'>Download Evidence</a>";
            }
          ?>
        </div>
      <?php endif; ?>

      <div class="action-buttons" style="margin-top: 25px;">
        <a href="reports.php" class="btn-view">← Back to Reports</a>
        <?php if ($report['status'] === 'Pending'): ?>
          <a href="controller/mark_reviewed.php?id=<?= $report['id'] ?>" class="btn-approve">✅ Mark as Reviewed</a>
        <?php endif; ?>
      </div>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
