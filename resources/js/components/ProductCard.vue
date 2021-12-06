<template>
  <div class="parlor-card">
    <div class="explore-parlor-list" style="width: 100%">
      <div class="parlor-card-box round_c_s">
        <img
          class="parlor-card-box-img"
          :src="$siteURL + '/images/product/small/' + thumbnail"
          width="100%"
        />
      </div>

      <div class="explore-parlor-name">
        <div>
          <span class="typography-headline6 title">{{ name }}</span>
        </div>
        <span class="typography-headline6 title">{{ title }}</span>

        <div>
          <span class="typography-body2 meta counter_review">
            <template v-if="reviews_count > 0">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="#888888"
                stroke="currentColor"
                stroke-width="0"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-star"
              >
                <polygon
                  points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
                ></polygon>
              </svg>
              {{ ratings_count }} ({{ reviews_count }})
            </template>
          </span>
        </div>
        <div>
          <span class="typography-headline6 cost">{{ symbol }}{{ localPrice() }}</span>
        </div>
      </div>
      <a
        class="parlor-link"
        :href="`${$siteURL}/list/${slug}?c=${toBash(product, type, parent)}`"
        data-collector
      ></a>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    "rates",
    "ratings_count",
    "reviews_count",
    "amount",
    "symbol",
    "title",
    "currency",
    "local",
    "slug",
    "name",
    "title",
    "thumbnail",
    "product",
    "parent",
    "type",
  ],
  data() {
    return {
      exchanges: JSON.parse(this.rates),
    };
  },
  methods: {
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
    },
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
<style>
.counter_review svg {
  fill: var(--primary-color);
}
</style>
