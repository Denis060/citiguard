<script>
  const ctx = document.getElementById('trendChart').getContext('2d');

  const trendChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // Replace with actual months
      datasets: [{
        label: 'Reports Submitted',
        data: [12, 19, 8, 15, 20, 10], // Replace with real values from DB later
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
</script>
