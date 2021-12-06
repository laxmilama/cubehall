<template>
  <div>
    <canvas id="monthly-sells" class="impression_chart"></canvas>
  </div>
</template>
<script>
export default {
  name: "ChartImpression",
  data() {
    return {};
  },
  props: {
    data: [],
    data1: [],
    symbol: "",
  },
  async mounted() {
    let days = [];
    let values = [];
    let values1 = [];

    console.log(JSON.parse(this.data));

    Object.keys(JSON.parse(this.data)).forEach((e) => {
      // console.log(e);
      days.push(e);
      // values.push(e.total);
    });

    Object.values(JSON.parse(this.data)).forEach((e) => {
      // console.log(e);
      // days.push(e.month_year);
      values.push(e);
    });
    Object.values(JSON.parse(this.data1)).forEach((e) => {
      // console.log(e);
      // days.push(e.month_year);
      values1.push(e);
    });

    // JSON.parse(this.data1).forEach((e) => {
    //   days.push(e.month_year);
    //   values1.push(e.total);
    // });
    var barChartData = {
      labels: days,
      datasets: [
        {
          label: "Product Sells (" + this.symbol + ")",
          data: values,
          tension: 0,
          bezierCurve: false,
          backgroundColor: "rgb(75, 192, 192)",
          borderColor: "rgb(75, 192, 192)",
        },
        {
          label: "Parlor Sells (" + this.symbol + ")",
          data: values1,
          tension: 0,
          bezierCurve: false,
          backgroundColor: "#f64a6d",
          borderColor: "rgb(75, 192, 192)",
        },
      ],
    };

    var options = {
      type: "bar",
      data: barChartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
                padding: 15,
              },
            },
          ],
        },
      },
    };
    const ctx = document.getElementById("monthly-sells");
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
