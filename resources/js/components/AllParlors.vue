<template>
  <div class="mb">
    <div class="_PF1_body_wrap">
      <div v-for="(item, index) in items" :key="index">
        <div style="position: relative">
          <div class="showoff-show">
            <div class="showof-show-content">
              <a
                :href="`${$siteURL}/parlor/${item.slug}?c=${toBash(
                  item.id,
                  item.type,
                  item.owner.id
                )}`"
                data-collector
              >
                <img
                  class="showoff-show-img"
                  :src="`${$siteURL}/images/parlor/small/${item.cover}`"
                  width="100%"
                />
              </a>
            </div>
          </div>
          <div>
            <div class="FL_content">
              <span>{{ item.title }}</span>
              <div v-if="item.reviews_count > 0" class="_PF1_star">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 24 24"
                  fill="var(--primary-color)"
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
                <span> {{ item.star_count }}({{ item.reviews_count }}) </span>
                <span> · </span>
                <span> {{ item.location }} </span>
              </div>
              <div v-else class="_PF1_star">
                <span> {{ item.location }} </span>
              </div>
              <div class="FL_cc">
                <div v-if="exchangeRates.length > 0">
                  <div class="_FL_price">
                    {{
                      symbol + convertedPrice(item.ticket.price, item.ticket.currency)
                    }}/
                    <span>person</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="loadmore" v-if="canLoadMore">
      <button
        :disabled="isLoading"
        class="btn btn-third btn-normalize loading"
        @click.prevent="getResults"
      >
        <span v-if="isLoading">Loading</span>
        <span v-else>Load More</span>
      </button>
    </div>
  </div>
</template>
<style>
.loading:disabled {
  background: var(--gray-medium) !important;
  background: var(--bg-color);
}
</style>

<script>
import axios from "axios";
const axPLRALL = axios.create({
  baseURL: window.location.protocol + "//" + window.location.hostname,
  timeout: 1000,
  headers: { "X-Custom-Header": "foobar" },
});
export default {
  props: {
    currency: String,
    symbol: String,
  },
  data() {
    return {
      items: [],
      data: null,
      page: 0,
      isLoading: false,
      canLoadMore: true,
      exchangeRates: [],
    };
  },
  mounted() {
    let that = this;
    let interceptor = axios.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    axios.interceptors.response.use(
      function (response) {
        that.isLoading = false;
        return response;
      },
      function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        return Promise.reject(error);
      }
    );
    // axios.interceptors.request.eject(interceptor);
  },
  created() {
    this.getResults();
  },
  mounted() {
    let that = this;
    let interceptor = axPLRALL.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    axPLRALL.interceptors.response.use(
      function (response) {
        that.isLoading = false;
        if (that.isFresh) {
          that.data = null;
          that.items = [];
        }
        return response;
      },
      function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        return Promise.reject(error);
      }
    );
    axPLRALL
      .get(this.$siteURL + "/api/v1/exchangerates")
      .then((res) => {
        this.exchangeRates = res.data;
      })
      .catch((error) => {
        colsole.log(error);
      });
  },

  methods: {
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
    },
    convertedPrice(amount, from) {
      if (from == this.currency) {
        return amount;
      } else {
        return (
          (amount * this.exchangeRates[this.currency]) /
          this.exchangeRates[from]
        ).toFixed(2);
      }
    },
    getResults() {
      if (this.data) {
        if (this.data.current_page < this.data.last_page) {
          this.page = this.data.current_page + 1;
        } else {
          this.canLoadMore = false;
          return true;
        }
      } else {
        this.page = 1;
      }
      axPLRALL
        .get(this.$siteURL + "/get/parlor/all?page=" + this.page)
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;
          res.data.data.forEach((e) => {
            this.items.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
