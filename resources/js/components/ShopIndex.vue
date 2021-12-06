<template>
  <div class="f">
    <div class="_MBL_fix_btm">
      <div class="">
        <div class="shop-wrap">
          <div class="">
            <h1>Shops</h1>
          </div>
        </div>
        <div class="shop-grid">
          <div v-for="(shop, index) in shops" :key="index" class="shop-card round_c_m">
            <div class="shop-card-head">
              <div class="flex-box shop-head">
                <div class="shop-profile round_full">
                  <img
                    class="shop-profile-img"
                    :src="`${$siteURL}/images/profile/thumb/${shop.profile_image}`"
                    alt=""
                  />
                  <a :href="`${$siteURL}/${shop.slug}`" class="shop-p-link"></a>
                </div>
                <div>
                  <a :href="`${$siteURL}/${shop.slug}`" class="shop_namelink">
                    <h2 class="typography-headline5 thead shop-card-name">
                      {{ shop.name }}
                    </h2>
                  </a>
                  <span class="shop-card-followers"
                    >{{ shop.followers_count }} followers</span
                  >
                </div>
              </div>
              <follow-studio-basic :is_following="shop.is_followed" :sid="shop.id" />
            </div>
            <div class="shop-card-body round_c_s">
              <div
                v-for="(item, i) in shop.product.slice(0, 3)"
                :key="i"
                class="shop-card-item"
              >
                <div class="shop-item-wrap">
                  <div class="shop-img-container">
                    <img
                      class="shop-img"
                      :src="`${$siteURL}/images/product/small/${item.meta.thumbnail}`"
                      alt=""
                    />
                  </div>
                </div>
              </div>
              <a :href="`${$siteURL}/${shop.slug}`" class="shop-p-link"></a>
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
import FollowStudioBasic from "./FollowStudioBasic.vue";
export default {
  data() {
    return {
      shops: [],
      data: null,
      page: 0,
      isLoading: false,
      canLoadMore: true,
    };
  },
  components: {
    FollowStudioBasic,
  },
  created() {
    this.getResults();
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
        .get(this.$siteURL + "/api/feed/shops?page=" + this.page)
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          res.data.data.forEach((e) => {
            this.shops.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadMore() {
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
        .get(this.$siteURL + "/api/feed/shops?page=" + this.page)
        .then((res) => {
          let a = Object.values(res.data.data);
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          a.forEach((e) => {
            this.shops.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  computed: {
    classOne(i) {
      return "one";
    },
  },
};
</script>

<style>
.shop-card-name {
  margin-bottom: 2px;
  color: var(--gray-very-dark);
}
.shop-card-followers {
  margin-bottom: 5px;
  color: var(--gray-dark);
}
.shop-grid {
  display: grid;
  grid-column-gap: 30px;
  grid-template-columns: auto auto;
  grid-row-gap: 30px;
}
.shop-card {
  display: flex;
  width: 100%;
  flex-direction: column;
  border: solid 1px var(--gray-light);
  padding: 15px;
  box-sizing: border-box;
}
.shop-card-head {
  display: flex;
  width: 100%;
  margin-bottom: 10px;
  box-sizing: border-box;
  justify-content: space-between;
}
.shop-p-link {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
}
.shop_namelink {
  text-decoration: none;
}
.shop-card-body {
  display: flex;
  width: 100%;
  position: relative;
}
.shop-profile {
  height: 50px;
  width: 50px;
  margin-right: 8px;
  position: relative;
}
.shop-profile-img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}
.shop-card-item {
  display: flex;
  width: calc(100% / 3);
}
.shop-item-wrap {
  width: 100%;
  padding-top: 100%;
  position: relative;
}
.shop-img-container {
  position: absolute;
  top: 0;
  height: 100%;
  width: 100%;
}
.shop-img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}
.shop-head {
  align-items: center;
}
@media only screen and (max-width: 920px) {
  .shop-grid {
    display: grid;
    grid-column-gap: 30px;
    grid-template-columns: auto;
    grid-row-gap: 30px;
  }
}
@media only screen and (max-width: 600px) {
  .shop-profile {
    height: 50px;
    width: 50px;
  }
  .shop-card {
    display: flex;
    width: 100%;
    flex-direction: column;
    border: none;
    padding: 0;
    margin-bottom: 15px;
    box-sizing: border-box;
  }
}
</style>
