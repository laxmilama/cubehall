<template>
  <div>
    <div class="flex-box _plr_btn_wrap">
      <div class="scrl_btn_wrap_left">
        <button class="scrl_btn" @click="scrollLeft">
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
            class="feather feather-chevron-left"
          >
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>
      </div>
      <div class="flex-box plr_flt_ovf">
        <div class="flex-box" v-for="(s, i) in sections" :key="i">
          <div class="flex-box" v-for="(c, j) in s.categories" :key="j">
            <template v-if="c.subcategories.length > 0">
              <div class="flex-box">
                <button
                  :disabled="sub.id == filter"
                  class="btn-filter _plr_btn_filter _PF1_btn"
                  v-for="(sub, k) in c.subcategories"
                  :key="k"
                  @click="setFilter(sub)"
                >
                  <span>{{ sub.name }}</span>
                </button>
              </div>
            </template>
            <template v-else>
              <button
                :disabled="c.id == filter"
                class="btn-filter _plr_btn_filter _PF1_btn"
                @click="setFilter(c)"
              >
                <span>{{ c.name }}</span>
              </button>
            </template>
          </div>
        </div>
      </div>
      <div class="scrl_btn_wrap_right">
        <button class="scrl_btn scrl_btn_right" @click="scrollRight">
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
            class="feather feather-chevron-right"
          >
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </button>
      </div>
    </div>
    <div class="_MBL-addPad">
      <div>
        <template v-if="current">
          <div class="mb-m _PF1_mt">
            <h2 class="_PF1_head">{{ current.name }}</h2>
            <span v-if="data"> {{ data.total }} results based on your filters</span>
          </div>
        </template>
      </div>
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
                <div class="FL_cc">
                  <div>
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
      <!-- load more -->
      <div class="loadmore" v-show="canLoadMore">
        <button
          :disabled="isLoading"
          class="btn btn-third btn-normalize loading"
          @click.prevent="loadMore"
        >
          <span v-show="isLoading">
            <span>Loading...</span>
          </span>
          <span v-show="!isLoading">Load More</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
const axPF = axios.create({
  baseURL: window.location.protocol + "//" + window.location.hostname,
  timeout: 1000,
  headers: { "X-Custom-Header": "foobar" },
});
export default {
  data() {
    return {
      sections: [],
      secScroller: null,
      rightBtn: null,
      leftBtn: null,
      filter: "All",
      isLoading: false,
      canLoadMore: true,
      isFresh: false,
      items: [],
      current: null,
      data: null,
      exchangeRates: [],
    };
  },
  props: {
    currency: String,
    symbol: String,
  },
  methods: {
    currentFilter() {
      Object.values(this.sections).forEach((e) => {
        Object.values(e.categories).forEach((c) => {
          if (c.subcategories.length > 0) {
            Object.values(c.subcategories).forEach((s) => {
              if (this.filter == s.id) {
                this.current = s;
              }
            });
          } else {
            if (this.filter == c.id) {
              this.current = c;
            }
          }
        });
      });
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
    scrollLeft() {
      this.secScroller.scrollLeft -= 200;
      this.checkScroll();
    },
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
    },

    checkScroll() {
      if (this.secScroller) {
        if (this.secScroller.scrollLeft == 0) {
          this.leftBtn.style.display = "none";
          this.rightBtn.style.display = "flex";
        } else {
          this.leftBtn.style.display = "flex";
          if (
            this.secScroller.scrollWidth -
              this.secScroller.clientWidth -
              this.secScroller.scrollLeft ==
            0
          ) {
            this.rightBtn.style.display = "none";
          }
        }
      }
    },
    scrollRight() {
      this.secScroller.scrollLeft += 200;
      this.checkScroll();
    },
    getURL() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const i = urlParams.get("search_type");
      if (i) {
        this.filter = i;
      } else {
        window.location.href = "/explore/parlors";
      }
    },
    setFilter(filter) {
      this.canLoadMore = true;
      this.filter = filter.id;
      this.page = 0;
      this.isFresh = true;
      this.current = filter;
      this.getResults();
    },
    getResults() {
      this.page = 1;
      axPF
        .get(
          this.$siteURL +
            "/get/parlor/search?tab_id=parlor_tab&search_type=" +
            this.filter +
            "&page=" +
            this.page
        )
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
      axPF
        .get(
          this.$siteURL +
            "/get/parlor/search?tab_id=parlor_tab&search_type=" +
            this.filter +
            "&page=" +
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
  async mounted() {
    this.getURL();
    this.secScroller = document.querySelector(".plr_flt_ovf");
    this.leftBtn = document.querySelector(".scrl_btn_wrap_left");
    this.rightBtn = document.querySelector(".scrl_btn_wrap_right");

    if (this.leftBtn && this.secScroller.scrollLeft == 0) {
      this.leftBtn.style.display = "none";
    }

    let that = this;
    let interceptor = axPF.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    axPF.interceptors.response.use(
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

    await axios
      .get(this.$siteURL + "/api/v1/exchangerates")
      .then((res) => {
        this.exchangeRates = res.data;
      })
      .catch((error) => {
        colsole.log(error);
      });

    await axPF
      .get(this.$siteURL + "/get/parlor/section/available")
      .then((res) => {
        this.sections = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
    this.getResults();
    this.currentFilter();
  },
};
</script>
