<template>
  <div class="price-section">
    <div class="books">
      <div>
        <span> <a :href="$siteURL + '/explore/parlors'"> Online activity</a></span>
        <h1>{{ parlor.title }}</h1>
        <div v-if="parlor.reviews_count > 0" class="studio-rating">
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
          <span>{{ parlor.star_count }} </span>
          <span> ({{ parlor.reviews_count }} reviews)</span>
        </div>
      </div>
      <div
        v-for="(t, index) in parlor.tickets.slice(0, 3)"
        :key="index"
        class="price-section-wrapper"
      >
        <div style="display: flex; justify-content: space-between">
          <div>
            <div>
              <strong>{{ localDay(t.time) }}</strong>
            </div>
            <div>
              <span>{{ localTime(t.time) }}</span> -
              <span>{{ endTime(t.time, t.duration) }}</span>
            </div>
          </div>
          <div style="display: flex; justify-content: end; flex-direction: column">
            <div style="display: flex; justify-content: end; margin-bottom: 10px">
              <strong>{{ symbol }}{{ localPrice(t.price, t.currency) }}</strong
              >/person
            </div>
            <div v-if="t.price == 0" class="product-action" style="justify-content: end">
              <button
                v-if="t.capacity > t.sells_count"
                class="btn-primary btn-normalize"
                @click.prevent="reserve(index)"
                :key="index"
              >
                Reserve free
              </button>
              <button v-else class="PLR_soldout btn-normalize" disabled>Sold out</button>
            </div>
            <div v-else class="product-action" style="justify-content: end">
              <button
                v-if="t.capacity > t.sells_count"
                class="btn-primary btn-normalize"
                @click.prevent="book(index)"
                :key="index"
              >
                Book this
              </button>
              <button v-else class="PLR_soldout btn-normalize" disabled>Sold out</button>
            </div>
          </div>
        </div>

        <div class="divider-bar"></div>
      </div>
      <div class="mt-s mb-s">
        <button
          v-if="availibility"
          @click.prevent="showDates"
          class="btn-primary btn-normalize PLR_date_btn"
        >
          Available dates
        </button>

        <button disabled v-else class="btn-secondary btn-normalize PLR_date_btn">
          Sold out
        </button>
      </div>
    </div>
    <div v-if="showAlldate" class="PLR_dates_wrapper">
      <div class="PLR_dates_container">
        <div class="PLR_dates_close" @click.prevent="closeDates">
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

        <div class="sm-container">
          <div class="mt flex-j">
            <div style="width: 100%">
              <h1 style="margin: 0">All dates</h1>
            </div>
            <div style="width: 100%">
              <div
                v-for="(t, index) in parlor.tickets"
                :key="index"
                class="price-section-wrapper"
              >
                <div style="display: flex; justify-content: space-between">
                  <div>
                    <div>
                      <strong>{{ localDay(t.time) }}</strong>
                    </div>
                    <div>
                      <span>{{ localTime(t.time) }}</span> -
                      <span>{{ endTime(t.time, t.duration) }}</span>
                    </div>
                  </div>
                  <div
                    style="display: flex; justify-content: end; flex-direction: column"
                  >
                    <div style="display: flex; justify-content: end; margin-bottom: 10px">
                      <strong>{{ symbol }}{{ localPrice(t.price, t.currency) }}</strong
                      >/person
                    </div>
                    <div
                      v-if="t.price == 0"
                      class="product-action"
                      style="justify-content: end"
                    >
                      <button
                        v-if="t.capacity > t.sells_count"
                        class="btn-primary btn-normalize"
                        @click.prevent="reserve(index)"
                        :key="index"
                      >
                        Reserve free
                      </button>
                      <button v-else class="PLR_soldout btn-normalize" disabled>
                        Sold out
                      </button>
                    </div>
                    <div v-else class="product-action" style="justify-content: end">
                      <button
                        v-if="t.capacity > t.sells_count"
                        class="btn-primary btn-normalize"
                        @click.prevent="book(index)"
                        :key="index"
                      >
                        Book this
                      </button>
                      <button v-else class="PLR_soldout btn-normalize" disabled>
                        Sold out
                      </button>
                    </div>
                  </div>
                </div>
                <div class="divider-bar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showBook" class="PLR_dates_wrapper">
      <div class="sm-container">
        <div class="flex-box mt">
          <div @click.prevent="closeBook">
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
          <h2 class="_PLR-confirm-pay">Confirm and pay</h2>
        </div>
        <div class="mt flex-j">
          <div style="width: 100%">
            <div>
              <h3>Date</h3>
              <div>
                <span>{{ localDay(parlor.tickets[bookedId].time) }}</span
                >, <span>{{ localTime(parlor.tickets[bookedId].time) }}</span> -
                <span>{{
                  endTime(
                    parlor.tickets[bookedId].time,
                    parlor.tickets[bookedId].duration
                  )
                }}</span>
              </div>
            </div>
            <div>
              <h3>Guest(s)</h3>
              <div>
                <select name="" id="" v-model="guest" class="_inp_admn _inp_guest">
                  <option v-for="(g, gi) in 15" :key="gi" :value="g">
                    {{ g }} guest
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div style="width: 100%">
            <div v-if="bookedId != null">
              <div class="flex-box">
                <div class="_PLR-confirm-thumb round_c_s">
                  <img :src="`${$siteURL}/images/parlor/thumb/${parlor.cover}`" alt="" />
                </div>
                <div>
                  <div>
                    <span>
                      {{ parlor.title }}
                    </span>
                  </div>
                  <div>
                    <span>{{ parlor.tickets[bookedId].duration }} min</span>
                  </div>
                  <div>
                    <div>
                      Hosted in
                      <span v-for="(l, ind) in languages" :key="ind">
                        <span v-if="ind == languages.length - 1"> and {{ l }} </span>
                        <span v-else> {{ l }}, </span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider-bar"></div>
              <div>
                <div>
                  <h2>Pricing Details</h2>
                </div>
                <div style="display: flex; justify-content: space-between">
                  <div>
                    <span>
                      {{ symbol
                      }}{{
                        localPrice(
                          parlor.tickets[bookedId].price,
                          parlor.tickets[bookedId].currency
                        )
                      }}
                    </span>
                    X
                    <span>
                      {{ guest }}
                    </span>
                  </div>
                  <div>
                    <strong>
                      {{ symbol
                      }}{{
                        localPrice(
                          parlor.tickets[bookedId].price,
                          parlor.tickets[bookedId].currency
                        ) * guest
                      }}
                    </strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="mt-m">
            <span class="typography-caption"
              >By clicking the button below, you agree to the Cancellation Policy, and the
              Guest Refund Policy.</span
            >
          </div>
          <div>
            <button
              :disabled="isLoading"
              @click.prevent="payWithKhalti"
              class="khalti_btn btn-normalize"
            >
              <img
                v-if="!isLoading"
                class="_bag_pay_btn _bag_khalti"
                :src="$siteURL + '/assets/v1khalti.svg'"
                alt=""
              />
              <span v-if="!isLoading"> Pay with khalti </span>

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
            </button>
            <install-app type="parlor"></install-app>
          </div>
        </div>
      </div>
    </div>
    <div class="PLR_mobile_act mbl-show PLR_flx">
      <div>
        <span class="PLR_price"
          >{{ symbol }}{{ localPrice(parlor.ticket.price, parlor.ticket.currency) }}</span
        >/ person
      </div>
      <button
        v-if="availibility"
        @click.prevent="showDates"
        class="btn-primary btn-normalize PLR_date_btn"
      >
        Available dates
      </button>

      <button v-else class="btn-secondary btn-normalize PLR_date_btn">Sold out</button>
    </div>
    <div v-if="success" class="PLR_dates_wrapper">
      <div class="PLR_success">
        <div class="PLR_success_container">
          <div class="PLR_dates_close" @click.prevent="closeSuccess">
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
          <div>
            <img src="" alt="" />
          </div>
          <div>
            <h1 class="">Ticket bought</h1>
            <span
              >You've bought ticket to join parlor hosted by {{ parlor.host.name }}.
              You'll recieve an email with all the information to join parlor.</span
            >

            <div class="PLR_s_detail">
              <div class="aling-left">
                <div>Parlor</div>
                <strong>
                  <strong>{{ parlor.title }}</strong>
                  <div></div>
                </strong>
              </div>
            </div>
            <div class="PLR_s_detail">
              <div class="aling-left">
                <div>Date</div>
                <strong>
                  <strong>{{ localDay(parlor.tickets[bookedId].time) }}</strong>
                  <div></div>
                </strong>
              </div>
              <div class="aling-right">
                <div>Time</div>
                <div>
                  <strong>
                    {{ localTime(parlor.tickets[bookedId].time) }}
                  </strong>
                </div>
              </div>
            </div>
            <div class="PLR_s_detail">
              <div class="aling-left">
                <div>Total Amount</div>
                <strong>
                  <strong>{{ parlor.tickets[bookedId].price }}</strong>
                  <div></div>
                </strong>
              </div>
              <div class="aling-right">
                <div>Guests</div>
                <div>
                  <strong>
                    {{ guest }}
                  </strong>
                </div>
              </div>
            </div>
          </div>
          <div>
            <a class="PLRsuccess-btn" href="">View Your Tickets</a>
          </div>
          <div>
            <install-app type="parlor"></install-app>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.khalti_btn {
  background: #5c2d91 !important;
  color: white;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px 15px;
  margin-top: 35px;
}
.khalti_btn:disabled {
  background: #ac9cbe !important;
}
._inp_admn {
  max-width: 100%;
  height: 47px;
  padding: 10px 25px;
  border-radius: 4px;
  font-size: 16px;
  border: solid 2px var(--gray-medium);
  box-sizing: border-box;
  margin: 10px 0;
}
._inp_guest {
  min-width: 200px;
}
.PLR_flx {
  display: flex;
  justify-content: space-between !important;
  padding: 15px;
  box-sizing: border-box;
}
.PLRsuccess-btn {
  width: 100%;
  padding: 15px 0;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  margin-top: 50px;
}
.PLR_mobile_act {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100vw;
  height: 80px;
  z-index: 990;
  background: var(--gray-very-light);
  display: flex;
  justify-content: center;
  align-items: center;
}
.PLR_dates_wrapper {
  position: fixed;
  height: 100%;
  width: 100%;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: var(--gray-very-light);
  z-index: 999;
}
.PLR_host {
  display: flex;
  align-items: center;
}
.PLR_host_pp {
  height: 50px;
  width: 50px;
  border-radius: 50%;
  overflow: hidden;
  margin-left: 15px;
}
.PLR_host_pp img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}
.PLR_dates_container {
  padding: 24px;
  display: block;
  box-sizing: border-box;
  height: 100%;
  overflow-y: auto;
}
.PLR_dates_close {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 24px;
  left: 24px;
  width: 50px;
  height: 50px;
  background: none;
  border-radius: 50%;
  cursor: pointer;
}
.PLR_date_btn {
  padding: 15px 30px;
  font-size: 16px;
  font-weight: 400;
}
.PLR_soldout {
  background: var(--gray-medium) !important;
  color: var(--gray-very-light) !important;
  border: none;
  padding: 10px 30px;
}
.PLR_success {
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  height: 100%;
  padding: 25px;
}
.PLR_success_container {
  width: 500px;
  text-align: center;
  margin-bottom: 60px;
}
.PLR_s_detail {
  width: 100%;
  display: flex;
  justify-content: space-between;
  margin-top: 25px;
  margin-bottom: 25px;
}
.PLR_price {
  font-weight: 800;
}
.aling-left {
  text-align: left;
}
.aling-right {
  text-align: right;
}

