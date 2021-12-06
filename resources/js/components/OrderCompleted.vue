<template>
  <div>
    <div v-if="orders.length > 0">
      <div class="order_card" v-for="(order, i) in orders" :key="i">
        <div class="flex-box order_head">
          <div>
            <a href="">#{{ order.identifier }}</a>
            <div>
              <span>Placed on {{ localTime(order.created_at) }}</span>
            </div>
          </div>
          <div>
            <strong>Total</strong>
            <div>{{ symbol }}{{ localPrice(order.total_amount, order.currency) }}</div>
          </div>
        </div>
        <div>
          <div class="_order_cc" v-for="(o, j) in order.orders" :key="j">
            <div class="flex-box">
              <div class="_bag_thumb round_c_s">
                <img
                  class="_bag_img"
                  :src="`${$siteURL}/images/product/thumb/` + o.thumbnail"
                />
              </div>
              <div>
                <div>
                  <strong v-text="o.product_name"></strong>
                </div>
                <div>
                  Qty: <span>{{ o.quantity }}</span>
                </div>
                <div>
                  <span v-text="o.status"></span>
                </div>
                <template v-if="o.product">
                  <div v-if="o.review == null">
                    <product-rating
                      :grade="0"
                      :maxStars="5"
                      :hasCounter="1"
                      :product="o.product.product.id"
                      :order="o.order_id"
                      :op="o.id"
                    />
                  </div>

                  <div v-else>
                    <h3>Reviewed</h3>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <h2>You don’t have any past orders. But when you do, you’ll find them here.</h2>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import ProductRating from "./ProductRating.vue";
export default {
  data() {
    return {
      orders: [],
      exchangeRates: null,
    };
  },
  props: {
    currency: String,
    symbol: String,
  },
  components: {
    ProductRating,
  },
  methods: {
    localTime(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("lll");
    },
    localPrice(amount, from) {
      console.log(from);
      if (from == this.currency) {
        return amount;
      } else {
        return (
          (amount * this.exchangeRates[this.currency]) /
          this.exchangeRates[from]
        ).toFixed(2);
      }
    },
  },
  mounted() {
    //   completed orders
    axios
      .get(this.$siteURL + "/orders/completed")
      .then((res) => {
        this.orders = res.data;
      })
      .catch((err) => {
        console.log(err);
      });

    //   exchange rates
    axios
      .get(this.$siteURL + "/api/v1/exchangerates")
      .then((res) => {
        this.exchangeRates = res.data;
      })
      .catch((error) => {
        colsole.log(error);
      });
  },
};
</script>
<style>
._order_cc {
  margin: 10px 0;
}
</style>
