<template>
  <div class="">
    <div v-if="personalizeBox" class="Personalization">
      <div class="_SO_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_s">
            <div class="_SO_d_t">
              <h2>Personalize</h2>
            </div>
            <div class="_SO_d_b">
              <div>
                <label for="">
                  <div>
                    <span v-if="product.custom_message">{{
                      product.custom_message
                    }}</span>
                  </div>

                  <textarea
                    style="width: 100%"
                    name=""
                    id=""
                    v-model="customMessage"
                    cols="30"
                    rows="10"
                  ></textarea>
                </label>
              </div>
              <div>
                <label for="_send_image">
                  <input
                    v-model="imageCheckBox"
                    type="checkbox"
                    name=""
                    id="_send_image"
                  />
                  <span>Send image</span>
                </label>
              </div>
              <div>
                <div>
                  <p>By</p>
                </div>
              </div>
            </div>
            <div style="padding: 15px; display: flex; justify-content: space-between">
              <button
                @click.prevent="closePersonalize"
                class="btn-normalize btn-secondary"
              >
                Cancle
              </button>
              <button @click.prevent="savePersonalize" class="btn-normalize btn-third">
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <show-off-save ref="_save_" :item="product"></show-off-save>
    </div>

    <div class="list-content-grid">
      <div class="list-content-grid-left list-mobile-action">
        <div class="_LST_slide">
          <div class="_LST_flx">
            <div v-if="currentProduct" class="list-images round_c_m">
              <div class="resize_OMbl">
                <img
                  :src="`${$siteURL}/images/product/medium/${currentProduct.thumbnail}`"
                  alt=""
                />
              </div>

              <img
                v-for="(pimg, index) in JSON.parse(this.currentProduct.descriptionimage)"
                :key="index"
                :src="`${$siteURL}/images/product/medium/${pimg}`"
                alt=""
              />
            </div>
          </div>
          <figure data-init="back" class="mobileDisplay btn-back btn-tops">
            <div class="product_btn_wraps">
              <div @click="goBack" class="sticky btn-back-inside">
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
                  class="feather feather-arrow-left"
                >
                  <line x1="19" y1="12" x2="5" y2="12"></line>
                  <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
              </div>
              <div class="flex-box">
                <associate-link
                  v-if="user"
                  :owner_id="product.page_id"
                  :product_id="product.id"
                />

                <button
                  class="_SO_btn btn_Save_board"
                  v-if="!isSaved"
                  @click="$refs._save_.showBoards()"
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
                    class="_SO_unsaved"
                  >
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                  </svg>
                </button>
                <button
                  class="_SO_btn btn_Save_board"
                  v-else
                  @click="$refs._save_.unsave()"
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
                    class="_SO_saved"
                  >
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </figure>
        </div>
      </div>
      <div class="list-content-grid-right">
        <div id="bagbig">
          <div style="margin-top: 100px">
            <div class="list-meta">
              <span class="list_product_name">{{ product.name }}</span> by
              <a :href="$siteURL + '/' + product.owner.slug">{{ product.owner.name }}</a>

              <div v-if="variant[selectedVariant]">
                <article class="">
                  <h1 class="typography-headline4 list_title">
                    {{ currentProduct.title }}
                  </h1>
                </article>
              </div>
            </div>

            <div>
              <div v-if="variant[selectedVariant]">
                <template v-if="exchangeRates">
                  <div class="flex-box list_rv_count">
                    <h2 class="list_price">
                      {{ symbol }}
                      <span :class="{ _sold: !isAvailable }">
                        {{
                          convertedPrice(currentProduct.price, currentProduct.currency)
                        }}
                      </span>

                      <template v-if="currentProduct.availability == 'SoldOut'">
                        <span> Sold</span>
                      </template>
                    </h2>
                    <div
                      class="flex-box list_rv_count_counter"
                      v-if="product.reviews_count > 0"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="#888888"
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
                      <span>{{ product.ratings_count }}</span>
                      <span>({{ product.reviews_count }} reviews)</span>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
          <div>
            <div class="flex-box p_color_opt" v-if="Object.keys(this.variant).length > 1">
              <div v-for="(meta, color) in variant" :key="color" class="PD_clr_box">
                <input
                  type="radio"
                  name="identifier"
                  class="pdg-rdo-btn"
                  :id="color"
                  :value="color"
                  :style="{ borderColor: color, background: color }"
                  v-model="selectedVariant"
                  @click="chageVariation(color)"
                />
              </div>
            </div>
            <div class="_custom_select_wrap" v-if="variant[selectedVariant].length > 1">
              <select
                name="size"
                id="size"
                v-model="size"
                class="_custom_option"
                @change="changeSize(size)"
              >
                <option v-for="v in variant[selectedVariant]" :key="v.size">
                  {{ v.size }}
                </option>
              </select>
            </div>
          </div>
          <div v-if="product.customization">
            <a href="#personalize" @click.prevent="openPersonalize">Personalize</a>
          </div>
          <div class="flex-box">
            <button class="btn-primary btn-normalize _btn_Cart" @click.prevent="addToBag">
              <svg
                data-v-9e0979bc=""
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                style="margin-right: 10px"
              >
                <path
                  data-v-9e0979bc=""
                  d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"
                ></path>
                <line data-v-9e0979bc="" x1="3" y1="6" x2="21" y2="6"></line>
                <path data-v-9e0979bc="" d="M16 10a4 4 0 0 1-8 0"></path>
              </svg>
              Add to bag
            </button>
            <button
              class="_SO_btn btn_Save_board"
              v-if="!isSaved"
              @click="$refs._save_.showBoards()"
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
                class="_SO_unsaved"
              >
                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
              </svg>
            </button>
            <button class="_SO_btn btn_Save_board" v-else @click="$refs._save_.unsave()">
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
                class="_SO_saved"
              >
                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
              </svg>
            </button>
          </div>
          <associate-link
            v-if="user"
            :owner_id="product.page_id"
            :product_id="product.id"
            style="margin-top: 25px"
          />
          <div class="mt-m">
            <span>Reference: </span><span>{{ currentProduct.sku }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile ma -->
    <div v-if="Object.keys(this.variant).length > 1" class="pdt_clrs_wrap mobileDisplay">
      <div class="pdt-colors">
        <div
          v-for="(meta, color) in variant"
          :key="color"
          :style="{ borderColor: color }"
        >
          <input
            type="radio"
            name="mbl_identifier"
            :id="`mbl_${color}`"
            :value="color"
            :style="{ borderColor: color, background: color }"
            v-model="selectedVariant"
            class="pdg-rdo-btn"
            @click="chageVariation(color)"
          />
        </div>
      </div>
    </div>
    <div class="MBL_PDT mobileDisplay">
      <div v-if="variant[selectedVariant]" class="PD_crt_detail">
        <strong> {{ currentProduct.title }}</strong>
        <span class="PD_crt_price">
          {{ symbol }}
          <span :class="{ _sold: !isAvailable }">
            {{ convertedPrice(currentProduct.price, currentProduct.currency) }}
          </span>

          <template v-if="currentProduct.availability == 'SoldOut'">
            <span> Sold Out</span>
          </template>
        </span>
      </div>
      <div class="PD_crt_detail PD_crt_gap">
        <select name="_size" id="_size" v-model="size" @change="changeSize(size)">
          <option v-for="v in variant[selectedVariant]" :key="v.size">
            {{ v.size }}
          </option>
        </select>
        <button class="btn-primary btn-normalize" @click.prevent="addToBag">
          add to bag
        </button>
      </div>
    </div>
    <script v-html="jsonld" type="application/ld+json"></script>
  </div>
</template>

<script>
import axios from "axios";
import hcSticky from "../hc-sticky";
import EventBus from "../eventBus";
import AssociateLink from "./AssociateLink.vue";
import ShowOffSave from "./ShowOffSave.vue";

export default {
  props: {
    product: Object,
    variant: Object,
    user: Number,
    currency: String,
    symbol: String,
  },
  data() {
    return {
      isSaved: this.product.is_saved,
      selectedVariant: null,
      size: "m",
      personalizeBox: false,
      customMessage: null,
      imageCheckBox: false,
      currentProduct: null,
      addedMessage: false,
      exchangeRates: [],
      jsonld: {
        "@context": "https://schema.org/",
        "@type": "Product",
        name: "Executive Anvil",
        image: [
          "https://example.com/photos/1x1/photo.jpg",
          "https://example.com/photos/4x3/photo.jpg",
          "https://example.com/photos/16x9/photo.jpg",
        ],
        description:
          "Sleeker than ACME's Classic Anvil, the Executive Anvil is perfect for the business traveler looking for something to drop from a height.",
        sku: "0446310786",
        mpn: "925872",
        brand: {
          "@type": "Brand",
          name: "ACME",
        },

        aggregateRating: {
          "@type": "AggregateRating",
          ratingValue: "4.4",
          reviewCount: "89",
        },
        AggregateOffer: {
          lowPrice: "50",
          priceCurrency: "NPR",
        },
        offers: {
          "@type": "Offer",
          url: "https://example.com/anvil",
          priceCurrency: "USD",
          price: "119.99",
          priceValidUntil: "2020-11-20",
          itemCondition: "https://schema.org/UsedCondition",
          availability: "https://schema.org/InStock",
        },
      },
    };
  },
  components: {
    AssociateLink,
    ShowOffSave,
  },
  computed: {
    getSelectedProduct: function () {
      return Object.values(this.variant[this.selectedVariant]).filter(
        (v) => v.size == this.size
      );
    },
    isAvailable: function () {
      var c = Object.values(this.variant[this.selectedVariant]).filter(
        (v) => v.size == this.size
      );

      if (c && c[0].availability == "SoldOut") {
        return false;
      } else {
        return true;
      }
    },
  },
  methods: {
    closePersonalize() {
      this.personalizeBox = false;
      this.customMessage = null;
      this.imageCheckBox = false;
    },
    savePersonalize() {
      this.personalizeBox = false;
    },
    openPersonalize() {
      this.personalizeBox = true;
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
    chageVariation(v) {
      this.selectedVariant = v;
      this.size = this.variant[this.selectedVariant][0].size;

      this.currentProduct = this.getSelectedProduct[0];
    },
    changeSize(s) {
      this.size = s;
      this.currentProduct = this.getSelectedProduct[0];
    },
    goBack() {
      window.history.back();
    },
    addToBag() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const sid = urlParams.get("sid");

      let bagData = new FormData();
      bagData.append("itemID", this.getSelectedProduct[0].id);
      bagData.append("sID", sid);
      bagData.append("storeId", this.product.page_id);
      bagData.append("message", this.customMessage);

      axios
        .post(this.$siteURL + "/bag/add/item", bagData)
        .then((res) => {
          this.addedMessage = true;
          // console.log(res);
          EventBus.$emit("BAGADDED", this.currentProduct);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    load() {
      this.selectedVariant = Object.keys(this.variant)[0];

      this.size = this.variant[this.selectedVariant][0].size;

      this.currentProduct = this.variant[this.selectedVariant][0];

      this.jsonld.name = this.product.name;
      this.jsonld.description = this.product.description;
      this.jsonld.image =
        this.$siteURL + "/images/product/medium/" + this.currentProduct.thumbnail;
      this.jsonld.brand.name = this.product.owner.name;
      this.jsonld.sku = this.currentProduct.sku;
      console.log("Reviews Count:" + this.product.reviews.length);
      if (this.product.reviews.length > 0) {
        this.jsonld.review = {
          "@type": "Review",
          reviewRating: {
            "@type": "Rating",
            ratingValue: this.product.reviews[0].rating,
            bestRating: this.product.reviews[0].rating,
          },
          author: {
            "@type": "Person",
            name: this.product.reviews[0].writer.name,
          },
        };
      }
      this.jsonld.offers.url = this.$siteURL + "/list/" + this.product.slug;
      this.jsonld.offers.availability =
        "https://schema.org/" + this.currentProduct.availability;
      this.jsonld.offers.price = this.currentProduct.price;
      this.jsonld.offers.priceCurrency = this.currentProduct.currency;
      this.jsonld.AggregateOffer.lowPrice = this.currentProduct.price;
      this.jsonld.AggregateOffer.priceCurrency = this.currentProduct.currency;
    },
  },
  async mounted() {
    await this.getExchangeRates();
    await this.load();
    var stickyBag = document.getElementById("bagbig");

    new hcSticky(stickyBag, {
      stickTo: stickyBag.parentNode.parentNode.parentNode.parentNode.parentNode,
      top: 100,
      responsive: {
        1024: {
          disable: true,
        },
      },
    });

    var back = document.getElementsByClassName("btn-back");
    for (var i = 0; i < back.length; i++) {
      new hcSticky(back[i], {
        stickTo: back[i].parentNode.parentNode,
        top: 15,
      });
    }

    EventBus.$on("SAVED", (data) => {
      this.isSaved = data;
    });
  },
};
</script>
<style>
.p_color_opt {
  margin: 14px 0;
}
._save_mobile {
  display: flex;
  justify-content: center;
  border: none;
  color: var(--gray-medium-dark);
  background: var(--gray-very-light);
  height: 45px;
  width: 45px;
  border-radius: 50%;
  padding: 10px;
  box-sizing: border-box;
  margin-right: 30px;
}
._save_mobile button {
  margin: 0 !important;
  transform: translateY(-3px);
}
._save_mobile button svg {
  color: var(--gray-dark);
}
._bag_save {
  height: 60px;
  width: 60px;
  flex-shrink: 0;
  border-radius: 50%;
  padding-left: 15px;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
  border: solid 1px var(--gray-medium);
}
.PD_crt_detail {
  display: flex;
  justify-content: space-between;
}
.PD_crt_price {
  font-size: 20px;
  font-weight: 600;
  color: var(--gray-very-dark);
}
.PD_crt_gap {
  margin-top: 8px;
}
.PD_clr_box {
  height: 30px;
  width: 30px;
  padding: 4px;
}
.pdt_clrs_wrap {
  position: relative;
  top: -50px;
  height: 0;
  z-index: 900;
}
.pdt-colors {
  display: flex;
  width: 100%;
  justify-content: center;
}
.pdg-rdo-btn {
  appearance: none !important;
  border-width: 1px !important;
  border-style: solid !important;
  overflow: hidden !important;
  border-radius: 50% !important;
  vertical-align: top !important;
  outline: none !important;
  width: 28px;
  height: 28px;
}
.pdg-rdo-btn:checked {
  border-width: 7px !important;
  border-style: solid !important;
  overflow: hidden !important;
  background-color: var(--gray-very-light) !important;
  border-radius: 50% !important;
  vertical-align: top !important;
  outline: none !important;
  width: 28px;
  height: 28px;
}
.MBL_PDT {
  position: fixed;
  height: 100px;
  bottom: 0;
  width: 100%;
  padding: 10px;
  background: var(--gray-very-light);
  z-index: 1000;
  box-sizing: border-box;
}
._btn_Cart {
  height: 60px;
  border-radius: 50px;
  width: calc(100%);
  justify-content: center;
}

.btn-tops {
  width: 100% !important;
}
.product_btn_wraps {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

@media only screen and (max-width: 600px) {
  .resize_OMbl {
    width: 100vw;
    display: flex;
    flex-shrink: 0;
  }
  .resize_OMbl img {
    object-fit: cover;
  }
}
._sold {
  text-decoration: line-through;
}
</style>
