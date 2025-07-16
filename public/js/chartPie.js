const renderPieChart = (labels, data) => {
  const options = {
    series: data,
    labels: labels,
    colors: ["#1C64F2", "#16BDCA", "#9061F9"],
    chart: {
      height: 420,
      width: "100%",
      type: "pie",
    },
    stroke: {
      colors: ["white"],
    },
    plotOptions: {
      pie: {
        size: "100%",
        dataLabels: {
          offset: -25,
        },
      },
    },
    dataLabels: {
      enabled: true,
      style: {
        fontFamily: "Inter, sans-serif",
      },
    },
    legend: {
      position: "bottom",
      fontFamily: "Inter, sans-serif",
    },
  };

  if (document.getElementById("pie-chart") && typeof ApexCharts !== "undefined") {
    const chart = new ApexCharts(document.getElementById("pie-chart"), options);
    chart.render();
  }
};

document.addEventListener("DOMContentLoaded", () => {
  fetch("/chart-prediksi")
    .then((response) => response.json())
    .then((result) => {
      renderPieChart(result.labels, result.series);
    })
    .catch((error) => {
      console.error("Gagal memuat chart:", error);
    });
});