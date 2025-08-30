
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy & Safety - Citiguard</title>
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
      <i data-lucide="lock" class="w-12 h-12 text-blue-800 mb-2"></i>
      <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 mb-2">Privacy & Safety</h1>
      <p class="text-lg text-gray-600 mb-4">Your report is secure. Your identity is protected. Your voice matters.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h3 class="text-xl font-bold mb-4 text-blue-700 flex items-center gap-2"><i data-lucide="shield" class="w-6 h-6 text-blue-700"></i>How We Keep You Safe</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="flex flex-col items-center text-center p-4">
          <i data-lucide="user-check" class="w-8 h-8 text-blue-600 mb-2"></i>
          <span class="font-semibold text-gray-800">Anonymous Reporting</span>
          <p class="text-gray-600 text-sm mt-1">You can submit your report without sharing your name, number, or email.</p>
        </div>
        <div class="flex flex-col items-center text-center p-4">
          <i data-lucide="lock" class="w-8 h-8 text-blue-600 mb-2"></i>
          <span class="font-semibold text-gray-800">Encrypted Submission</span>
          <p class="text-gray-600 text-sm mt-1">All reports are sent through a secure Google Form protected by Google’s servers.</p>
        </div>
        <div class="flex flex-col items-center text-center p-4">
          <i data-lucide="eye-off" class="w-8 h-8 text-blue-600 mb-2"></i>
          <span class="font-semibold text-gray-800">Private Review Only</span>
          <p class="text-gray-600 text-sm mt-1">Your report is only seen by authorized CitiGuard admins. We don’t share your identity.</p>
        </div>
        <div class="flex flex-col items-center text-center p-4">
          <i data-lucide="shield-off" class="w-8 h-8 text-blue-600 mb-2"></i>
          <span class="font-semibold text-gray-800">No Retaliation</span>
          <p class="text-gray-600 text-sm mt-1">We do not publish personal details. Our platform is built to protect whistleblowers.</p>
        </div>
        <div class="flex flex-col items-center text-center p-4 sm:col-span-2">
          <i data-lucide="gavel" class="w-8 h-8 text-blue-600 mb-2"></i>
          <span class="font-semibold text-gray-800">Use Responsibly</span>
          <p class="text-gray-600 text-sm mt-1">This platform is for real misconduct. False reports can damage lives and will not be tolerated.</p>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>