<template>
  <div class="_SO_tg">
    <div class="_SO_tg_img round_c_s">
      <a :href="$siteURL + '/list/' + product + '?sid=' + slug">
        <img
          class="_LST_img"
          :src="$siteURL + '/images/product/thumb/' + thumbnail"
          :alt="name"
        />
      </a>
    </div>
    <div class="_SO_tg_txt">
      <a :href="$siteURL + '/list/' + product + '?sid=' + slug">
        <h4 class="_SO_tg_ttl">{{ name }}</h4>
      </a>
      <span v-if="title" class="SO_tg_cap">{{ title }}</span>

      <h4 class="_SO_tg_ttl">{{ symbol }}{{ localPrice() }}</h4>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    "rates",
    "amount",
    "symbol",
    "name",
    "currency",
    "local",
    "slug",
    "product",
    "title",
    "thumbnail",
  ],
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
