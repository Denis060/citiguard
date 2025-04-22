<?php include '../includes/header.php'; ?>
<?php
require_once '../config/db.php'; // Make sure this is valid

// Load regions from DB
$regions = $conn->query("SELECT id, name FROM regions ORDER BY name ASC");
?>

<section class="features">
  <div class="container feature">
    <form id="reportForm" action="../controller/submit_report.php" method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label for="target">Who Are You Reporting?</label>
        <select name="target" id="target" required>
          <option value="">-- Select Entity --</option>
          <option>Police Officer</option>
          <option>Military Officer</option>
          <option>Traffic Warden</option>
          <option>Local Authority</option>
          <option>Other Government Worker</option>
        </select>
      </div>

      <div class="form-group">
        <label for="region">Region:</label>
        <select name="region" id="region" class="form-control" required>
          <option value="">-- Select Region --</option>
          <?php while ($r = $regions->fetch_assoc()): ?>
            <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="district">District:</label>
        <select name="district" id="district" class="form-control" required>
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

      <div class="form-group">
  <label for="chiefdom">Chiefdom:</label>
  <select name="chiefdom" id="chiefdom" class="form-control" required>
    <option value="">-- Select Chiefdom --</option>
  </select>
</div>
        
      <div class="form-group">
        <label for="type">Type of Misconduct:</label>
        <select id="type" name="type" required>
          <option value="">Select...</option>
          <option>Bribery</option>
          <option>Abuse</option>
          <option>Extortion</option>
          <option>Negligence</option>
          <option>Verbal Threats</option>
        </select>
      </div>

      <div class="form-group">
        <label for="location">Where did it happen?</label>
        <input type="text" id="location" name="location" placeholder="Example: Freetown Roundabout" required>
      </div>

      <div class="form-group">
        <label for="date">Date of Incident:</label>
        <input type="date" id="date" name="date" max="<?= date('Y-m-d') ?>" required>
      </div>

      <div class="form-group">
        <label for="description">Brief Description:</label>
        <textarea id="description" name="description" rows="4" placeholder="What exactly happened?" required></textarea>
      </div>

      <div class="form-group">
        <label for="evidence">Upload Evidence (Photo/Audio/Video):</label>
        <input type="file" id="evidence" name="evidence" accept="image/*,video/*,audio/*">
      </div>

      <div class="form-group">
        <label for="contact">Optional: Your Name or Contact (for follow-up only)</label>
        <input type="text" id="contact" name="contact" placeholder="Leave blank to stay anonymous">
      </div>

      <div class="form-group checkbox">
        <input type="checkbox" id="confirm" required>
        <label for="confirm">I confirm that this report is true to the best of my knowledge</label>
      </div>

      <button type="submit" class="btn-primary">Submit Report</button>
    </form>
  </div>
</section>

<?php include '../includes/footer.php'; ?>

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
