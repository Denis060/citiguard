
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - Citiguard</title>
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
      <i data-lucide="info" class="w-12 h-12 text-blue-800 mb-2"></i>
      <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 mb-2">About CitiGuard</h1>
      <p class="text-lg text-gray-600 mb-4">Silent system. Bold truth. Built by citizens, for citizens.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <div class="flex items-center gap-3 mb-2">
        <i data-lucide="bullseye" class="w-7 h-7 text-blue-700"></i>
        <h3 class="text-xl font-bold text-blue-700">Our Mission</h3>
      </div>
      <p class="text-gray-700">CitiGuard exists to protect citizens from police abuse, expose injustice, and restore public trust in law enforcement. We are creating a new standard of accountability through safe, secure, and data-driven reporting tools that empower the people to speak up without fear.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <div class="flex items-center gap-3 mb-2">
        <i data-lucide="eye" class="w-7 h-7 text-blue-700"></i>
        <h3 class="text-xl font-bold text-blue-700">Our Vision</h3>
      </div>
      <p class="text-gray-700">To build a Sierra Leone where justice is accessible, corruption is challenged, and the voice of the people shapes the system meant to serve them.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
      <div class="flex items-center gap-3 mb-2">
        <i data-lucide="user" class="w-7 h-7 text-blue-700"></i>
        <h3 class="text-xl font-bold text-blue-700">Message from the Founder</h3>
      </div>
      <p class="text-gray-700">“I started CitiGuard because I’ve seen firsthand how fear, silence, and injustice affect ordinary people. This platform is not about fighting the police—it’s about fighting corruption and restoring dignity to every citizen. We’re building this together, one report at a time.”<br><br><span class="font-bold text-blue-800">– Ibrahim Denis Fofanah</span></p>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>