
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Know Your Rights - Citiguard</title>
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

<main class="min-h-[60vh] flex flex-col items-center py-12 px-4">
  <div class="max-w-2xl w-full mx-auto">
    <div class="flex flex-col items-center mb-8">
      <i data-lucide="scale" class="w-12 h-12 text-blue-800 mb-2"></i>
      <h2 class="text-3xl md:text-4xl font-extrabold text-blue-800 mb-2">Know Your Rights</h2>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h3 class="text-xl font-bold mb-2 text-blue-700">Your Right to Speak Up</h3>
      <p class="text-gray-700">Every citizen has the right to speak out against misconduct, abuse, or corruption without fear of retaliation. CitiGuard protects your identity and your voice.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h3 class="text-xl font-bold mb-2 text-blue-700">What You Can Report</h3>
      <ul class="list-disc list-inside text-gray-700 space-y-1">
        <li>Police brutality or abuse of power</li>
        <li>Corruption, bribery, or extortion</li>
        <li>Negligence by government officials</li>
        <li>Unethical behavior by public servants</li>
      </ul>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h3 class="text-xl font-bold mb-2 text-blue-700">Your Privacy is Protected</h3>
      <p class="text-gray-700">You can choose to report anonymously. No personal information is ever shared without your consent. All reports are stored securely and reviewed by authorized personnel only.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
      <h3 class="text-xl font-bold mb-2 text-blue-700">We Stand With You</h3>
      <p class="text-gray-700">CitiGuard was built by citizens, for citizens — to make our communities safer, more just, and more accountable. You have a right to be heard, and we are here to amplify your voice.</p>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
