<template>
  <div class="sm-container clearPadMobile">
    <div v-if="overlay" class="_bag_address_overlay"></div>
    <template v-if="ihavecoupon">
      <div class="_bag_address_overlay"></div>
      <div class="_bag_address">
        <div class="_bag_address_wrap">
          <div class="_bag_address_card round_c_m">
            <div class="_bag_address_cont">
              <div style="text-align: center">
                <h2 style="margin-top: 0">Coupon</h2>
              </div>
              <div class="">
                <div class="inp_s inp_g">
                  <div>
                    <input
                      type="text"
                      id="voucher"
                      v-input
                      name="voucher"
                      spellcheck="false"
                      class="inp_height inp_100"
                      :class="{ invalid: invalidCoupon }"
                      v-model="voucher"
                      v-on:input="clearInvalidCoupon"
                      placeholder="Enter a coupon code"
                    />
                  </div>
                  <div v-if="invalidCoupon" style="margin-top: 8px; margin-bottom: 8px">
                    <div style="color: var(--primary-color)">Invalid coupon code.</div>
                  </div>
                </div>
                <div>
                  <div class="st_btn_wrap btns">
                    <button
                      class="st_btn_back"
                      @click.prevent="ihavecoupon = !ihavecoupon"
                    >
                      Cancle
                    </button>
                    <button
                      :disabled="!isValidCoupon"
                      class="btn-normalize btn-third"
                      @click="applyCoupon"
                    >
                      Apply
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-if="addAddressDialog">
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <h2>Add Address</h2>
          </div>

          <div class="_SO_d_b">
            <div class="inp_g">
              <label for="addressName" class="inp_l">Full Name</label>
              <div class="inp_r">
                <input
                  type="text"
                  id="addressName"
                  name="street"
                  placeholder="Your Name"
                  spellcheck="false"
                  class="inp_height inp_100"
                  v-model="address.name"
                />
              </div>
            </div>
            <div class="inp_g">
              <label for="addressPhone" class="inp_l">Phone number</label>
              <div class="inp_r">
                <input
                  type="text"
                  id="addressPhone"
                  name="street"
                  placeholder="Contact Number"
                  spellcheck="false"
                  class="inp_height inp_100"
                  v-model="address.phone"
                />
              </div>
            </div>
            <div class="inp_s inp_g">
              <div>
                <label for="country" class="inp_l">Country/region</label>
              </div>
              <div>
                <select class="inp_height" name="" id="country" v-model="address.country">
                  <option v-for="c in countries" :key="c.code" :value="c.code">
                    {{ c.name }}
                  </option>
                </select>
              </div>
            </div>
            <div>
              <div class="inp_g">
                <label for="name" class="inp_l">City</label>
                <div class="inp_r">
                  <input
                    type="text"
                    id="name"
                    name="city"
                    spellcheck="false"
                    class="inp_height inp_100"
                    v-model="address.city"
                  />
                  <span v-if="!isValidCity" class="inp_warning">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="12" y1="8" x2="12" y2="12"></line>
                      <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                  </span>
                </div>
              </div>
              <div class="inp_g">
                <label for="addressstate" class="inp_l">State</label>
                <div class="inp_r">
                  <input
                    type="text"
                    id="addressstate"
                    name="state"
                    spellcheck="false"
                    class="inp_height inp_100"
                    v-model="address.state"
                  />
                  <span v-if="!isValidState" class="inp_warning">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="18"
                      height="18"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="12" y1="8" x2="12" y2="12"></line>
                      <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                  </span>
                </div>
              </div>
            </div>
            <div class="inp_g">
              <label for="addressstreet" class="inp_l">Street</label>
              <div class="inp_r">
                <input
                  type="text"
                  id="addressstreet"
                  name="street"
                  placeholder="Ex: Trishakti Marg 2"
                  spellcheck="false"
                  class="inp_height inp_100"
                  v-model="address.street"
                />
                <span v-if="!isValidStreet" class="inp_warning">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                </span>
              </div>
            </div>
            <div class="inp_g">
              <label for="addressapt" class="inp_l">Apt, suite. (optional)</label>
              <div class="inp_r">
                <input
                  type="text"
                  id="addressapt"
                  name="apt"
                  placeholder="Ex: 123 Main St."
                  spellcheck="false"
                  class="inp_height inp_100"
                  v-model="address.apt"
                />
              </div>
            </div>
            <div class="inp_g">
              <label for="addresspostal" class="inp_l">Postal Code (optional)</label>
              <div class="inp_r">
                <input
                  type="text"
                  id="addresspostal"
                  name="zipcode"
                  spellcheck="false"
                  class="inp_height inp_100"
                  v-model="address.postal"
                />
                <span v-if="!isValidPostal" class="inp_warning">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                </span>
              </div>
            </div>
          </div>
          <div style="padding-right: 15px; padding-left: 15px">
            <div class="st_btn_wrap">
              <button class="st_btn_back" @click.prevent="cancleAddress">Cancle</button>
              <button
                class="st_btn"
                @click.prevent="saveAddress"
                :disabled="!validAddress"
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-if="changeDialog">
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <h2 style="">Choose shipping address</h2>
          </div>
          <div class="_SO_d_b">
            <div>
              <div
                class="_bag_address_select1"
                v-for="(ad, index) in addresses"
                :key="index"
              >
                <input
                  class="_SCH_radio"
                  type="radio"
                  name="defaultAddress"
                  :id="'_address' + ad.id"
                  v-model="currentAddress"
                  :value="ad.id"
                />
                <label :for="'_address' + ad.id" class="_bag_address_lbl">
                  <div>
                    <div>
                      <strong>{{ ad.name }}</strong>
                    </div>
                    <div>
                      <span>{{ ad.street }}</span>
                    </div>
                    <div>
                      <span>{{ ad.city }}</span>
                    </div>
                    <div>
                      <span>{{ ad.apt }}</span>
                    </div>
                    <div>
                      {{ ad.country }}
                    </div>
                  </div>
                </label>
              </div>
            </div>
            <div>
              <button @click="addAddress" class="btn-normalize">
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
                  class="feather feather-plus"
                >
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Add New Address</span>
              </button>
            </div>
          </div>

          <div style="padding-right: 15px; padding-left: 15px">
            <div class="st_btn_wrap">
              <button class="st_btn_back" @click.prevent="closeChange">Cancle</button>
              <button
                class="st_btn"
                @click.prevent="saveSelectedAddress"
                :disabled="!canSaveSelected"
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>

    <!-- Bag items -->
    <div class="_bag_bar"></div>
    <div v-if="Object.values(items).length > 0" class="flex-box _bag">
      <div class="_bag_left _MBL_overlap">
        <div class="flex-box" style="align-items: center">
          <div>
            <button @click.prevent="goBack" class="_bag_btn_cart">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="var(--gray-very-dark)"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-chevron-left"
              >
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            </button>
          </div>
          <div>
            <h2>Your Bag</h2>
          </div>
        </div>
        <div class="_bag_address">
          <div>Shipping Address</div>
          <div v-if="addresses.length > 0">
            <div v-if="defaultAddress">
              <div v-for="(d, i) in defaultAddress" :key="i">
                <div v-if="d.name">
                  <strong>{{ d.name }}</strong>
                </div>
                <span v-if="d.street"> {{ d.street }}</span>
                <span v-if="d.apt">, {{ d.apt }}</span>
                <span v-if="d.city">, {{ d.city }}</span>
                <span v-if="d.state">, {{ d.state }}</span>
                <span v-if="d.postal">, {{ d.postal }}</span>
                <span v-if="d.country">, {{ d.country }}</span>
              </div>
            </div>
            <div>
              <button class="btn-normalize btn-secondary" @click="changeAddress">
                Change
              </button>
            </div>
          </div>
          <div v-else>
            <div>Please provide us your delivery address</div>
            <div>
              <button class="btn-normalize btn-secondary" @click="addAddress">Add</button>
            </div>
          </div>
        </div>
        <!-- items -->
        <div class="mt">
          <div v-for="(list, i) in items" :key="i">
            <template v-if="list.length > 0">
              <div>
                <h3 class="_bag_owner">
                  Solds and shipped by {{ list[0].store.name }} ({{ list.length }} items)
                </h3>
              </div>
              <div style="display: flex; flex-direction: column">
                <div v-for="(product, index) in list" :key="index" class="_bag_card">
                  <div class="flex-box">
                    <div class="_bag_thumb round_c_s">
                      <a
                        :href="`${$siteURL}/list/` + product.bagmetaproduct.product.slug"
                      >
                        <img
                          class="_bag_img"
                          :src="
                            `${$siteURL}/images/product/thumb/` +
                            product.bagmetaproduct.thumbnail
                          "
                        />
                      </a>
                    </div>
                    <div class="_bag_infos">
                      <div>
                        <a
                          class="_bag_i_name"
                          :href="
                            `${$siteURL}/list/` + product.bagmetaproduct.product.slug
                          "
                        >
                          <strong>{{ product.bagmetaproduct.product.name }}</strong>
                          <div>{{ product.bagmetaproduct.title }}</div>
                        </a>
                      </div>
                      <div class="flex-box _bag_detail">
                        <div>
                          <div>Size: {{ product.bagmetaproduct.size }}</div>
                          <div>
                            <a
                              href="#remove"
                              class="_bag_remove"
                              @click.prevent="removeItem($event, i, index, product.id)"
                              >Remove</a
                            >
                          </div>
                          <template
                            v-if="product.bagmetaproduct.availability == 'SoldOut'"
                          >
                            <div class="_bag_warn">Sold Out</div>
                          </template>
                          <template
                            v-if="
                              product.bagmetaproduct.availability == 'LimitedAvailability'
                            "
                          >
                            <div class="_bag_warn">
                              Only {{ product.bagmetaproduct.available }} available.
                            </div>
                          </template>
                          <template v-if="defaultAddress.length > 0">
                            <template
                              v-if="
                                checkAvailableShipping(
                                  product.bagmetaproduct.product.shipping
                                ) == 'unavailable'
                              "
                            >
                              <div class="_bag_warn">
                                Not available at your delivery location.
                              </div>
                            </template>
                          </template>
                        </div>
                        <div class="_bag_p_wrap">
                          <div v-if="product.coupon" class="_bag_p">
                            {{ symbol
                            }}{{
                              localPrice(
                                product.bagmetaproduct.price,
                                product.bagmetaproduct.currency
                              )
                            }}
                            <div>
                              <span>-</span> {{ symbol }}{{ couponDiscount(product) }}
                            </div>
                          </div>
                          <div v-else class="_bag_p">
                            {{ symbol }}
                            {{
                              localPrice(
                                product.bagmetaproduct.price,
                                product.bagmetaproduct.currency
                              )
                            }}
                          </div>
                          <div class="flex-box">
                            <button
                              class="_bag_i_btn"
                              @click.prevent="decreaseCounter($event, i, index)"
                              :disabled="product.quantity <= 1"
                            >
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
                                class="feather feather-minus"
                              >
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                              </svg>
                            </button>
                            <strong class="_bag_i_count"> {{ product.quantity }}</strong>
                            <button
                              :disabled="
                                product.quantity >= product.bagmetaproduct.available
                              "
                              class="_bag_i_btn"
                              @click.prevent="increaseCounter($event, i, index)"
                            >
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
                                class="feather feather-plus"
                              >
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                              </svg>
                            </button>
                          </div>
                        </div>
                      </div>
                      <!-- <div>
                      <span>Dispatch in 6 Days</span>
                    </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </div>

          <div class="mt-m mb">
            <button class="_bag_cpn_btn" @click.prevent="ihavecoupon = !ihavecoupon">
              I have coupon.
            </button>
          </div>
        </div>
      </div>
      <div class="_bag_right">
        <div class="_bag_summery">
          <div class="_bag_summery_card">
            <h2 class="mbl-hide" style="margin-bottom: 30px">Summary</h2>
            <div class="_bag_p_c">
              <div class="_bag_amt">
                <div class="_bag_amt_cap">Subtotal</div>
                <div>{{ symbol }}{{ subtotal() }}</div>
              </div>
              <div class="_bag_amt">
                <div class="_bag_amt_cap">Shipping</div>
                <div>{{ symbol }}{{ shipping() }}</div>
              </div>
            </div>
            <div class="flex-box _bag_pay_total">
              <div class="_bag_amt _bag_vv">
                <div class="_bag_amt_cap">Total({{ currency }})</div>
                <div class="_bag_amt_t">{{ symbol }}{{ totalCost() }}</div>
              </div>
              <div>
                <button
                  :disabled="isLoading"
                  @click="payWithKhalti"
                  class="khalti_btn btn-normalize _clear_k_b"
                >
                  <img
                    v-if="!isLoading"
                    class="_bag_pay_btn _bag_khalti"
                    :src="$siteURL + '/assets/v1khalti.svg'"
                    alt=""
                  />
                  <svg
                    v-if="isLoading"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-loader"
                  >
                    <line x1="12" y1="2" x2="12" y2="6"></line>
                    <line x1="12" y1="18" x2="12" y2="22"></line>
                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                    <line x1="2" y1="12" x2="6" y2="12"></line>
                    <line x1="18" y1="12" x2="22" y2="12"></line>
                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                  </svg>
                  <span v-if="!isLoading">Pay with Khalti</span>
                  <span v-else>Paying....</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="flex-box _bag">
      <div class="_bag_left _MBL_overlap">
        <h1>Your bag is empty</h1>
        <p>Looking for something?</p>
      </div>
    </div>
  </div>
