<template>
  <div>
    <canvas id="planet-chart"></canvas>
  </div>
</template>
<script>
export default {
  name: "PlanetChart",
  data() {
    return {};
  },
  async mounted() {
    let days = [];
    let values = [];
    await axios
      .get(this.$siteURL + "/studio/get/dashboard/data")
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
          label: "Overal Views",
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
    // ctx.height = 50;
    new Chart(ctx, options);
  },
};
</script>
