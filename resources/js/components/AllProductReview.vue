<template>
  <div>
    <div v-if="isOpen">
      <div class="_bag_address_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button @click.prevent="hideReviews" class="_SO_d_bx">X</button>
              <h3 style="display: flex; align-items: center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
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
                {{ rating }} ({{ count }} Reviews)
              </h3>
            </div>

            <div class="_SO_d_b">
              <div v-for="(item, i) in items" :key="i" class="review_wrapper">
                <div class="review_wt">
                  <div class="review_pp">
                    <img
                      :src="$siteURL + '/images/profile/thumb/' + item.profile_image"
                      alt="Yeden Sherpa"
                      class="review_pp_img"
                    />
                  </div>
                  <div class="review_wt_dt">
                    <span class="review_wt_n">{{ item.writer_name }}</span>
                    <div class="review_wt_t">{{ item.created_at }}</div>
                    <div>
                      <span v-for="i in 5" :key="i">
                        <span v-if="i < item.rating"
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
                            style="
                              fill: var(--primary-color);
                              stroke: var(--primary-color);
                            "
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
                <read-more
                  more-str="read more"
                  :text="item.review"
                  :max-chars="190"
                ></read-more>
              </div>
              <div class="loadmore" v-show="canLoadMore">
                <button
                  :disabled="isLoading"
                  class="btn btn-third btn-normalize loading"
                  @click.prevent="loadItems"
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
          </div>
        </div>
      </div>
    </div>
    <button @click="showReviews" class="list_tech_btn">
      Show all {{ count }} reviews
    </button>
  </div>
</template>

<script>
import axios from "axios";
import ReadMore from "./ReadMore.vue";
export default {
  props: ["count", "rating", "product"],
  data() {
    return {
      isOpen: false,
      data: null,
      canLoadMore: true,
      page: 0,
      items: [],
      isLoading: false,
    };
  },
  components: {
    ReadMore,
  },
  methods: {
    disableScroll() {
      let body = document.querySelector("body");
      body.className = "noscroll";
    },
    enableScroll() {
      let body = document.querySelector("body");
      body.classList.remove("noscroll");
    },
    showReviews() {
      if (this.items.length == 0) {
        this.loadItems();
      }
      this.disableScroll();
      this.isOpen = true;
    },
    hideReviews() {
      this.isOpen = false;
      this.enableScroll();
    },
    loadItems() {
      if (this.data) {
        if (this.data.current_page < this.data.last_page) {
          this.canLoadMore = true;
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
          this.$siteURL + "/get/product/" + this.product + "/reviews/?page=" + this.page
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
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