</template>
<script>
import _, { debounce, forEach } from "lodash";
import axios from "axios";
import BackButton from "./BackButton.vue";
import EventBus from "../eventBus";
export default {
  props: ["products", "currency", "symbol", "userid"],
  components: {
    BackButton,
  },
  data() {
    var self = this;
    return {
      overlay: false,
      items: this.products,
      changeDialog: false,
      exchangeRates: [],
      total: 100,
      costWithShipping: 0,
      addresses: [],
      currentAddress: 0,
      addAddressDialog: false,
      address: {
        city: "",
        state: "",
        country: "NP",
        street: "",
        postal: "",
        apt: "",
        name: "",
        phone: "",
      },
      voucher: null,
      couponApply: false,
      invalidCoupon: false,
      isValidCoupon: false,
      isValidPostal: true,
      isValidCity: true,
      isValidCountry: true,
      isValidName: true,
      isValidStreet: true,
      isValidState: true,
      countries: [],
      saveCurrency: "NPR",
      ihavecoupon: false,
      isLoading: false,
      config: {
        // replace this key with yours
        publicKey: "test_public_key_b4e6e360329b4c1685dcee51f8aa83ff",
        productIdentity: "bag",
        productName: "this.parlor.title",
        productUrl: window.location.href,
        eventHandler: {
          onSuccess(payload) {
            // hit merchant api for initiating verfication
            console.log(payload);
            self.purchase(payload.token);
          },
          // onError handler is optional
          onError(error) {
            // handle errors
            console.log(error);
          },
          onClose() {
            console.log("widget is closing");
          },
        },
        paymentPreference: ["KHALTI", "MOBILE_BANKING", "CONNECT_IPS", "SCT"],
      },
    };
  },
  computed: {
    validAddress: function () {
      if (
        this.address.country != "" &&
        this.address.city != "" &&
        this.address.state != "" &&
        this.address.street != ""
      ) {
        return true;
      }
      return false;
    },
    canSaveSelected() {
      if (this.defaultAddress[0].id != this.currentAddress) {
        console.log("fuck" + this.defaultAddress[0].id + " - " + this.currentAddress);
        return true;
      }
      return false;
    },
    defaultAddress: function () {
      return this.addresses.filter((adr) => adr.selected == 1);
    },
  },
  methods: {
    clearInvalidCoupon() {
      this.invalidCoupon = false;
      this.isValidCoupon = true;
    },
    couponDiscount(c) {
      if (c.coupon.type == "Fixed") {
        return this.localPrice(c.coupon.amount_off, c.coupon.currency);
      } else if (c.coupon.type == "Percentage") {
        var p = (c.bagmetaproduct.price / 100) * c.coupon.percent_off;
        return this.localPrice(p, c.coupon.currency);
      }
    },
    totalDiscounts() {
      var t = 0;
      Object.values(this.items).forEach((e) => {
        Object.values(e).forEach((i) => {
          if (i.coupon) {
            t = t + this.couponDiscount(i);
          }
        });
      });
      return t;
    },
    addAddress() {
      this.addAddressDialog = true;
      this.changeDialog = false;
      this.overlay = true;
      this.disableScroll();
    },
    saveAddress() {
      axios
        .post(this.$siteURL + "/deliveryaddress/store", this.address)
        .then((result) => {
          this.addresses.forEach((a) => {
            a.selected = 0;
          });
          this.currentAddress = result.data.id;
          this.addresses.push(result.data);
          this.addAddressDialog = false;
          this.changeDialog = false;
          this.overlay = false;
          this.enableScroll();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    cancleAddress() {
      this.addAddressDialog = false;
      this.changeDialog = false;
      this.overlay = false;
      this.enableScroll();
    },
    increaseCounter(e, c, d) {
      if (this.items[c][d].quantity < this.items[c][d].bagmetaproduct.available) {
        this.items[c][d].quantity++;
      }
      this.updateQuantity(e, c, d);
    },
    decreaseCounter(e, c, d) {
      this.items[c][d].quantity--;
      this.updateQuantity(e, c, d);
    },
    removeItem(e, store, index, item) {
      axios
        .delete(this.$siteURL + "/bag/remove/" + item)
        .then((res) => {
          this.products[store].splice(index, 1);
          EventBus.$emit("BAGRREMOVE", true);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    changeAddress() {
      this.changeDialog = true;
      this.overlay = true;
      this.disableScroll();
    },

    saveSelectedAddress() {
      console.log(this.currentAddress);
      let selectData = new FormData();
      selectData.append("deliveryAddressId", this.currentAddress);
      selectData.append("previousDeliveryAddressId", this.defaultAddress[0].id);
      axios
        .post(this.$siteURL + "/address/shipping/select", selectData)
        .then((res) => {
          this.overlay = false;
          this.changeDialog = false;
          this.addresses.forEach((e) => {
            if (e.id == this.currentAddress) {
              e.selected = 1;
            } else {
              e.selected = null;
            }
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    closeChange() {
      this.changeDialog = false;
      this.overlay = false;
      this.enableScroll();
    },
    validateAddress: _.debounce(function (e) {
      if (this.description.length > 6 && this.description.length < 500) {
        this.isValidDescription = true;
        this.enableSave = false;
      } else {
        this.isValidDescription = false;
      }
    }, 100),
    updateQuantity: _.debounce(function (e, ar, indx) {
      console.log(ar, indx);
      console.log(this.items[ar][indx]);
      let bagData = new FormData();
      bagData.append("id", this.items[ar][indx].id);
      bagData.append("quantity", this.items[ar][indx].quantity);
      axios
        .post(this.$siteURL + "/bag/update", bagData)
        .then((res) => {
          console.log(res);
        })
        .catch((error) => {
          console.log(error);
        });
    }, 1000),
    localPrice(amount, from) {
      if (from == this.currency) {
        return amount;
      } else {
        return (
          (amount * this.exchangeRates[this.currency]) /
          this.exchangeRates[from]
        ).toFixed(2);
      }
    },
    checkBagStatus() {
      var ship;
      var status = "ok";
      Object.values(this.items).forEach((e) => {
        Object.values(e).forEach((i) => {
          // console.log(i.bagmetaproduct.product.shipping);

          ship = this.checkAvailableShipping(i.bagmetaproduct.product.shipping);
          if (ship == "unavailable") {
            status = "unavailable";
            this.$toast.error("Delivery not available for some item!", {
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
          if (i.bagmetaproduct.availability == "SoldOut") {
            status = "SoldOut";
            this.$toast.error("Remove soldout items!", {
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
        });
      });
      return status;
    },
    showLoginMessage() {
      this.$toast.error("Please login to checkout.", {
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
    },
    provideDeliveryMessage() {
      this.$toast.error("Please provide your delivery details.", {
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
    },
    payWithKhalti() {
      if (this.userid == 0) {
        this.showLoginMessage();
        return;
      }

      if (this.defaultAddress.length == 0) {
        this.provideDeliveryMessage();
        return;
      }

      if (this.checkBagStatus() != "ok") {
        return;
      }

      this.gateway = "Khalti";

      let checkout = new KhaltiCheckout(this.config);

      var from = this.currency;
      // console.log(from, this.currency);
      this.saveCurrency = "NPR";
      if (from == "NPR") {
        this.total = this.costWithShipping;
      } else {
        console.log("amount: " + this.costWithShipping + "currency: " + this.currency);
        if (this)
          this.total = parseFloat(
            (this.costWithShipping * this.exchangeRates["NPR"]) /
              this.exchangeRates[this.currency]
          ).toFixed(2);
      }

      // verify purchase
      let purchaseData = new FormData();
      purchaseData.append("address", this.currentAddress);
      purchaseData.append("totalAmount", this.total);
      axios
        .post(this.$siteURL + "/bag/verify", purchaseData)
        .then((res) => {
          console.log(res.data.total);
          var verifiedTotal = parseFloat(
            (res.data.total * this.exchangeRates["NPR"]) /
              this.exchangeRates[this.currency]
          ).toFixed(2);
          console.log("verified:" + verifiedTotal);
          console.log("sent:" + this.total);
          if (verifiedTotal == this.total) {
            checkout.show({
              amount: parseInt(100 * this.total),
            });
          } else {
            this.$toast.error("Your data is not matching with our!", {
              position: "top-center",
              timeout: 2000,
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
          }
        })
        .catch((err) => {
          if (err.response.status == 429) {
            this.$toast.error("Coupon expired! Please remove product from bag.", {
              position: "top-center",
              timeout: 2000,
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
          }
        });
    },

    showFailed() {
      this.$toast.error("Please login to checkout.", {
        position: "top-center",
        timeout: 2000,
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
    },

    subtotal() {
      // var self = this;
      var total = 0;
      var local = 0;

      Object.values(this.items).forEach((obj) => {
        // console.log(obj);
        obj.forEach((e) => {
          // console.log(e);
          total =
            parseFloat(total) +
            parseFloat(
              this.localPrice(
                e.bagmetaproduct.price * e.quantity,
                e.bagmetaproduct.currency
              )
            );
          // console.log(this.localPrice(e.bagmetaproduct.price, e.bagmetaproduct.currency));
        });
      });
      return total.toFixed(2);
    },

    shipping() {
      var total = 0;
      var c = 0;
      var second = 0;
      if (this.defaultAddress.length > 0) {
        Object.values(this.items).forEach((e) => {
          e.forEach((p) => {
            // console.log(p.quantity);
            // console.log(p.bagmetaproduct.product.shipping);
            c = 0;
            second = 0;
            if (p.bagmetaproduct.product.shipping) {
              total =
                total +
                parseFloat(
                  this.individualShippingCost(
                    p.bagmetaproduct.product.shipping,
                    this.defaultAddress[0],
                    p.quantity
                  )
                );
            }
            total = parseFloat(total) + c + second;
          });
        });
      }
      return total.toFixed(2);
    },

    individualShippingCost(ship, address, quantity) {
      var second = 0;
      var c = 0;
      var checked = false;
      if (ship) {
        Object.values(ship).forEach((s) => {
          if (
            s.country == address.country &&
            s.city.toLowerCase() == address.city.toLowerCase()
          ) {
            if (quantity > 1) {
              second =
                (quantity - 1) * parseFloat(this.localPrice(s.additional, s.currency));
            }
            c = parseFloat(this.localPrice(s.primary, s.currency)) + second;
            checked = true;
            return c;
          }
        });

        if (c == 0 && !checked) {
          Object.values(ship).forEach((s) => {
            if (s.country == address.country && s.city.toLowerCase() == "everywhere") {
              if (quantity > 1) {
                second =
                  (quantity - 1) * parseFloat(this.localPrice(s.additional, s.currency));
              }
              c = parseFloat(this.localPrice(s.primary, s.currency)) + second;
              checked = true;
              return c;
            }
          });
        }
        if (c == 0 && !checked) {
          Object.values(ship).forEach((s) => {
            if (s.country == "EVR") {
              if (quantity > 1) {
                second =
                  (quantity - 1) * parseFloat(this.localPrice(s.additional, s.currency));
              }
              c = parseFloat(this.localPrice(s.primary, s.currency)) + second;
              return c;
            }
          });
        }
        return c;
      }
    },

    totalCost() {
      console.log("Total Discount" + this.totalDiscounts());
      var t =
        parseFloat(this.subtotal()) + parseFloat(this.shipping()) - this.totalDiscounts();
      this.costWithShipping = t;
      return t.toFixed(2);
    },

    disableScroll() {
      let body = document.querySelector("body");
      body.className = "noscroll";
    },
    enableScroll() {
      let body = document.querySelector("body");
      body.classList.remove("noscroll");
    },
    checkAvailableShipping(shipping) {
      var a = "unavailable";
      // return a;
      Object.values(shipping).forEach((s) => {
        if (s.country == "EVR") {
          a = "available";
        } else if (this.defaultAddress.length > 0) {
          if (s.country == this.defaultAddress[0].country) {
            if (s.city == "everywhere") {
              a = "available";
            } else {
              if (s.city == this.defaultAddress[0].city) {
                a = "available";
              }
            }
          }
        }
      });
      return a;
    },
    applyCoupon() {
      let coupon = new FormData();
      coupon.append("code", this.voucher);

      axios
        .post(this.$siteURL + "/coupon/apply", coupon)
        .then((res) => {
          // console.log(res);

          // console.log(
          //   Object.values(this.items).filter((item) => item.id == res.data.item)
          // );

          var std;
          var ind = null;

          Object.keys(this.items).forEach((e) => {
            // key
            std = e;
            console.log("KEY: " + std);

            ind = Object.values(this.items[std]).findIndex(
              (item) => item.id == res.data.item
            );

            if (ind != null) {
              this.items[std][ind].coupon = res.data.coupon;
              return;
            }
          });

          this.$toast.success("Successfully applied token", {
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
          this.ihavecoupon = false;
        })
        .catch((err) => {
          this.invalidCoupon = true;
          this.isValidCoupon = false;
          console.log(err);
        });
    },
    goBack() {
      window.history.back();
    },
    purchase(token) {
      let purchaseData = new FormData();
      purchaseData.append("method", this.gateway);
      purchaseData.append("address", this.currentAddress);
      purchaseData.append("token", token);
      purchaseData.append("totalAmount", this.total);
      purchaseData.append("currency", this.saveCurrency);
      axios
        .post(this.$siteURL + "/bag/checkout", purchaseData)
        .then((res) => {
          this.items = [];
          this.success = true;
          this.isLoading = true;
          this.$toast.success("Successfully Booked", {
            position: "top-center",
            timeout: 5000,
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
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error("Ordering Failed", {
            position: "top-center",
            timeout: 2000,
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
    axios
      .get(this.$siteURL + "/api/v1/exchangerates")
      .then((res) => {
        this.exchangeRates = res.data;
      })
      .catch((error) => {
        colsole.log(error);
      });

    // Get all delivery address
    axios
      .get(this.$siteURL + "/get/addresses")
      .then((res) => {
        this.addresses = res.data;
        this.currentAddress = this.defaultAddress[0].id;
      })
      .catch((e) => {
        console.log(e);
      });

    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
      console.log(this.countries);
    });
  },
};
</script>
<style>
.btns {
  margin-bottom: 0px !important;
}
.invalid {
  border-color: var(--primary-color) !important;
  background-color: #ffeded !important;
}

@media only screen and (max-width: 600px) {
  ._clear_k_b {
    margin-top: 0 !important;
  }
}
</style>
