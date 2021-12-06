<template>
  <div class="">
    <div class="showoff-show-wrapper">
      <div class="review">
        <div class="review_container">
          <div v-for="(review, index) in reviews" :key="index">
            <div class="review_wt">
              <div class="review_pp">
                <img
                  class="review_pp_img"
                  :src="`${$siteURL}/images/profile/small/${review.writer.profile_image}`"
                  :alt="review.writer.name"
                />
              </div>
              <div class="review_wt_dt">
                <span class="review_wt_n">{{ review.writer.name }}</span>
                <div class="review_wt_t">
                  {{ review.created_at }}
                </div>
                <div>
                  <span v-for="i in 5" :key="i">
                    <span v-if="i < review.rating"
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        style="fill: var(--primary-color); stroke: var(--primary-color)"
                      >
                        <polygon
                          points="12 2 15.09 8.26 22 9.27 17 14.14
                                                                            18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27
                                                                            8.91 8.26 12
                                                                            2"
                        ></polygon></svg
                    ></span>
                    <span v-else
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        style="stroke: var(--primary-color)"
                      >
                        <polygon
                          points="12 2 15.09 8.26 22 9.27 17 14.14
                                                                            18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27
                                                                            8.91 8.26 12
                                                                            2"
                        ></polygon></svg
                    ></span>
                  </span>
                </div>
              </div>
            </div>
            <div>
              <read-more
                more-str="read more"
                :text="review.review"
                less-str="read less"
                :max-chars="190"
              ></read-more>
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
import ReadMore from "./ReadMore.vue";
export default {
  data() {
    return {
      reviews: [],
      data: null,
      page: 0,
      isLoading: false,
      canLoadMore: true,
    };
  },
  props: {
    studio: Object,
  },
  components: {
    ReadMore,
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
        .get(
          this.$siteURL + "/api/feed/reviews/" + this.studio.slug + "?page=" + this.page
        )
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          res.data.data.forEach((e) => {
            this.reviews.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
