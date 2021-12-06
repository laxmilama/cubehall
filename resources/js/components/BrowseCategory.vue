<template>
  <div class="filters _MBL_fix_btm">
    <div class="">
      <sub-category-header :cid="cid" :sub="sub"></sub-category-header>
      <div class="feed-overflow-slider sticky">
        <div class="all-filter">
          <div class="_Filters">
            <div class="_SCH_fC">
              <div class="btn-secondary btn-normalize" @click="toggleSizeBox" ref="fsize">
                Size
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="15"
                  height="15"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="animExpFtr"
                  v-bind:class="{ exP_fltr: sizeBox }"
                >
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
              <div
                class="fliter_wrap big-wrap"
                v-show="sizeBox"
                v-closable="{
                  exclude: ['fsize'],
                  handler: 'closeSizeFilter',
                }"
              >
                <div class="_SCH_ddown round_c_m">
                  <div v-for="s in sizes" :key="s.code" class="_SCH_opt_wrap">
                    <label :for="`size_${s.code}`">
                      <div class="_SCH_opt_item">
                        <span>{{ s.name }}</span>
                        <input
                          type="radio"
                          class="_SCH_radio"
                          name="_SCH_size_option"
                          :value="`${s.code}`"
                          :id="`size_${s.code}`"
                          v-model="size_"
                          @change="goToSearch()"
                        />
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="_SCH_fC">
              <div
                class="btn-secondary btn-normalize"
                @click="toggleColorBox"
                ref="fcolor"
              >
                Color

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="15"
                  height="15"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="animExpFtr"
                  v-bind:class="{ exP_fltr: colorBox }"
                >
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
              <div
                class="fliter_wrap"
                v-show="colorBox"
                v-closable="{
                  exclude: ['fcolor'],
                  handler: 'closeColorFilter',
                }"
              >
                <div class="_SCH_ddown round_c_m color-filter-wrap">
                  <div v-for="(row, index) in colors" :key="index">
                    <div
                      v-for="col in row"
                      :style="{ background: col }"
                      class="color-grid-box"
                      :key="col"
                      @click="applyColor(col)"
                    >
                      <svg
                        v-if="col == color_"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="white"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-check"
                      >
                        <polyline points="20 6 9 17 4 12"></polyline>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="_SCH_fC">
              <div
                class="btn-secondary btn-normalize"
                @click="toggleMatBox"
                ref="fmaterial"
              >
                Material
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="15"
                  height="15"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="animExpFtr"
                  v-bind:class="{ exP_fltr: matBox }"
                >
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </div>
              <div
                class="fliter_wrap big-wrap"
                v-show="matBox"
                v-closable="{
                  exclude: ['fmaterial'],
                  handler: 'closeMatFilter',
                }"
              >
                <div class="_SCH_ddown round_c_m">
                  <div v-for="m in materials" :key="m.code" class="_SCH_opt_wrap">
                    <label :for="`${m.code}`">
                      <div class="_SCH_opt_item">
                        <span>{{ m.name }}</span>
                        <input
                          type="checkbox"
                          name="_SCH_size_option"
                          :value="`${m.code}`"
                          :id="`${m.code}`"
                          v-model="material_"
                          @change="goToSearch"
                        />
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="_SCH_fC" @click="clearFilter">
              <div class="btn-secondary btn-normalize">Clear Filter</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div v-if="items.length > 0" class="showoff-show-wrapper _MBL-addPad">
        <div v-for="(product, index) in items" :key="index">
          <div style="position: relative">
            <div class="showoff-show">
              <div class="showof-show-content">
                <a
                  :href="`${$siteURL}/list/${product.slug}?c=${toBash(
                    product.id,
                    product.item_type,
                    product.page_id
                  )}`"
                  data-collector
                >
                  <img
                    class="showoff-show-img"
                    :src="`${$siteURL}/images/product/small/${product.meta.thumbnail}`"
                    width="100%"
                  />
                </a>
              </div>
            </div>
          </div>
          <strong
            >{{ symbol
            }}{{ convertedPrice(product.meta.price, product.meta.currency) }}</strong
          >
        </div>
      </div>
      <div v-else>
        <div>
          <strong>No results found</strong>
          <p>It seems we can’t find any results based on your search.</p>
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
  </div>
</template>

<script>
import hcSticky from "../hc-sticky";
import axios from "axios";
const instance = axios.create({
  baseURL: window.location.protocol + "//" + window.location.hostname,
  timeout: 1000,
  headers: { "X-Custom-Header": "foobar" },
});

import SubCategoryHeader from "./SubCategoryHeader.vue";

export default {
  name: "BrowseCategoryProducts",
  data() {
    return {
      data: null,
      items: [],
      page: 0,
      sizes: null,
      colors: null,
      materials: null,
      prices: null,
      ratings: null,

      colorBox: false,
      sizeBox: false,
      matBox: false,
      priceBox: false,
      rateBox: false,
      orderBox: false,

      // to fill up the search form
      product_: null,
      rating_: null,
      price_: null,
      size_: null,
      material_: [],
      color_: "",
      isFresh: true,
      isLoading: false,
      canLoadMore: true,
      exchangeRates: [],
    };
  },
  props: ["currency", "symbol", "cid", "sub"],
  components: {
    SubCategoryHeader,
  },
  async mounted() {
    // console.log(this.$name);
    var sticky = document.getElementsByClassName("sticky");

    for (var i = 0; i < sticky.length; i++) {
      console.log(sticky[i].parentNode.parentNode);
      new hcSticky(sticky[i], {
        stickTo: sticky[i].parentNode.parentNode,
        top: 60,
      });
    }

    this.getURL();
    this.getColors();
    this.getPriceRanges();
    this.getSizes();
    this.getRatings();
    this.getMaterials();
    this.goToSearch();
    this.getExchangeRates();

    let that = this;

    let interceptor = instance.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    instance.interceptors.response.use(
      function (response) {
        that.isLoading = false;
        if (that.isFresh) {
          that.clearData();
        }
        return response;
      },
      function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        return Promise.reject(error);
      }
    );
    instance.interceptors.request.eject(interceptor);
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
    getExchangeRates() {
      axios
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
    getURL() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const i = urlParams.get("search_product");
      const p = urlParams.get("price");
      const s = urlParams.get("size");
      const m = urlParams.get("material");
      const r = urlParams.get("rating");
      const c = urlParams.get("color_hex");
      if (i) {
        this.product_ = i;
      }
      if (p) {
        this.price_ = p;
      }
      if (s) {
        this.size_ = s;
      }
      if (m) {
        this.material_ = m.split(",");
      }
      if (r) {
        this.rating_ = r;
      }
      if (c) {
        this.color_ = "#" + c;
      }
    },
    applyColor(color) {
      this.color_ = color;
      this.goToSearch();
    },
    clearData() {
      this.data = null;
      this.items = [];
    },

    async goToSearch() {
      this.isFresh = true;

      var view = window.location.pathname,
        query = "/api" + window.location.pathname;
      var request = "?";

      if (this.color_) {
        request = request + "&color=" + this.color_.slice(1, this.color_.length);
      }
      if (this.size_) {
        request = request + "&size=" + this.size_;
      }
      if (this.material_.length > 0) {
        request = request + "&material=" + encodeURIComponent(this.material_);
      }

      // change History and url addressbar
      history.pushState(" ", this.product_, this.$siteURL + view + request);

      await instance
        .get(this.$siteURL + query + request)
        .then((res) => {
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          console.log("loaded");
          res.data.data.forEach((e) => {
            this.items.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });

      if (this.data) {
        if (this.data.current_page < this.data.last_page) {
          this.page = this.data.current_page + 1;
          this.canLoadMore = true;
        } else {
          this.canLoadMore = false;
          return true;
        }
      } else {
        this.page = 1;
      }
      // window.location.href = url;
    },
    clearFilter() {
      // this.product_ = null;
      this.price_ = null;
      this.rating_ = null;
      this.color_ = null;
      this.material_ = [];
      this.size_ = null;
      this.page = 0;

      this.goToSearch();

      // this.canLoadMore = true;
    },
    async loadMore() {
      this.isFresh = false;

      var view = window.location.pathname,
        query = "/api" + window.location.pathname;
      var request = "?";

      if (this.color_) {
        request = request + "&color_hex=" + this.color_.slice(1, this.color_.length);
      }
      if (this.size_) {
        request = request + "&size=" + this.size_;
      }

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
      await instance
        .get(this.$siteURL + query + request + "&page=" + this.page)
        .then((res) => {
          let a = Object.values(res.data.data);
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          console.log("loaded");
          a.forEach((e) => {
            this.items.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getSizes() {
      axios.get(this.$siteURL + "/js/filter/sizes.json").then((result) => {
        this.sizes = result.data;
      });
    },
    getPriceRanges() {
      axios.get(this.$siteURL + "/js/filter/prices.json").then((result) => {
        this.prices = result.data;
      });
    },
    getColors() {
      axios.get(this.$siteURL + "/js/filter/color.json").then((result) => {
        this.colors = result.data;
      });
    },
    getRatings() {
      axios.get(this.$siteURL + "/js/filter/ratings.json").then((result) => {
        this.ratings = result.data;
      });
    },
    getMaterials() {
      axios.get(this.$siteURL + "/js/filter/materials.json").then((result) => {
        this.materials = result.data;
      });
    },
    toggleColorBox() {
      this.colorBox = !this.colorBox;
    },
    toggleSizeBox() {
      this.sizeBox = !this.sizeBox;
    },
    toggleMatBox() {
      this.matBox = !this.matBox;
    },
    togglePriceBox() {
      this.priceBox = !this.priceBox;
    },
    toggleRateBox() {
      this.rateBox = !this.rateBox;
    },
    toggleOrderBox() {
      this.orderBox = !this.orderBox;
    },
    closeColorFilter() {
      this.colorBox = false;
    },
    closeSizeFilter() {
      this.sizeBox = false;
    },
    closeOrderFilter() {
      this.orderBox = false;
    },
    closeMatFilter() {
      this.matBox = false;
    },
    closeRateFilter() {
      this.rateBox = false;
    },
    closePriceFilter() {
      this.priceBox = false;
    },
  },
};
</script>
<style scoped>
.color-filter-wrap {
  display: flex;
}
.fliter_wrap {
  position: absolute;
  z-index: 100;
  /* top: 42px; */
  /* transform: translate(-15px, 50%); */
}
.color-filter-wrap .active {
  border: solid 2px white;
}
.color-grid-box {
  height: 25px;
  width: 25px;
  box-sizing: border-box;
}
.color-grid-box:hover {
  border: solid 2px white;
  cursor: pointer;
}
.all-filter {
  display: flex;
  width: 100%;
  overflow-x: auto;
  -ms-overflow-style: none;
  /* IE 11 */
  scrollbar-width: none;
  /* Firefox 64 */
}
.all-filter::-webkit-scrollbar {
  display: none;
}
.exP_fltr {
  transform: rotate(-180deg);
}
.animExpFtr {
  transition: all ease-in-out 0.15s;
}
._Filters {
  display: flex;
}

@media only screen and (max-width: 600px) {
  .fliter_wrap {
    width: 100%;
    left: 0;
    /* overflow: auto; */
  }

  .big-wrap {
    overflow: auto;

    max-height: 400px;
  }

  .color-grid-box {
    height: 35px;
    width: calc(calc(100vw / 13) - 3.5px);
    box-sizing: border-box;
  }
}
</style>
