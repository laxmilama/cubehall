<template>
  <div>
    <div class="_LST_col_wrap scrollable">
      <template v-if="sections.length > 0">
        <ul class="_LST_collection">
          <button
            class="_LST_collection_list"
            @click="setFilter('All')"
            :disabled="filter == 'All'"
          >
            <span>All</span>
          </button>
          <button
            @click="setFilter(section.id)"
            class="_LST_collection_list"
            v-for="section in sections"
            :key="section.id"
            :disabled="section.id == filter"
          >
            <span>{{ section.name }}</span>
          </button>
        </ul>
      </template>
    </div>
    <div style="position: relative">
      <div class="showoff-show-wrapper">
        <div
          class="showoff-show-card round_c_s"
          v-for="(product, index) in products"
          :key="index"
        >
          <div style="position: relative">
            <div class="showoff-show">
              <div class="showof-show-content">
                <a :href="`${$siteURL}/list/${product.slug}`">
                  <img
                    class="showoff-show-img"
                    :src="`${$siteURL}/images/product/small/${product.meta.thumbnail}`"
                    width="100%"
                  />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="loadmore" v-if="canLoadMore">
        <button
          :disabled="isLoading"
          class="btn btn-third btn-normalize loading"
          @click.prevent="loadMore"
        >
          <span v-if="isLoading">Loading...</span>
          <span v-else>Load More</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
const productAxios = axios.create({
  baseURL: window.location.protocol + "//" + window.location.hostname,
  timeout: 1000,
  headers: { "X-Custom-Header": "foobar" },
});
export default {
  data() {
    return {
      products: [],
      data: null,
      page: 0,
      sections: [],
      filter: "All",
      isLoading: false,
      canLoadMore: true,
      isFresh: false,
    };
  },
  props: {
    studio: Object,
  },
  mounted() {
    let that = this;
    let interceptor = productAxios.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    productAxios.interceptors.response.use(
      function (response) {
        that.isLoading = false;
        if (that.isFresh) {
          that.data = null;
          that.products = [];
        }
        return response;
      },
      function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        return Promise.reject(error);
      }
    );
  },
  created() {
    this.getResults();
    productAxios
      .get(
        this.$siteURL +
          "/studio/get/collection/" +
          this.studio.id +
          "?coll=" +
          this.filter
      )
      .then((res) => {
        res.data.forEach((e) => {
          this.sections.push(e);
        });
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    setFilter(filter) {
      this.canLoadMore = true;
      this.filter = filter;
      this.page = 0;
      this.isFresh = true;
      this.getResults();
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
      productAxios
        .get(
          this.$siteURL +
            "/api/feed/products/" +
            this.studio.slug +
            "?page=" +
            this.page +
            "&coll=" +
            this.filter
        )
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          res.data.data.forEach((e) => {
            this.products.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getResults() {
      this.page = 1;

      productAxios
        .get(
          this.$siteURL +
            "/api/feed/products/" +
            this.studio.slug +
            "?page=" +
            this.page +
            "&coll=" +
            this.filter
        )
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          res.data.data.forEach((e) => {
            this.products.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