@media only screen and (max-width: 600px) {
  .books {
    display: none;
  }
  .PLR_success_container {
    width: 100%;
    text-align: center;
    padding: 15px;
  }
  .PLR_dates_container {
    flex-direction: column;
  }
}
</style>

<script>
import hcSticky from "../hc-sticky";
import moment from "moment";
import momenttimezone from "moment-timezone";
import { forEach } from "lodash";
import KhaltiCheckout from "khalti-checkout-web";
import InstallApp from "./InstallApp.vue";
// import currency from "../currency";
export default {
  props: {
    parlor: Object,
    userid: Number,
    currency: String,
    symbol: String,
  },
  components: {
    InstallApp,
  },
  data() {
    var self = this;
    return {
      guest: 1,
      gateway: null,
      showAlldate: false,
      showBook: false,
      bookedId: 0,
      localtimezone: null,
      success: false,
      isLoading: false,
      languages: JSON.parse(this.parlor.languages),
      exchangeRates: [],
      total: 0,
      config: {
        // replace this key with yours
        publicKey: "test_public_key_b4e6e360329b4c1685dcee51f8aa83ff",
        productIdentity: this.parlor.slug,
        productName: this.parlor.title,
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
  methods: {
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
    disableScroll() {
      let body = document.querySelector("body");
      body.className = "noscroll";
    },
    enableScroll() {
      let body = document.querySelector("body");
      body.classList.remove("noscroll");
    },
    showDates() {
      this.showAlldate = true;
      this.disableScroll();
    },
    closeSuccess() {
      this.success = false;
      this.showAlldate = false;
      this.showBook = false;
      this.enableScroll();
    },
    closeDates() {
      this.showAlldate = false;
      this.enableScroll();
    },
    book(e) {
      if (this.userid == 0) {
        this.showFailed();
        return;
      }
      this.bookedId = e;
      this.showBook = true;
    },
    reserve(e) {
      if (this.userid == 0) {
        this.showFailed();
        return;
      }
      this.bookedId = e;
      this.purchase("reserveTicket");
      console.log(e + "reserved");
    },
    closeBook() {
      this.showBook = false;
    },
    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("MMMM Do YYYY, h:mm:ss a");
    },
    localDay(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("ddd, MMM Do");
    },
    localTime(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("h:mm a");
    },
    endTime(utcDt, minutes) {
      var toDt = moment.utc(utcDt).toDate();
      return moment(toDt).add(minutes, "minutes").format("h:mm a");
    },
    payWithKhalti() {
      this.gateway = "Khalti";
      let checkout = new KhaltiCheckout(this.config);

      var from = this.parlor.tickets[this.bookedId].currency;
      // console.log(from, this.currency);
      if (from == "NPR") {
        this.total = this.parlor.tickets[this.bookedId].price;
      } else {
        this.total = this.localPrice(
          this.parlor.tickets[this.bookedId].price,
          this.parlor.tickets[this.bookedId].currency
        );
      }

      checkout.show({
        amount: 100 * this.total * this.guest,
      });
    },

    showFailed() {
      this.$toast.error("Please login to book parlor.", {
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

    purchase(token) {
      let purchaseData = new FormData();
      purchaseData.append("userID", this.userid);
      purchaseData.append("ticketID", this.parlor.tickets[this.bookedId].id);
      purchaseData.append("parlorID", this.parlor.id);
      purchaseData.append("guest", this.guest);
      purchaseData.append("method", this.gateway);
      purchaseData.append("token", token);
      purchaseData.append(
        "totalAmount",
        this.parlor.tickets[this.bookedId].price * this.guest
      );
      axios
        .post(this.$siteURL + "/parlor/ticket/book", purchaseData)
        .then((res) => {
          this.success = true;
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
          console.log(error.response.status);
          if (error.response.status == 429) {
            this.$toast.error("Reservation already exists!", {
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
          } else {
            this.$toast.error("Booking Failed", {
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

    this.getExchangeRates();
    this.localtimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    var book = document.getElementsByClassName("books");

    console.log(book[0].parentNode.parentNode.parentNode.parentNode);
    new hcSticky(book[0], {
      stickTo: book[0].parentNode.parentNode.parentNode.parentNode,
      top: 100,
    });
  },
  computed: {
    availibility: function () {
      var a = false;
      this.parlor.tickets.forEach(function (e) {
        if (e.capacity > e.sells_count) {
          a = true;
          return;
        }
      });
      return a;
    },
  },
};
</script>
