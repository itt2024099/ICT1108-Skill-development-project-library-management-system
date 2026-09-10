// charts setup for library system
document.addEventListener('DOMContentLoaded', function () {
  
  // student reading chart
  const studentChartCanvas = document.getElementById('studentReadingChart');
  if (studentChartCanvas && typeof Chart !== 'undefined') {
    new Chart(studentChartCanvas, {
      type: 'bar',
      data: {
        labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        datasets: [{
          label: 'Books Borrowed',
          data: [2, 4, 3, 5, 2, 4],
          backgroundColor: '#0284c7',
          borderRadius: 6
        }, {
          label: 'Books Returned on Time',
          data: [2, 3, 3, 4, 2, 3],
          backgroundColor: '#16a34a',
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom' },
          title: {
            display: true,
            text: 'Your Semester Reading Activity (2026)',
            font: { size: 14, weight: 'bold' }
          }
        },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
      }
    });
  }

  // admin monthly issues and returns
  const adminTrendsCanvas = document.getElementById('adminCirculationChart');
  if (adminTrendsCanvas && typeof Chart !== 'undefined') {
    new Chart(adminTrendsCanvas, {
      type: 'line',
      data: {
        labels: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        datasets: [{
          label: 'Total Books Issued',
          data: [120, 185, 210, 195, 260, 310],
          borderColor: '#0284c7',
          backgroundColor: 'rgba(2, 132, 199, 0.1)',
          tension: 0.3,
          fill: true
        }, {
          label: 'Total Returns',
          data: [110, 170, 200, 180, 240, 295],
          borderColor: '#16a34a',
          backgroundColor: 'rgba(22, 163, 74, 0.05)',
          tension: 0.3,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom' },
          title: {
            display: true,
            text: 'Monthly Circulation Flow (6 Months Overview)',
            font: { size: 14, weight: 'bold' }
          }
        }
      }
    });
  }

  // top category chart
  const adminCategoriesCanvas = document.getElementById('adminCategoryChart');
  if (adminCategoriesCanvas && typeof Chart !== 'undefined') {
    new Chart(adminCategoriesCanvas, {
      type: 'doughnut',
      data: {
        labels: ['Software Engineering', 'Networking', 'Cybersecurity', 'Mathematics', 'General Fiction'],
        datasets: [{
          data: [42, 28, 20, 15, 12],
          backgroundColor: ['#0284c7', '#38bdf8', '#10b981', '#f59e0b', '#ec4899']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'right' },
          title: {
            display: true,
            text: 'Top Borrowed Categories',
            font: { size: 14, weight: 'bold' }
          }
        }
      }
    });
  }

});
