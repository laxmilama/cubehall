<template>
  <div>
    <div class="mt-m mb-s">
      <h2>Reviews</h2>
    </div>
    <template v-if="items.length > 0">
      <div>
        <div class="mt-m mb-m" v-for="(review, key) in items" :key="key">
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
            {{ review.review }}
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
    </template>
    <template v-else> <div>No reviews Yet</div> </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      canLoadMore: true,
      isLoading: false,
      items: [],
    };
  },
  props: {
    slug: String,
  },
  mounted() {
    axios
      .get(this.$siteURL + "/studio/product/get/" + this.slug + "/reviews")
      .then((res) => {
        this.data = res.data;
        if (this.data.current_page == this.data.last_page) {
          this.canLoadMore = false;
        }
        res.data.data.forEach((e) => {
          this.items.push(e);
        });
      })
      .catch((error) => {
        console.log(error);
      });
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
          this.$siteURL +
            "/studio/product/get/" +
            this.slug +
            "/reviews?page=" +
            this.page
        )
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
};
</script>
