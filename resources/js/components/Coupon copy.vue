<template>
  <div>
    <div>
      <h1>Create discount code</h1>
      <div>
        <div class="_Coupon_card">
          <div class="_Coupon_head">
            <h2>Coupon Code</h2>
          </div>
          <div class="_Coupon_body">
            <input
              v-model="code"
              type="text"
              placeholder="eg. WINTERSELL2020"
              name=""
              class="_inp_admn"
            />

            <button class="btn-normalize mt-s btn-third" @click="genereateCode">
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
              <input
                v-model="fixed"
                type="number"
                placeholder="fixed"
                min="1"
                max="99999"
                class="_inp_admn"
              />
              <span>RS.</span>
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
                @tag="addTag"
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
                    ><span class="option__title">{{ props.option.name }}</span></span
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
                    ><span class="option__title">{{ props.option.name }}</span></span
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
        <div>
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
      coupons: [],
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
  },
  methods: {
    genereateCode() {
      this.code = Math.random().toString(30).slice(5).toUpperCase();
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

          window.location.href = this.$siteURL + "/studio/coupons";
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
.multiselect__option {
  display: flex;
}
</style>
