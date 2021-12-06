<template>
  <div>
    <div class="">
      <div class="sticky _filter_wrap">
        <div class="_follow_filters scrollable">
          <button
            v-for="f in filters"
            :key="f"
            @click="setFilter(f)"
            :disabled="f == filter"
            class="btn-filter"
          >
            <span>{{ f }}</span>
          </button>
        </div>
      </div>
    </div>
    <div class="following-wrapper">
      <div v-for="(item, index) in items" :key="index" class="following-item-card">
        <!-- IF ShowOff -->
        <div v-if="item.item_type == 'App\\Models\\ShowOff'" class="f-item-holder">
          <div style="position: relative">
            <div class="showoff-show">
              <div class="showof-show-content">
                <a
                  :href="`${$siteURL}/showoff/${item.slug}?c=${toBash(
                    item.id,
                    item.item_type,
                    item.owner.id
                  )}`"
                  data-collector
                >
                  <img
                    class="showoff-show-img"
                    :src="`${$siteURL}/images/showoff/small/${item.media}`"
                    width="100%"
                  />
                </a>
              </div>
            </div>
            <div class="explore-parlor-name">
              <span class="typography-headline6 title">{{ item.title }}</span>
              <div>
                <a :href="`${$siteURL}/@${item.owner.slug}`">
                  {{ item.owner.name }}
                </a>
              </div>
            </div>
          </div>
        </div>
        <!-- End ShowOff -->
        <!-- IF Parlor -->
        <div v-if="item.type == 'App\\Models\\Parlor'" class="f-item-holder">
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
                <strong>{{ item.title }}</strong>
                <div class="FL_cc">
                  <div class="flex-box FL_flex">
                    <div class="FL_item_pp round_full">
                      <img
                        class="FL_pp_img"
                        :src="`${$siteURL}/images/profile/thumb/${item.owner.profile_image}`"
                      />
                    </div>

                    <div class="FL_owner">
                      {{ item.owner.name }}
                    </div>
                  </div>
                  <div>
                    <div class="_FL_price">
                      {{
                        symbol + convertedPrice(item.ticket.price, item.ticket.currency)
                      }}
                    </div>
                    /
                    <span>person</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- End Parlor -->
        <!-- IF Product -->
        <div v-if="item.item_type == 'App\\Models\\ProductList'" class="f-item-holder">
          <div style="position: relative">
            <div class="showoff-show">
              <div class="showof-show-content">
                <a
                  :href="`${$siteURL}/list/${item.slug}?c=${toBash(
                    item.id,
                    item.item_type,
                    item.owner.id
                  )}`"
                  data-collector
                >
                  <img
                    class="showoff-show-img"
                    :src="`${$siteURL}/images/product/small/${item.meta.thumbnail}`"
                    width="100%"
                  />
                </a>
              </div>
            </div>
            <div>
              <div class="FL_content">
                <strong>{{ item.name }}</strong>
                <div class="FL_cc">
                  <div class="flex-box FL_flex">
                    <div class="FL_item_pp round_full">
                      <img
                        class="FL_pp_img"
                        :src="`${$siteURL}/images/profile/thumb/${item.owner.profile_image}`"
                      />
                    </div>

                    <div class="FL_owner">
                      {{ item.owner.name }}
                    </div>
                  </div>
                  <div class="_FL_price">
                    {{ symbol + convertedPrice(item.meta.price, item.meta.currency) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="feed-tag feed-tag-wrap round_c_b">
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
import hcSticky from "../hc-sticky";
import anime from "../anime";
import axios from "axios";
const followAxios = axios.create({
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
      exchangeRates: [],
      isLoading: false,
      canLoadMore: true,
      isFresh: false,
      filter: "all",
      filters: ["all", "product", "parlor", "showoff"],
    };
  },
  mounted() {
    this.getExchangeRates();
    var sticky = document.getElementsByClassName("sticky");

    for (var i = 0; i < sticky.length; i++) {
      new hcSticky(sticky[i], {
        stickTo: sticky[i].parentNode.parentNode,
        top: 59,
      });
    }

    this.getResults();

    anime
      .timeline({
        easing: "easeOutExpo",
        loop: true,
      })
      .add({
        targets: ".loader",
        duration: 100,
        delay: anime.stagger(100),
        opacity: [0, 1],
        easing: "easeOutCubic",
        loop: true,
      });

    let that = this;
    let interceptor = followAxios.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    followAxios.interceptors.response.use(
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
  },
  methods: {
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
    async getExchangeRates() {
      await axios
        .get(this.$siteURL + "/api/v1/exchangerates")
        .then((res) => {
          this.exchangeRates = res.data;
        })
        .catch((error) => {
          colsole.log(error);
        });
    },
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
    },
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
      followAxios
        .get(
          this.$siteURL + "/get/following/feed?type=" + this.filter + "&page=" + this.page
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
    getResults() {
      this.page = 1;
      followAxios
        .get(
          this.$siteURL + "/get/following/feed?type=" + this.filter + "&page=" + this.page
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
  },
};
</script>
<style>
.loader span {
  height: 10px;
  width: 10px;
  border-radius: 50%;
  background: var(--gray-very-light);
}
.FL_item_pp {
  height: 30px;
  width: 30px;
}
.FL_cc {
  display: flex;
  justify-content: space-between;
}
.FL_pp_img {
  object-fit: cover;
  height: 100%;
  width: 100%;
}
._follow_filters {
  display: flex;
  width: 100%;
  position: relative;
  background: var(--gray-very-light);
  padding-top: 6px;
  padding-bottom: 6px;
}
._filter_wrap {
  z-index: 10;
}
._FL_price {
  font-size: 16px;
  font-weight: 600;
}
</style>
