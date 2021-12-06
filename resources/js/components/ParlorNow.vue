<style>
._PLR-now {
  margin: 8px;
}
._PLR-now:first-child {
  margin-left: 0px;
}
._PLR-now-img-wrap {
  width: 125px;
  min-height: 165px;
  flex-shrink: 0;
  margin-right: 15px;
}
._PLR-now-img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}
.PLR-now-time {
  padding: 5px;
  width: fit-content;
  border: solid 1.2px var(--gray-very-dark);
  margin-right: 10px;
  margin-bottom: 10px;
}
.PLR-now-time-wrap {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  margin: 16px 0px 0px;
}
</style>

<template>
  <div class="_PLR-now round_c_s">
    <div class="_PLR-container">
      <div class="_PLR-now-img-wrap">
        <img
          :src="$siteURL + '/images/parlor/small/' + p.cover"
          class="_PLR-now-img round_c_s"
          alt=""
          srcset=""
        />
      </div>
      <div>
        <div class="counter_review">
          <div>
            <span>
              {{ p.title }}
            </span>
          </div>

          <template v-if="p.reviews_count > 0">
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
            {{ p.star_count }} ({{ p.reviews_count }}) <span> · </span>
          </template>
          {{ p.location }}
        </div>
        <div v-if="p.tickets.length > 0">
          <div>
            <strong
              >{{ symbol
              }}{{ localPrice(p.tickets[0].price, p.tickets[0].currency) }}</strong
            ><span></span>
          </div>
        </div>
        <div class="PLR-now-time-wrap">
          <div class="PLR-now-time round_c_s" v-for="(ticket, i) in p.tickets" :key="i">
            <span>{{ localTime(ticket.time) }}</span>
          </div>
        </div>
      </div>
      <a class="parlor-link" :href="$siteURL + '/parlor/' + p.slug"></a>
    </div>
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      p: JSON.parse(this.parlor),
      exchangeRates: JSON.parse(this.rates),
    };
  },
  props: ["parlor", "symbol", "currency", "rates"],
  methods: {
    localPrice(amount, from) {
      if (from == this.currency) {
        return amount;
      } else {
        return (
          (amount * this.exchangeRates[this.currency]) /
          this.exchangeRates[from]
        ).toFixed(2);
      }
    },
    localTime(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("h:mm a");
    },
  },
};
</script>
