<template>
  <div class="chart_holder">
    <canvas :id="randomID" class="product_imp"></canvas>
    <div class="chart_counter">
      <span>{{ type }}</span>
      <h3>{{ totalVisits }}</h3>
    </div>
  </div>
</template>
<script>
import Chart from "chart.js";
export default {
  name: "OrdersByDate",
  props: {
    slug: String,
    type: String,
    data: Object,
  },
  data() {
    return {
      randomID: Math.random().toString(36).substring(2, 7),
      totalVisits: 0,
    };
  },
  async mounted() {
    let days = [];
    let values = [];
    if (this.data) {
      Object.keys(this.data).forEach((e) => {
        days.push(e);
      });

      Object.values(this.data).forEach((e) => {
        values.push(e);
        this.totalVisits = this.totalVisits + e;
      });
    } else {
      console.log("Something went wrong");
    }
    var barChartData = {
      labels: days,
      datasets: [
        {
          label: "Visits",
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
        tooltips: {
          enabled: false,
        },
        legend: {
          display: false,
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              gridLines: {
                display: false,
              },
              ticks: {
                display: false,
              },
            },
          ],
          xAxes: [
            {
              gridLines: {
                display: false,
              },
              ticks: {
                display: false,
              },
            },
          ],
        },
      },
    };
    const ctx = document.getElementById(this.randomID);
    new Chart(ctx, options);
  },
};
</script>
<style>
.product_imp {
  min-height: 100px;
  max-height: 200px;
}
.chart_holder {
  position: relative;
  border: solid 1px var(--gray-meidum);
}
.chart_counter {
  position: absolute;
  top: 10%;
}
</style>
