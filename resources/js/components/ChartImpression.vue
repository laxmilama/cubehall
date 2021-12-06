<template>
  <div>
    <canvas id="planet-chart" class="impression_chart"></canvas>
  </div>
</template>
<script>
export default {
  name: "ChartImpression",
  data() {
    return {};
  },
  async mounted() {
    let days = [];
    let values = [];
    await axios
      .get(this.$siteURL + "/studio/get/analytics/impression")
      .then((res) => {
        Object.keys(res.data).forEach((e) => {
          days.push(e);
        });

        Object.values(res.data).forEach((e) => {
          values.push(e);
        });
      })
      .catch((error) => {
        console.log(error);
      });
    var barChartData = {
      labels: days,
      datasets: [
        {
          label: "Impressions",
          data: values,
          tension: 0,
          bezierCurve: false,
          fill: false,
          borderColor: "rgb(75, 192, 192)",
        },
      ],
    };

    var options = {
      type: "line",
      data: barChartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
                padding: 25,
              },
            },
          ],
        },
      },
    };
    const ctx = document.getElementById("planet-chart");
    new Chart(ctx, options);
  },
};
</script>
<style>
.impression_chart {
  min-height: 300px;
  max-height: 500px;
}
</style>
