<style scoped>
td {
  padding: 8px;
}
._c_active {
  background: var(--blue);
}
._c_expired {
  background: var(--gray-light);
}
._cp_status {
  padding: 6px 9px;
  width: fit-content;
}
</style>
<template>
  <div>
    <div class="mt mb-m">
      <div style="display: flex; justify-content: space-between" class="mb-s">
        <h3>Discount Coupons</h3>
        <button @click="couponBox = true" class="btn-normalize btn-primary">
          Create Coupon
        </button>
      </div>
      <table width="100%">
        <tr v-for="(coupon, i) in coupons" :key="i">
          <td>
            <strong>{{ coupon.code }}</strong>
            <div v-if="coupon.type == 'Fixed'">
              <span> {{ coupon.currency }} {{ coupon.amount_off }} off </span>
              <span v-if="coupon.option == 'All Products'"> on all products </span>
              <span v-else-if="coupon.option == 'Collections'">
                collection
                <template v-if="JSON.parse(coupon.option_meta) != '[]'">
                  <span v-for="(cl, icl) in JSON.parse(coupon.option_meta)" :key="icl">
                    <span>
                      {{ cl.name }}
                    </span>
                  </span>
                </template>
              </span>
            </div>
            <div v-if="coupon.type == 'Percentage'">
              <span> {{ coupon.percent_off }}% off on</span>
              <span v-if="coupon.option == 'All Products'"> on all products </span>
              <span v-else-if="coupon.option == 'Collections'">
                collections
                <template v-if="JSON.parse(coupon.option_meta) != '[]'">
                  <span v-for="(cl, icl) in JSON.parse(coupon.option_meta)" :key="icl">
                    <span>
                      {{ cl.name }}
                    </span>
                  </span>
                </template>
              </span>
            </div>
          </td>
          <td>
            <span>
              {{ coupon.times_redeemed
              }}<template v-if="coupon.max_redemptions != 0"
                >/{{ coupon.max_redemptions }}
              </template>
              used
            </span>
          </td>
          <td>{{ localDay(coupon.expires_at) }}</td>
          <td>{{ localDay(coupon.created_at) }}</td>
          <td>
            <div v-if="coupon.status == 1" class="_c_active _cp_status round_c_m">
              <span>Active</span>
            </div>
            <div v-else class="_c_expired _cp_status round_c_m">
              <span>Expired</span>
            </div>
          </td>
        </tr>
      </table>
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
    <div v-if="couponBox">
      <div class="_SO_overlay"></div>
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <button class="_SO_d_bx" @click="couponBox = false">X</button>
            <h3 style="margin: 20px">Create coupon</h3>
          </div>
          <div class="_SO_d_b">
            <div>
              <div class="_Coupon_card">
                <label for="_c_code">Coupon Code</label>
                <div class="_Coupon_body flex-box">
                  <input
                    v-model="code"
                    type="text"
                    placeholder="eg. WINTERSELL2020"
                    name="_c_code"
                    id="_c_code"
                    class="_inp_admn"
                    style="width: 200px !important; margin: 0"
                  />

                  <button
                    style="margin-top: 0; margin-left: 25px"
                    class="btn-normalize btn-secondary"
                    @click="genereateCode"
                  >
                    <span>Generate Code</span>
                  </button>
                </div>
              </div>
              <div class="_Coupon_card">
                <div class="_Coupon_head">
                  <h2>Type</h2>
                </div>
                <div class="_Coupon_body">
                  <div v-for="(type, index) in types" :key="index">
                    <input v-model="typeSelected" type="radio" :id="type" :value="type" />
                    <label :for="type">
                      <span>{{ type }}</span></label
                    >
                  </div>
                  <div v-if="typeSelected == 'Fixed'">
                    <span>NPR</span>
                    <input
                      v-model="fixed"
                      type="number"
                      placeholder="fixed"
                      min="1"
                      max="99999"
                      class="_inp_admn"
                    />
                  </div>
                  <div v-if="typeSelected == 'Percentage'">
                    <input
                      v-model="percentage"
                      type="number"
                      min="1"
                      max="100"
                      class="_inp_admn"
                      placeholder="Percentage"
                    />
                    <span>%</span>
                  </div>
                </div>
              </div>
              <div class="_Coupon_card">
                <div class="_Coupon_head">
                  <h2>Option</h2>
                </div>
                <div class="_Coupon_body">
                  <div v-for="(o, index) in options" :key="index">
                    <input v-model="option" type="radio" :id="o" :value="o" />
                    <label :for="o">
                      <span>{{ o }}</span></label
                    >
                  </div>
                  <div v-if="option == 'Collections'">
                    <multiselect
                      v-model="categories"
                      tag-placeholder="Add this as new tag"
                      placeholder="Search or add a collection"
                      label="name"
                      track-by="id"
                      :options="collections"
                      :multiple="true"
                      :taggable="true"
                    ></multiselect>
                  </div>
                  <div v-if="option == 'Products'">
                    <multiselect
                      v-model="selectedProducts"
                      placeholder="Search or add a product"
                      label="name"
                      track-by="id"
                      :options="products"
                      :option-height="104"
                      :custom-label="customLabel"
                      :show-labels="false"
                    >
                      <template slot="singleLabel" slot-scope="props"
                        ><img
                          class="option__image"
                          :src="props.option.thumb"
                          alt="No Man’s Sky"
                        /><span class="option__desc"
                          ><span class="option__title">{{
                            props.option.name
                          }}</span></span
                        ></template
                      >
                      <template slot="option" slot-scope="props"
                        ><img
                          class="option__image"
                          :src="props.option.thumb"
                          alt="No Man’s Sky"
                        />
                        <div class="option__desc">
                          <span class="option__title">{{ props.option.name }}</span>
                        </div>
                      </template>
                    </multiselect>
                  </div>
                </div>
              </div>
              <div class="_Coupon_card">
                <div class="_Coupon_head">
                  <h2>Eligibility</h2>
                </div>
                <div class="_Coupon_body">
                  <div v-for="(type, index) in eligibility" :key="index">
                    <input v-model="elegible" type="radio" :id="type" :value="type" />
                    <label :for="type">
                      <span>{{ type }}</span></label
                    >
                  </div>
                  <div v-if="elegible == 'Customer'">
                    <multiselect
                      v-model="selectedShoppers"
                      placeholder="Search or add a shoppers"
                      label="name"
                      track-by="id"
                      :options="shoppers"
                      :option-height="104"
                      :show-labels="false"
                      :multiple="true"
                    >
                      <template slot="singleLabel" slot-scope="props"
                        ><img
                          class="opt_user_image"
                          :src="props.option.thumb"
                          :alt="props.option.name"
                        /><span class="option__desc"
                          ><span class="option__title">{{
                            props.option.name
                          }}</span></span
                        ></template
                      >
                      <template slot="option" slot-scope="props"
                        ><img
                          class="option__image"
                          :src="props.option.thumb"
                          alt="No Man’s Sky"
                        />
                        <div class="option__desc">
                          <span class="option__title">{{ props.option.name }}</span>
                        </div>
                      </template>
                    </multiselect>
                  </div>
                </div>
              </div>
              <div class="_Coupon_card">
                <div class="_Coupon_head">
                  <h2>Usage limits</h2>
                </div>
                <div class="_Coupon_body">
                  <div>
                    <input v-model="limit" type="checkbox" id="_limit" />
                    <label for="_limit">
                      <span>
                        Limit number of times this discount can be used in total</span
                      ></label
                    >
                  </div>
                  <div v-if="limit">
                    <input class="_inp_admn" type="number" v-model="max_redemtion" />
                  </div>
                </div>
              </div>
              <div class="_Coupon_card">
                <div class="_Coupon_head">
                  <h2>Expires at</h2>
                </div>
                <div class="_Coupon_body">
                  <div>
                    <VueCtkDateTimePicker
                      v-model="expiryDate"
                      :minDate="minimumDate"
                      :dark="darkMode"
                      :minuteInterval="5"
                      :overlay="true"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="uploader_btns">
            <span></span>
            <button
              :disabled="couponValidation"
              type="submit"
              class="btn-normalize btn-third"
              @click.prevent="save"
            >
              <span v-if="!isLoading"> Save Coupon</span>
              <span v-else> Please wait... </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
