function loadChart(periode) {
  console.log("Fetching data for:", periode);

  fetch(`/api/alert-stats?periode=${periode}`)
    .then(response => response.json())
    .then(data => {
      const options = {
        chart: {
          type: 'area',
          height: 350,
          toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        series: [{
          name: 'Alerts',
          data: data.data
        }],
        xaxis: {
          categories: data.labels
        },
        tooltip: {
          x: {
            format: periode === 'today' || periode === 'yesterday' ? 'HH:mm' : 'yyyy-MM-dd'
          }
        }
      };

      const chartContainer = document.querySelector("#area-chart");
      chartContainer.innerHTML = "";
      const chart = new ApexCharts(chartContainer, options);
      chart.render();

      document.getElementById("total-alerts").innerText = new Intl.NumberFormat().format(data.total);
      document.getElementById("percent-change").innerText = `${data.percentageChange.toFixed(2)}%`;
    })
    .catch(err => {
      console.error("Error loading chart:", err);
      document.querySelector("#area-chart").innerHTML = "<p class='text-red-500'>Error loading chart</p>";
    });
}