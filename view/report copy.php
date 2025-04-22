<?php include '../includes/header.php'; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'future_date'): ?>
  <div class="alert alert-danger text-center" role="alert">
    🚫 You cannot submit a report with a future date. Please correct the date and try again.
  </div>
<?php endif; ?>

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
        <select name="region" id="region" required>
          <option value="">-- Select Region --</option>
          <option>Western Area</option>
          <option>Northern Province</option>
          <option>Southern Province</option>
          <option>Eastern Province</option>
          <option>North West Province</option>
        </select>
      </div>

      <div class="form-group">
        <label for="district">District:</label>
        <select name="district" id="district" required>
          <option value="">-- Select District --</option>
          <option>Freetown</option>
          <option>Bo</option>
          <option>Kenema</option>
          <option>Makeni</option>
          <option>Port Loko</option>
          <option>Kono</option>
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
        <!-- ✅ Add max to prevent future dates -->
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
