

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Misconduct - Citiguard</title>
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
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require_once '../config/db.php'; // Make sure this is valid
// Load regions from DB
$regions = $conn->query("SELECT id, name FROM regions ORDER BY name ASC");
include '../includes/header.php';
?>

<section class="features">

  <?php if (isset($_GET['error'])): ?>
    <div class="max-w-2xl mx-auto my-4 p-4 bg-red-100 text-red-700 rounded shadow">
      <?= htmlspecialchars($_GET['error']) ?>
    </div>
  <?php endif; ?>
  <div class="max-w-2xl mx-auto my-8 p-8 bg-white rounded-xl shadow-lg">
    <form id="reportForm" action="../controller/submit_report.php" method="POST" enctype="multipart/form-data" class="space-y-6">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div>
        <label for="target" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#128100;</span>Who Are You Reporting?</label>
        <select name="target" id="target" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">-- Select Entity --</option>
          <option>Police Officer</option>
          <option>Military Officer</option>
          <option>Traffic Warden</option>
          <option>Local Authority</option>
          <option>Other Government Worker</option>
        </select>
      </div>

      <div>
        <label for="region" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#127760;</span>Region:</label>
        <select name="region" id="region" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="">-- Select Region --</option>
          <?php while ($r = $regions->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($r['id']) ?>"><?= htmlspecialchars($r['name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div>
        <label for="district" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#128205;">&#128205;</span>District:</label>
        <select name="district" id="district" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="">-- Select District --</option>
        </select>
      </div>
      <script>
        document.getElementById('district').addEventListener('change', function () {
          const districtName = this.value;
          fetch('../controller/get_chiefdoms.php?district=' + encodeURIComponent(districtName))
            .then(response => response.json())
            .then(data => {
              const chiefdomSelect = document.getElementById('chiefdom');
              chiefdomSelect.innerHTML = '<option value="">-- Select Chiefdom --</option>';
              data.forEach(chiefdom => {
                const option = document.createElement('option');
                option.value = chiefdom.name;
                option.textContent = chiefdom.name;
                chiefdomSelect.appendChild(option);
              });
            });
        });
      </script>

      <div>
        <label for="chiefdom" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#127963;</span>Chiefdom:</label>
        <select name="chiefdom" id="chiefdom" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="">-- Select Chiefdom --</option>
        </select>
      </div>

      <div>
        <label for="type" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#FFA500;">&#9888;&#65039;</span>Type of Misconduct:</label>
        <select id="type" name="type" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Select...</option>
          <option>Bribery</option>
          <option>Abuse</option>
          <option>Extortion</option>
          <option>Negligence</option>
          <option>Verbal Threats</option>
        </select>
      </div>

      <div>
        <label for="location" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#128205;</span>Where did it happen?</label>
        <input type="text" id="location" name="location" placeholder="Example: Freetown Roundabout" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label for="date" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#128197;</span>Date of Incident:</label>
        <input type="date" id="date" name="date" max="<?= date('Y-m-d') ?>" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label for="description" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#9998;&#65039;</span>Brief Description:</label>
        <textarea id="description" name="description" rows="4" placeholder="What exactly happened?" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#128206;</span>Upload Evidence:</label>
        <div class="flex flex-col gap-2">
          <label for="evidence_image" class="flex items-center gap-2"><span style="color:#00558D;">&#128247;</span>Photo:
            <input type="file" id="evidence_image" name="evidence_image" accept="image/*" class="block w-full text-sm text-gray-600 border border-gray-300 rounded cursor-pointer focus:outline-none">
          </label>
          <label for="evidence_audio" class="flex items-center gap-2"><span style="color:#00558D;">&#127911;</span>Audio:
            <input type="file" id="evidence_audio" name="evidence_audio" accept="audio/*" class="block w-full text-sm text-gray-600 border border-gray-300 rounded cursor-pointer focus:outline-none">
          </label>
          <label for="evidence_video" class="flex items-center gap-2"><span style="color:#00558D;">&#127909;</span>Video:
            <input type="file" id="evidence_video" name="evidence_video" accept="video/*" class="block w-full text-sm text-gray-600 border border-gray-300 rounded cursor-pointer focus:outline-none">
          </label>
        </div>
      </div>

      <div>
        <label for="contact" class="block font-semibold mb-1 text-gray-700"><span class="mr-2" style="color:#00558D;">&#128100;</span>Optional: Your Name or Contact (for follow-up only)</label>
        <input type="text" id="contact" name="contact" placeholder="Leave blank to stay anonymous" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="flex items-center gap-2">
        <input type="checkbox" id="confirm" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="confirm" class="text-gray-700">I confirm that this report is true to the best of my knowledge</label>
      </div>

      <button type="submit" class="w-full bg-blue-800 text-white font-semibold py-3 rounded-lg shadow hover:bg-blue-900 transition-all">Submit Report</button>
    </form>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
</body>
</html>

<!-- ✅ AJAX: Load districts based on selected region -->
<script>
document.getElementById('region').addEventListener('change', function () {
  const regionId = this.value;
  fetch('../controller/get_districts.php?region_id=' + regionId)
    .then(response => response.json())
    .then(data => {
      const districtSelect = document.getElementById('district');
      districtSelect.innerHTML = '<option value="">-- Select District --</option>';
      data.forEach(district => {
        const option = document.createElement('option');
        option.value = district.name;
        option.textContent = district.name;
        districtSelect.appendChild(option);
      });
    });
});
</script>
