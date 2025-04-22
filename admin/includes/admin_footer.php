<?php
// includes/admin_footer.php
?>
  </main>

  <footer class="admin-footer">
    <p>&copy; <?= date("Y") ?> CitiGuard Admin. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const chartCanvas = document.getElementById('trendChart');
    if (chartCanvas) {
      const ctx = chartCanvas.getContext('2d');
      const trendChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // replace with dynamic values
          datasets: [{
            label: 'Reports Submitted',
            data: [12, 19, 8, 15, 20, 10], // replace with dynamic DB data
            borderColor: '#0f3b61',
            backgroundColor: 'rgba(15, 59, 97, 0.2)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#0f3b61'
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: 'top'
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  </script>

  <script src="/Citiguard/js/dashboard.js"></script>
</body>
</html>
