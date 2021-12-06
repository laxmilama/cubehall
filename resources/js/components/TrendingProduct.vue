<template>
  <div class="_MBL-addPad">
    <div class="_TRND">
      <div v-for="(item, index) in items" :key="index" class="_TRND_item_card">
        <!-- IF Product -->
        <div v-if="item.type == 'App\\Models\\ProductList'" class="_TRND_item_wrap">
          <div style="position: relative">
            <div class="showoff-show _TRND_r_c">
              <div class="showof-show-content">
                <a
                  :href="`${$siteURL}/list/${item.product.slug}?c=${toBash(
                    item.item_id,
                    item.type,
                    item.product.owner.id
                  )}`"
                  data-collector
                >
                  <img
                    class="showoff-show-img"
                    :src="`${$siteURL}/images/product/small/${item.product.meta.thumbnail}`"
                    width="100%"
                  />
                </a>
              </div>
            </div>
          </div>
        </div>
        <!-- End Product -->
      </div>
    </div>
    <div class="loadmore" v-show="canLoadMore">
      <button
        :disabled="isLoading"
        class="btn btn-third btn-normalize loading"
        @click.prevent="loadMore"
      >
        <span v-show="isLoading">
          <span>Loading</span>
          <span class="loader" v-for="i in 3" :key="i">
            <span>.</span>
          </span>
        </span>
        <span v-show="!isLoading">Load More</span>
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
const trendingAxios = axios.create({
  baseURL: window.location.protocol + "//" + window.location.hostname,
  timeout: 1000,
  headers: { "X-Custom-Header": "foobar" },
});
export default {
  props: ["currency", "symbol", "rates"],
  data() {
    return {
      items: [],
      data: null,
      page: 0,
      exchangeRates: [],
      isLoading: false,
      canLoadMore: true,
      isFresh: false,
    };
  },
  methods: {
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
    },
    getResults() {
      this.page = 1;
      trendingAxios
        .get(this.$siteURL + "/get/explore/trending?page=" + this.page)
        .then((res) => {
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          Object.values(res.data.data).forEach((e) => {
            this.items.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadMore() {
      this.isFresh = false;
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
      trendingAxios
        .get(this.$siteURL + "/get/explore/trending?page=" + this.page)
        .then((res) => {
          let a = Object.values(res.data.data);
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          a.forEach((e) => {
            this.items.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    let that = this;
    let interceptor = trendingAxios.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    trendingAxios.interceptors.response.use(
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
    this.getResults();
  },
};
</script>
