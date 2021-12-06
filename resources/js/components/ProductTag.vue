<template>
  <a :href="$siteURL + '/list/' + product + '?sid=' + slug">
    <div class="tg-card flex-box">
      <div>
        <span style="margin-bottom: 15px; display: block">{{ name }}</span>
        <div>
          <strong style="font-weight: 800">{{ symbol }}{{ localPrice() }}</strong>
        </div>
      </div>
      <div>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </div>
    </div>
  </a>
</template>

<script>
export default {
  props: ["rates", "amount", "symbol", "name", "currency", "local", "slug", "product"],
  data() {
    return {
      exchanges: JSON.parse(this.rates),
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    localPrice() {
      if (this.currency == this.local) {
        return this.amount;
      } else {
        return (
          (this.amount * this.exchanges[this.local]) /
          this.exchanges[this.currency]
        ).toFixed(2);
      }
    },
  },
};
</script>
