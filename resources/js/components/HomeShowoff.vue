<template>
  <div class="container mb">
    <div class="">
      <h4 class="typography-headline4 thead">Get inspired</h4>
    </div>
    <div style="position: relative">
      <div class="showoff-show-wrapper">
        <div
          class="showoff-show-card round_c_s"
          v-for="(showoff, index) in showoffs"
          :key="index"
        >
          <div style="position: relative">
            <div class="showoff-show">
              <div class="showof-show-content">
                <a
                  :href="`${$siteURL}/showoff/${showoff.slug}?c=${toBash(
                    showoff.id,
                    showoff.type,
                    showoff.owner.id
                  )}`"
                  data-collector
                >
                  <img
                    class="showoff-show-img"
                    :src="`${$siteURL}/images/showoff/medium/${showoff.media}`"
                    width="100%"
                  />
                </a>
              </div>
            </div>
            <div class="showoff-shop-tag p-helper round_c_b">
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
                class="feather feather-tag"
              >
                <path
                  d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"
                ></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
              </svg>
              <span>View All Products</span>
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
          <span v-if="isLoading">Loading...</span>
          <span v-else>Load More</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showoffs: [],
      data: null,
      page: 0,
      isLoading: false,
      canLoadMore: true,
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
  },
  created() {
    this.getResults();
  },
  methods: {
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
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
      axios
        .get(this.$siteURL + "/get/showoffs?page=" + this.page)
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          res.data.data.forEach((e) => {
            this.showoffs.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
