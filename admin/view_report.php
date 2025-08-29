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
      <style>
        .evidence-thumb { max-width: 120px; max-height: 120px; object-fit: cover; cursor: pointer; border-radius: 6px; margin-bottom: 8px; }
        .evidence-modal-bg { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.7); align-items: center; justify-content: center; }
        .evidence-modal-content { background: #fff; padding: 1rem; border-radius: 8px; max-width: 90vw; max-height: 90vh; }
        .evidence-modal-content img, .evidence-modal-content video, .evidence-modal-content audio { max-width: 80vw; max-height: 70vh; display: block; margin: 0 auto; }
        .evidence-modal-close { position: absolute; top: 20px; right: 40px; color: #fff; font-size: 2rem; cursor: pointer; }
      </style>
      <div style="display: flex; gap: 2rem; flex-wrap: wrap; align-items: flex-start;">
        <?php $hasEvidence = false; ?>
        <?php if (!empty($report['evidence_image']) && file_exists("../uploads/" . $report['evidence_image'])): $hasEvidence = true; ?>
          <div>
            <p><strong>Image:</strong></p>
            <img src="../uploads/<?= htmlspecialchars($report['evidence_image']) ?>" alt="Evidence Image" class="evidence-thumb" onclick="showEvidenceModal('img', '../uploads/<?= htmlspecialchars($report['evidence_image']) ?>')">
          </div>
        <?php endif; ?>
        <?php if (!empty($report['evidence_audio']) && file_exists("../uploads/" . $report['evidence_audio'])): $hasEvidence = true; ?>
          <div>
            <p><strong>Audio:</strong></p>
            <button class="evidence-thumb" style="width:120px;height:120px;display:flex;align-items:center;justify-content:center;font-size:2rem;" onclick="showEvidenceModal('audio', '../uploads/<?= htmlspecialchars($report['evidence_audio']) ?>')">🔊</button>
          </div>
        <?php endif; ?>
        <?php if (!empty($report['evidence_video']) && file_exists("../uploads/" . $report['evidence_video'])): $hasEvidence = true; ?>
          <div>
            <p><strong>Video:</strong></p>
            <video class="evidence-thumb" src="../uploads/<?= htmlspecialchars($report['evidence_video']) ?>" onclick="showEvidenceModal('video', '../uploads/<?= htmlspecialchars($report['evidence_video']) ?>')" muted></video>
          </div>
        <?php endif; ?>
        <?php if (!$hasEvidence): ?>
          <p class="text-muted">No evidence uploaded for this report.</p>
        <?php endif; ?>
      </div>
      <div id="evidenceModalBg" class="evidence-modal-bg" onclick="hideEvidenceModal()">
        <span class="evidence-modal-close" onclick="hideEvidenceModal()">&times;</span>
        <div id="evidenceModalContent" class="evidence-modal-content"></div>
      </div>
      <script>
        function showEvidenceModal(type, src) {
          var modalBg = document.getElementById('evidenceModalBg');
          var modalContent = document.getElementById('evidenceModalContent');
          let html = '';
          if (type === 'img') {
            html = '<img src="' + src + '" style="max-width:100%;max-height:80vh;">';
          } else if (type === 'video') {
            html = '<video src="' + src + '" controls autoplay style="max-width:100%;max-height:80vh;"></video>';
          } else if (type === 'audio') {
            html = '<audio src="' + src + '" controls autoplay style="width:100%"></audio>';
          }
          modalContent.innerHTML = html;
          modalBg.style.display = 'flex';
        }
        function hideEvidenceModal() {
          document.getElementById('evidenceModalBg').style.display = 'none';
          document.getElementById('evidenceModalContent').innerHTML = '';
        }
        // Prevent modal close when clicking inside content
        document.getElementById('evidenceModalContent').onclick = function(e) { e.stopPropagation(); };
      </script>
    </div>

    <!-- Admin Actions -->
    <div class="mt-4 d-flex gap-3 flex-wrap">
      <?php if ($report['status'] === 'Pending'): ?>
        <a href="controller/mark_reviewed.php?id=<?= urlencode($report['id']) ?>" class="btn btn-success">
          Mark as Reviewed
        </a>
      <?php endif; ?>

      <a href="reports.php" class="btn btn-secondary">← Back to Reports</a>
    </div>
  </main>
</div>

<?php include 'includes/admin_footer.php'; ?>
