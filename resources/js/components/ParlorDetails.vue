<template>
  <div>
    <div>
      <div class="row" style="display: inline-block">
        <div class="flex-box mt-m">
          <div class="p_an_img_wrap">
            <div
              style="height: 130px; width: 115px; top: 0; left: 0; position: absolute"
              class="round_c_s"
            >
              <img
                class="p_an_img"
                :src="`${$siteURL}/images/parlor/thumb/${parlor.cover}`"
              />
            </div>

            <a class="p_an_link" :href="`${$siteURL}/parlor/${parlor.slug}`"> </a>
          </div>
          <div class="p_an_title">
            <h2>{{ parlor.title }}</h2>
            <p>{{ truncateString(parlor.brief, 250) }}</p>
            <span style="color: var(--gray-medium-dark)">Published on </span>
            <div v-if="parlor.status == 1">
              <button @click.prevent="dialogBox = true" class="btn-normalize btn-gdnt">
                Add New ticket
              </button>
            </div>
            <div class="warn_box" v-else>
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
                class="feather feather-alert-circle"
              >
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
              <h3>You'll be able to add ticket ones its reviewed.</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="mt">
        <h2 style="margin-bottom: 15px">Upcoming</h2>
        <div class="_TCT_wrap">
          <div
            v-for="ticket in upcomingTickets"
            :key="ticket.id"
            class="_TCT_card round_c_m"
          >
            <div>
              <div>
                <!-- {{ ticket.time }} -->
                <!-- {{ convertUTCToLocal(ticket.time) }} -->
                <h5>In {{ humanizeTime(ticket.time) }}</h5>
                <strong>{{ localDay(ticket.time) }}</strong>
                <div>
                  <span>{{ localTime(ticket.time) }}</span> -
                  <span>{{ endTime(ticket.time, ticket.duration) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-show="dialogBox" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <h2 style="margin: 10px 0">Create Ticket</h2>
          </div>

          <div class="_SO_d_b">
            <div>
              <div>
                <div class="TCT_input">
                  <label for="price" class="TCT_input_field">
                    <div>
                      <span>Price</span>
                    </div>
                    <div>
                      <input
                        class="_inp_admn"
                        type="number"
                        name="price"
                        id="price"
                        v-model="price"
                      />
                    </div>
                  </label>
                  <label for="currency" class="TCT_input_field">
                    <div>
                      <span>Currency</span>
                    </div>
                    <div>
                      <select
                        name="currency"
                        class="_inp_admn"
                        id="currency"
                        v-model="currency"
                      >
                        <option v-for="(c, i) in exchangeRates" :value="i" :key="i">
                          {{ i }}
                        </option>
                      </select>
                    </div>
                  </label>
                </div>
                <div class="TCT_input">
                  <label for="guest">
                    <div>
                      <span>Maximum group size</span>
                    </div>
                    <div>
                      <select name="guest" id="guest" class="_inp_admn" v-model="guest">
                        <option v-for="i in 15" :key="i">{{ i }}</option>
                      </select>
                    </div>
                  </label>
                </div>
                <div class="TCT_input">
                  <label for="duration" class="TCT_input_field">
                    <div>
                      <span>How long will your activities take place?</span>
                    </div>
                    <div>
                      <input
                        type="number"
                        name="duration"
                        id="duration"
                        v-model="duration"
                        class="_inp_admn"
                      />
                      <span>(minutes)</span>
                    </div>
                  </label>
                </div>
                <div class="TCT_input">
                  <label for="date" class="TCT_input_field">
                    <div>
                      <span>Date</span>
                    </div>
                    <div>
                      <input
                        type="datetime-local"
                        name=""
                        class="_inp_admn"
                        id="DateInput"
                        v-model="time"
                        :min="minimumDate"
                        max="2000-01-01"
                      />
                    </div>
                  </label>
                </div>
                <div class="TCT_input">
                  <label for="ticket" class="TCT_input_field">
                    <div>
                      <span>Meeting Link</span>
                    </div>
                    <div>
                      <div>
                        <textarea
                          class="TCT_input_field"
                          name="ticket"
                          id="ticket"
                          cols="30"
                          rows="10"
                          v-model="ticket"
                          style="width: 100%"
                        ></textarea>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div style="padding: 15px">
            <div class="flex-box TCT_btns">
              <button class="btn-normalize TCT_cancle_btn" @click.prevent="closeDialog">
                Cancle
              </button>
              <button
                :disabled="!validForm"
                class="btn-normalize btn-primary form_create_btn"
                @click.prevent="createTicket"
              >
                Create
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import momenttimezone from "moment-timezone";
export default {
  data() {
    return {
      upcomingTickets: [],
      ticketData: null,
      dialogBox: false,
      time: null,
      dialogBox: false,
      darkMode: false,
      color: "#d82448",
      btnColor: "#952323",
      duration: 60,
      guest: 5,
      price: 0,
      currency: "NPR",
      ticket: "",
      exchangeRates: null,
    };
  },
  props: {
    parlor: Object,
  },
  methods: {
    convertToISO(time) {
      if (time) {
        let localTime = new Date(time);
        return localTime.toISOString();
      } else {
        return "undefined";
      }
    },
    closeDialog() {
      this.dialogBox = false;
      this.time = null;
      this.ticket = "";
    },
    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format();
    },
    localDay(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("dddd, MMM Do");
    },
    localTime(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("h:mm a");
    },
    endTime(utcDt, minutes) {
      var toDt = moment.utc(utcDt).toDate();
      return moment(toDt).add(minutes, "minutes").format("h:mm a");
    },
    humanizeTime(time) {
      var localTime = this.convertUTCToLocal(time);
      return moment(localTime).fromNow(true);
    },
    truncateString(string, limit) {
      if (string.length > limit) {
        return string.substring(0, limit) + "...";
      } else {
        return string;
      }
    },
    getExchangeRates() {
      axios
        .get(this.$siteURL + "/api/v1/exchangerates")
        .then((res) => {
          this.exchangeRates = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    createTicket() {
      let ticketData = new FormData();
      ticketData.append("time", this.convertToISO(this.time));
      ticketData.append("price", this.price);
      ticketData.append("duration", this.duration);
      ticketData.append("guest", this.guest);
      ticketData.append("ticket", this.ticket);
      ticketData.append("parlorID", this.parlor.id);
      axios
        .post(this.$siteURL + "/ticket/create", ticketData)
        .then((res) => {
          this.upcomingTickets.push(res.data);
          this.$toast.success("Ticket created successfully.", {
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
          this.closeDialog();
        })
        .catch((error) => {
          this.$toast.error("Something went wrong. Please try again", {
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
          console.log(error);
        });
    },
  },
  mounted() {
    this.getExchangeRates();
    axios
      .get(this.$siteURL + `/studio/ticket/${this.parlor.slug}/upcoming`)
      .then((res) => {
        // console.log(res);
        this.ticketData = res.data;
        Object.values(res.data.data).forEach((e) => {
          this.upcomingTickets.push(e);
        });
      })
      .catch((err) => {
        console.log(err);
      });
    document.getElementById("DateInput").min = this.minimumDate;
  },
  computed: {
    minimumDate: function () {
      return moment().add(2, "days").format("YYYY-MM-DD");
    },
    maximumDate: function () {
      return moment().add(45, "days").format("YYYY-MM-DD");
    },
    validForm: function () {
      if (
        this.convertToISO(this.time) != "undefined" &&
        this.ticket.length > 10 &&
        this.guest > 1 &&
        this.duration > 15
      ) {
        return true;
      }
      return false;
    },
  },
};
</script>
<style>
.form_create_btn:disabled {
  background: var(--gray-medium);
}
.p_an_img_wrap {
  width: 115px;
  height: 130px;
  position: relative;
  flex-shrink: 0;
}

.p_an_img {
  height: 100%;
  width: 100%;
  object-fit: cover;
  position: absolute;
  top: 0;
  left: 0;
}

.p_an_title {
  margin-left: 20px;
}

.p_an_data_chart {
  width: calc(calc(100% / 4) - 16px);
  position: relative;
  margin: 8px;
}

.p_an_details {
  display: grid;
  grid-template-columns: auto auto auto;
}

.p_an_d {
  display: flex;
  align-items: center;
}

.p_an_counter {
  margin-top: 15px;
  display: flex;
  align-items: center;
}

.p_an_value {
  padding: 5px;
  font-size: 18px;
}

.p_an_grid {
  display: flex;
  flex-wrap: wrap;
}

.p_an_link {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
}

.TCT_btns {
  justify-content: space-between;
}
.TCT_cancle_btn {
  border: none;
}
@media screen and (max-width: 600px) {
  .p_an_data_chart {
    width: calc(calc(100% / 2) - 16px);
    position: relative;
    margin: 8px;
  }
}
</style>
