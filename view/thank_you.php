
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You - Citiguard</title>
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
<?php include '../includes/header.php'; ?>

<main class="min-h-[60vh] flex flex-col justify-center items-center py-16">
  <div class="bg-white rounded-xl shadow-lg p-10 max-w-xl w-full text-center">
    <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 mb-4 flex flex-col items-center gap-2">
      <span class="inline-block"><i data-lucide="check-circle" class="w-10 h-10 text-green-500 inline-block align-middle"></i></span>
      Report Submitted Successfully
    </h1>
    <p class="text-lg text-gray-700 mb-6">Thank you for speaking up. Your voice matters.</p>
    <?php
    if (isset($_GET['id'])) {
      $tracking_id = htmlspecialchars($_GET['id']);
      echo "<p class='text-lg mb-2'>🆔 Your Report Tracking ID: <span class='font-bold text-blue-700'>$tracking_id</span></p>";
      echo "<p class='mb-4 text-gray-600'>Please save this ID if you'd like to follow up on this report in the future.</p>";
    } else {
      echo "<p class='mb-4 text-gray-600'>We received your report, but no tracking ID was provided.</p>";
    }
    ?>
    <a href="../index.php" class="mt-6 inline-block bg-blue-800 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-900 transition-all">Return to Homepage</a>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
