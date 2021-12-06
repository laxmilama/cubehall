<template>
  <div class="chart_holder">
    <canvas id="orders" class="product_imp"></canvas>
    <div class="chart_counter">
      <span>Impressions</span>
      <h3>{{ latestImpression }}</h3>
    </div>
  </div>
</template>
<script>
export default {
  name: "OrdersByDate",
  props: {
    slug: String,
  },
  data() {
    return {
      latestImpression: 0,
    };
  },
  async mounted() {
    let days = [];
    let values = [];
    await axios
      .get(this.$siteURL + "/studio/product/analytics/" + this.slug + "/impression")
      .then((res) => {
        Object.keys(res.data).forEach((e) => {
          days.push(e);
        });

        Object.values(res.data).forEach((e) => {
          values.push(e);
          this.latestImpression = this.latestImpression + e;
        });
      })
      .catch((error) => {
        console.log(error);
      });
    var barChartData = {
      labels: days,
      datasets: [
        {
          label: "Orders",
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
    const ctx = document.getElementById("orders");
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
