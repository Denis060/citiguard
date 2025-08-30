
<!-- Modern Tailwind Header -->
<!-- Modern Tailwind Header -->
<header class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 shadow-sm">
  <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
  <a href="/citiguard/index.php" class="flex items-center space-x-2">
      <div class="bg-blue-800 p-2 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
      </div>
      <span class="text-2xl font-bold text-gray-800" style="color:#00558D;">Citiguard</span>
    </a>
    <div class="hidden md:flex items-center space-x-6">
  <a href="/citiguard/index.php" class="text-gray-600 hover:text-blue-800 transition-colors">Home</a>
  <a href="/citiguard/view/report.php" class="text-gray-600 hover:text-blue-800 transition-colors">Report Misconduct</a>
  <a href="/citiguard/view/track.php" class="text-gray-600 hover:text-blue-800 transition-colors">Track Report</a>
  <a href="/citiguard/view/rights.php" class="text-gray-600 hover:text-blue-800 transition-colors">Know Your Rights</a>
  <a href="/citiguard/view/about.php" class="text-gray-600 hover:text-blue-800 transition-colors">About</a>
  <a href="/citiguard/view/privacy.php" class="text-gray-600 hover:text-blue-800 transition-colors">Privacy</a>
    </div>
    <div class="flex items-center space-x-4">
      <div class="hidden sm:block">
        <select class="rounded border-gray-300 px-2 py-1 text-gray-600">
          <option value="en">English</option>
          <option value="kr">Krio</option>
        </select>
      </div>
  <a href="/citiguard/view/report.php" class="bg-red-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-red-700 transition-all shadow">Report Now</a>
      <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
      </button>
    </div>
  </nav>
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="fixed inset-0 z-[100] bg-black/70 transition-all duration-300 hidden">
  <div class="absolute top-0 right-0 w-3/4 max-w-xs h-full bg-white shadow-lg p-6 flex flex-col space-y-6">
      <button id="close-mobile-menu" class="self-end mb-4 text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
  <a href="/citiguard/index.php" class="text-white bg-black/90 hover:bg-black active:bg-sky-500/90 text-lg font-semibold rounded px-3 py-2 transition block mb-2">Home</a>
  <a href="/citiguard/view/report.php" class="text-white bg-black/90 hover:bg-black active:bg-sky-500/90 text-lg font-semibold rounded px-3 py-2 transition block mb-2">Report Misconduct</a>
  <a href="/citiguard/view/track.php" class="text-white bg-black/90 hover:bg-black active:bg-sky-500/90 text-lg font-semibold rounded px-3 py-2 transition block mb-2">Track Report</a>
  <a href="/citiguard/view/rights.php" class="text-white bg-black/90 hover:bg-black active:bg-sky-500/90 text-lg font-semibold rounded px-3 py-2 transition block mb-2">Know Your Rights</a>
  <a href="/citiguard/view/about.php" class="text-white bg-black/90 hover:bg-black active:bg-sky-500/90 text-lg font-semibold rounded px-3 py-2 transition block mb-2">About</a>
  <a href="/citiguard/view/privacy.php" class="text-white bg-black/90 hover:bg-black active:bg-sky-500/90 text-lg font-semibold rounded px-3 py-2 transition block mb-2">Privacy</a>
      <select class="rounded border-gray-300 px-2 py-1 text-gray-600">
        <option value="en">English</option>
        <option value="kr">Krio</option>
      </select>
    </div>
  </div>
</header>
<script>
  // Mobile menu toggle
  document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('close-mobile-menu');
    menuBtn && menuBtn.addEventListener('click', function() {
      mobileMenu.classList.remove('hidden');
    });
    closeBtn && closeBtn.addEventListener('click', function() {
      mobileMenu.classList.add('hidden');
    });
    // Close on overlay click
    mobileMenu && mobileMenu.addEventListener('click', function(e) {
      if (e.target === mobileMenu) mobileMenu.classList.add('hidden');
    });
  });
</script>