import axios from "axios";
import Multiselect from "vue-multiselect";
export default {
  components: {
    VueCtkDateTimePicker,
    Multiselect,
  },

  props: ["products", "collections", "shoppers"],
  data() {
    return {
      code: "",
      types: ["Percentage", "Fixed"],
      eligibility: ["Everyone", "Secret", "Customer"],
      options: ["All Products", "Collections", "Products"],
      typeSelected: "Fixed",
      option: "All Products",
      categoryLists: [
        { name: "Vue.js", id: 10 },
        { name: "Javascript", id: 20 },
        { name: "Open Source", id: 200 },
      ],
      data: null,
      coupons: [],
      page: 0,
      isLoading: false,
      canLoadMore: true,
      couponBox: false,
      expiryDate: null,
      percentage: null,
      fixed: null,
      limit: false,
      max_redemtion: null,
      categories: [],
      selectedProducts: [],
      selectedShoppers: [],
      darkMode: null,
      isLoading: false,
      elegible: "Everyone",
    };
  },
  mounted() {
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "dark") {
      this.darkMode = true;
    } else {
      this.darkMode = false;
    }

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

    axios
      .get(this.$siteURL + "/studio/get/coupons")
      .then((res) => {
        this.data = res.data;
        Object.values(res.data.data).forEach((e) => {
          this.coupons.push(e);
        });
      })
      .catch((err) => {
        console.log(err);
      });
  },
  methods: {
    genereateCode() {
      this.code = Math.random().toString(30).slice(5).toUpperCase();
    },
    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format();
    },
    localDay(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("MMM Do, YYYY");
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
      axios
        .get(this.$siteURL + "/studio/get/coupons?page=" + this.page)
        .then((res) => {
          let a = Object.values(res.data.data);
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          a.forEach((e) => {
            this.coupons.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    save() {
      let couponData = new FormData();

      if (this.typeSelected == "Fixed") {
        this.percentage = null;
      } else {
        this.fixed = null;
      }

      if (this.option == "All Products") {
        this.categories = null;
        this.selectedProducts = null;
      } else if (this.option == "Collections") {
        this.selectedProducts = null;
      } else if (this.option == "Products") {
        this.categories = null;
      }

      if (this.elegible == "Everyone") {
        this.selectedShoppers = null;
      }
      if (this.limit == false) {
        this.max_redemtion = null;
      }
      if (this.percentage > 100) {
        this.$toast.error("Percentage should be less than 100.", {
          position: "top-center",
          timeout: 3000,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: true,
          closeButton: "button",
          icon: true,
          rtl: false,
        });
        return;
      }
      couponData.append("max_redemtion", this.max_redemtion);
      couponData.append("code", this.code);
      couponData.append("fixed", this.fixed);
      couponData.append("percentage", this.percentage);
      couponData.append("expiry_date", this.expiryDate);
      couponData.append("option", this.option);
      couponData.append("type", this.typeSelected);
      couponData.append("collections", JSON.stringify(this.categories));
      couponData.append("products", JSON.stringify(this.selectedProducts));
      couponData.append("shoppers", JSON.stringify(this.selectedShoppers));
      couponData.append("elegible", this.elegible);
      axios
        .post(this.$siteURL + "/studio/add-coupon", couponData)
        .then((res) => {
          this.$toast.success("Discount coupon successfully created.", {
            position: "top-center",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });

          this.coupons.unshift(res.data);
          this.couponBox = false;
        })
        .catch((err) => {
          this.isLoading = false;
          this.$toast.error("Something went wrong!", {
            position: "top-center",
            timeout: 3000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        });
    },
  },
  computed: {
    minimumDate: function () {
      return moment().add(2, "days").format("YYYY-MM-DD");
    },
    couponValidation() {
      return this.code <= 4 || this.expiryDate == null;
    },
  },
};
</script>
<!-- New step!
     Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped lang="scss">
._Coupon {
  &_card {
    margin: 5px;
  }
  &_head {
    display: flex;
    justify-content: space-between;
    width: 100%;
  }
  &_body {
  }
}
.option__image {
  height: 60px;
  width: 60px;
}
</style>
