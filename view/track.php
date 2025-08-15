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
  <h2 class="text-center mb-4">Track Your Report</h2>

  <form method="GET" action="track.php" class="row g-3 mb-4 justify-content-center">
    <div class="col-md-6">
      <div class="input-group">
        <input type="text" name="id" class="form-control rounded-pill" placeholder="Enter your Tracking ID..." required value="<?= htmlspecialchars($tracking_id) ?>">
        <button class="btn btn-primary rounded-pill ms-2">Check Status</button>
      </div>
    </div>
  </form>

  <?php if ($report): ?>
    <?php if ($report['deleted'] == 1): ?>
      <div class="alert alert-danger text-center">Sorry, this report has been removed.</div>
    <?php else: ?>
      <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
          <h5 class="card-title text-center">Report Details</h5>
          <p><strong>Tracking ID:</strong> <?= htmlspecialchars($report['tracking_id']) ?></p>
          <p><strong>Type:</strong> <?= htmlspecialchars($report['type']) ?></p>
          <p><strong>Status:</strong> 
            <span class="badge <?= $report['status'] === 'Pending' ? 'bg-warning text-dark' : 'bg-success' ?>">
              <?= htmlspecialchars($report['status']) ?>
            </span>
          </p>
          <p><strong>Date Submitted:</strong> <?= date('d M Y, g:i a', strtotime($report['date'])) ?></p>
        </div>
      </div>
    <?php endif; ?>
  <?php elseif (!empty($tracking_id)): ?>
    <div class="alert alert-warning text-center">No report found with that tracking ID.</div>
  <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
