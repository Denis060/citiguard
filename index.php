
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Citiguard - Citizen-Led Reporting</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .hero-bg {
      background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1580453899323-8b5449520258?q=80&w=2070&auto=format&fit=crop');
      background-size: cover;
      background-position: center;
    }
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">


<?php include __DIR__ . "/includes/header.php"; ?>

  <!-- Hero Section -->
  <section class="hero-bg min-h-[60vh] flex flex-col justify-center items-center text-center text-white relative">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 py-24 px-6">
      <h1 class="text-4xl md:text-6xl font-extrabold mb-6">Empowering Citizens. <span class="text-blue-400">Ensuring Accountability.</span></h1>
      <p class="text-lg md:text-2xl mb-8 max-w-2xl mx-auto">A safe, anonymous platform for reporting police misconduct and tracking your report’s progress.</p>
      <a href="view/report.php" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-4 rounded-lg shadow transition-all text-lg">Report Now</a>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
      <div class="grid md:grid-cols-3 gap-10">
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 text-center">
          <i data-lucide="shield-check" class="w-12 h-12 mx-auto text-blue-800 mb-4"></i>
          <h3 class="text-xl font-bold mb-2">Anonymous & Secure</h3>
          <p class="text-gray-600">Report without fear. Your identity is protected at every step.</p>
        </div>
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 text-center">
          <i data-lucide="search-check" class="w-12 h-12 mx-auto text-blue-800 mb-4"></i>
          <h3 class="text-xl font-bold mb-2">Track Your Report</h3>
          <p class="text-gray-600">Get real-time updates on your report’s status and outcomes.</p>
        </div>
        <div class="feature-card bg-white rounded-xl shadow-lg p-8 text-center">
          <i data-lucide="users" class="w-12 h-12 mx-auto text-blue-800 mb-4"></i>
          <h3 class="text-xl font-bold mb-2">Community Driven</h3>
          <p class="text-gray-600">Built for and by citizens to ensure transparency and accountability.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="py-20 bg-blue-800 text-white text-center">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to make a difference?</h2>
      <p class="mb-8 text-lg">Report police misconduct or learn more about your rights as a citizen.</p>
      <a href="view/report.php" class="inline-block bg-white text-blue-800 font-semibold px-8 py-4 rounded-lg shadow hover:bg-gray-100 transition-all text-lg">Report Now</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-6 py-12">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-lg font-semibold mb-4">Citiguard</h3>
          <p class="text-gray-400">A platform for citizens to safely report police misconduct and drive accountability.</p>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
            <li><a href="#features" class="text-gray-400 hover:text-white transition">How It Works</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Transparency Dashboard</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">FAQs</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-4">Legal</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition"><i data-lucide="twitter" class="w-6 h-6"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i data-lucide="facebook" class="w-6 h-6"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i data-lucide="instagram" class="w-6 h-6"></i></a>
          </div>
        </div>
      </div>
      <div class="mt-12 border-t border-gray-700 pt-8 text-center text-gray-500">
        <p>&copy; 2025 Citiguard. All Rights Reserved.</p>
      </div>
    </div>
    <script>if(window.lucide){lucide.createIcons();}</script>
  </footer>
</body>
</html>


