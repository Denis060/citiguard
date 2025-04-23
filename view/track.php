<?php
require_once '../config/db.php';

$tracking_id = $_GET['id'] ?? '';
$report = null;

if (!empty($tracking_id)) {
    $stmt = $conn->prepare("SELECT tracking_id, type, status, date, deleted FROM reports WHERE tracking_id = ? LIMIT 1");
    $stmt->bind_param("s", $tracking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();
}
?>

<?php include '../includes/header.php'; ?>

<main class="container py-5">
  <h2 class="mb-4">Track Your Report</h2>

  <form method="GET" action="track.php" class="row g-3 mb-4">
    <div class="col-md-8">
      <input type="text" name="id" class="form-control" placeholder="Enter your Tracking ID..." required value="<?= htmlspecialchars($tracking_id) ?>">
    </div>
    <div class="col-md-4">
      <button class="btn btn-primary w-100">Check Status</button>
    </div>
  </form>

  <?php if ($report): ?>
    <?php if ($report['deleted'] == 1): ?>
      <div class="alert alert-danger">Sorry, this report has been removed.</div>
    <?php else: ?>
      <div class="card p-4 shadow-sm">
        <p><strong>Tracking ID:</strong> <?= htmlspecialchars($report['tracking_id']) ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($report['type']) ?></p>
        <p><strong>Status:</strong> 
          <span class="badge <?= $report['status'] === 'Pending' ? 'bg-warning text-dark' : 'bg-success' ?>">
            <?= htmlspecialchars($report['status']) ?>
          </span>
        </p>
        <p><strong>Date Submitted:</strong> <?= date('d M Y, g:i a', strtotime($report['date'])) ?></p>
      </div>
    <?php endif; ?>
  <?php elseif (!empty($tracking_id)): ?>
    <div class="alert alert-warning">No report found with that tracking ID.</div>
  <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
