
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Track Report - Citiguard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
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
include '../includes/header.php';
?>

<main class="min-h-[60vh] flex flex-col items-center justify-center py-12">
  <div class="w-full max-w-xl mx-auto">
    <h2 class="text-3xl font-extrabold text-center mb-8 text-blue-800 flex items-center justify-center gap-2">
      <i data-lucide="search-check" class="w-8 h-8 text-blue-600"></i>
      Track Your Report
    </h2>
    <form method="GET" action="track.php" class="flex flex-col md:flex-row gap-4 mb-8 justify-center items-center">
      <input type="text" name="id" class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your Tracking ID..." required value="<?= htmlspecialchars($tracking_id) ?>">
      <button class="bg-blue-800 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-900 transition-all">Check Status</button>
    </form>

    <?php if ($report): ?>
      <?php if ($report['deleted'] == 1): ?>
        <div class="bg-red-100 text-red-700 rounded p-4 text-center mb-4">Sorry, this report has been removed.</div>
      <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-8 mb-4">
          <h5 class="text-xl font-bold text-center mb-4 text-blue-700">Report Details</h5>
          <div class="space-y-2">
            <p><span class="font-semibold text-gray-700">Tracking ID:</span> <span class="text-blue-800 font-mono"><?= htmlspecialchars($report['tracking_id']) ?></span></p>
            <p><span class="font-semibold text-gray-700">Type:</span> <?= htmlspecialchars($report['type']) ?></p>
            <p><span class="font-semibold text-gray-700">Status:</span> 
              <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                <?php if ($report['status'] === 'Pending'): ?>bg-yellow-100 text-yellow-800<?php else: ?>bg-green-100 text-green-800<?php endif; ?>">
                <?= htmlspecialchars($report['status']) ?>
              </span>
            </p>
            <p><span class="font-semibold text-gray-700">Date Submitted:</span> <?= date('d M Y, g:i a', strtotime($report['date'])) ?></p>
          </div>
        </div>
      <?php endif; ?>
    <?php elseif (!empty($tracking_id)): ?>
      <div class="bg-yellow-100 text-yellow-800 rounded p-4 text-center mb-4">No report found with that tracking ID.</div>
    <?php endif; ?>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
