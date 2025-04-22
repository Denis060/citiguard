<?php include '../includes/header.php'; ?>

<section class="hero">
  <div class="hero-text">
    <h1>Report Submitted Successfully</h1>
    <p class="tagline">Thank you for speaking up. Your voice matters.</p>
  </div>
</section>

<section class="features">
  <div class="container feature" style="text-align: center;">
    <?php
    if (isset($_GET['id'])) {
      $tracking_id = htmlspecialchars($_GET['id']);
      echo "<p style='font-size: 1.2rem;'>🆔 Your Report Tracking ID: <strong>$tracking_id</strong></p>";
      echo "<p>Please save this ID if you'd like to follow up on this report in the future.</p>";
    } else {
      echo "<p>We received your report, but no tracking ID was provided.</p>";
    }
    ?>
    <a href="../index.php" class="btn-primary" style="margin-top: 20px; display: inline-block;">Return to Homepage</a>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
