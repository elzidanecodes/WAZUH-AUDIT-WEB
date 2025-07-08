function loadChart(periode = 'week', chartId = 'area-chart') {
  fetch(`/api/alert-stats?periode=${periode}`)
    .then(res => res.json())
    .then(response => {
      // Pastikan data memiliki minimal 2 titik
      if (response.data.length < 2) {
        console.warn('Not enough data points', response);
        document.getElementById(chartId).innerHTML = 
          '<div class="text-center p-4 text-gray-500">Not enough data to display chart</div>';
        return;
      }

      const chartOptions = {
        chart: { type: "area", height: 350, toolbar: { show: false } },
        series: [{ name: 'Alerts', data: response.data }],
        colors: ["#1A56DB"],
        xaxis: { 
          categories: response.labels,
          labels: { rotate: -45 }
        },
        yaxis: { min: 0 },
        stroke: { width: 2, curve: "smooth" },
        fill: { type: "gradient", gradient: { opacityFrom: 0.6, opacityTo: 0 } },
        dataLabels: { enabled: false },
        tooltip: { enabled: true }
      };

      const chartEl = document.getElementById(chartId);
      if (chartEl) {
        chartEl.innerHTML = "";
        const chart = new ApexCharts(chartEl, chartOptions);
        chart.render();
      }
    })
    .catch(error => {
      console.error('Error loading chart:', error);
      document.getElementById(chartId).innerHTML = 
        '<div class="text-center p-4 text-red-500">Error loading chart data</div>';
    });
}