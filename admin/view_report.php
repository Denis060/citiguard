<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'super'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/db.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    include 'includes/admin_header.php';
    echo "<main class='dashboard'><h2>Invalid Report ID</h2></main>";
    include 'includes/admin_footer.php';
    exit();
}

$report_id = intval($_GET['id']);

// Fetch report
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
    <h2 class="mb-4">Report Details – <?= htmlspecialchars($report['tracking_id']) ?></h2>

    <div class="card p-4 mb-4 shadow-sm">
      <h5 class="mb-3">Report Information</h5>
      <p><strong>Type:</strong> <?= htmlspecialchars($report['type']) ?></p>
      <p><strong>Status:</strong> 
        <span class="badge <?= $report['status'] === 'Pending' ? 'bg-warning text-dark' : 'bg-success' ?>">
          <?= htmlspecialchars($report['status']) ?>
        </span>
      </p>
      <p><strong>Date:</strong> <?= date('d M Y, g:i a', strtotime($report['date'])) ?></p>
      <p><strong>Region:</strong> <?= htmlspecialchars($report['region_name'] ?? '-') ?></p>
      <p><strong>District:</strong> <?= htmlspecialchars($report['district_name'] ?? '-') ?></p>
      <p><strong>Chiefdom:</strong> <?= htmlspecialchars($report['chiefdom_name'] ?? '-') ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($report['location']) ?></p>
    </div>

    <div class="description-box">
      <h5>Description</h5>
      <p><?= nl2br(htmlspecialchars($report['description'])) ?></p>
    </div>

    <!-- Evidence Display -->
    <div class="evidence-box mt-4">
      <h5>Evidence</h5>
      <?php if (!empty($report['evidence_image']) && file_exists("../uploads/" . $report['evidence_image'])): ?>
        <p><strong>Image:</strong></p>
        <img src="../uploads/<?= $report['evidence_image'] ?>" alt="Evidence Image" class="img-fluid mb-3">
      <?php endif; ?>

      <?php if (!empty($report['evidence_audio']) && file_exists("../uploads/" . $report['evidence_audio'])): ?>
        <p><strong>Audio:</strong></p>
        <audio controls src="../uploads/<?= $report['evidence_audio'] ?>"></audio>
      <?php endif; ?>

      <?php if (!empty($report['evidence_video']) && file_exists("../uploads/" . $report['evidence_video'])): ?>
        <p class="mt-3"><strong>Video:</strong></p>
        <video controls width="100%" src="../uploads/<?= $report['evidence_video'] ?>"></video>
      <?php endif; ?>
    </div>

    <!-- Admin Actions -->
    <div class="mt-4 d-flex gap-3 flex-wrap">
      <?php if ($report['status'] === 'Pending'): ?>
        <a href="controller/mark_reviewed.php?id=<?= $report['id'] ?>" class="btn btn-success">
          Mark as Reviewed
        </a>
      <?php endif; ?>

      <a href="deleted_reports.php" class="btn btn-secondary">← Back to Reports</a>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
