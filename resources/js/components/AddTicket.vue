<template>
  <div>
    <div v-if="parlor.status == 1">
      <button @click.prevent="openDialog" class="btn-normalize btn-gdnt">
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
    <div v-if="dialogBox" class="TCT_wrapper TCT_create">
      <div class="TCT_container">
        <div>
          <div>
            <h1>Create New Ticket</h1>
          </div>
          <div>
            <div class="TCT_input">
              <label for="price" class="TCT_input_field">
                <div>
                  <span>Price</span>
                </div>
                <div>
                  <input type="number" name="price" id="price" v-model="price" />
                </div>
              </label>
              <label for="currency" class="TCT_input_field">
                <div>
                  <span>Currency</span>
                </div>
                <div>
                  <select name="currency" id="currency" v-model="currency">
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
                  <select name="guest" id="guest" v-model="guest">
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
                  <input type="number" name="duration" id="duration" v-model="duration" />
                </div>
              </label>
            </div>
            <div class="TCT_input">
              <label for="date" class="TCT_input_field">
                <div>
                  <span>Date</span>
                </div>
                <div>
                  <input type="datetime-local" name="" id="" v-model="time" />
                </div>
                {{ convertToISO(time) }}
                <div>
                  <!-- {{ convertUTCToLocal(convertToISO(time)) }} -->
                </div>
              </label>
            </div>
            <div class="TCT_input">
              <label for="ticket" class="TCT_input_field">
                <div>
                  <span>Zoom meeting information</span>
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
                    ></textarea>
                  </div>
                </div>
              </label>
            </div>
          </div>
        </div>
        <div>
          <div class="flex-box TCT_btns">
            <button class="btn-normalize TCT_cancle_btn" @click.prevent="closeDialog">
              Cancle
            </button>
            <button class="btn-normalize btn-primary" @click.prevent="createTicket">
              Create
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
export default {
  data() {
    return {
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
  components: {
    VueCtkDateTimePicker,
  },
  mounted() {
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "dark") {
      this.darkMode = true;
    } else {
      this.darkMode = false;
    }
    this.getExchangeRates();
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
    openDialog() {
      this.dialogBox = true;
    },
    closeDialog() {
      this.dialogBox = false;
      this.time = null;
      this.ticket = "";
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

    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("MMMM Do YYYY, h:mm:ss a");
    },
    convertLocalToUTC(dt, dtFormat) {
      return moment(dt, dtFormat).utc().format("YYYY-MM-DD hh:mm:ss a");
    },
  },
  computed: {
    minimumDate: function () {
      return moment().add(2, "days").format("YYYY-MM-DD");
    },
    maximumDate: function () {
      return moment().add(45, "days").format("YYYY-MM-DD");
    },
  },
};
</script>
<style>
.TCT_wrapper {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.warn_box {
  display: flex;
  background: var(--gray-light);
  padding: 15px;
  align-items: center;
  width: max-content;
  margin: 0 auto;
}
.TCT_create {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(0, 0, 0, 0.8);
  z-index: 999;
}
.TCT_container {
  background: var(--bg-color);
  padding: 30px;
  box-sizing: border-box;
  width: 500px;
  position: relative;
  height: max-content;
  border-radius: 24px;
}
.TCT_input {
  width: 100%;
  display: flex;
  justify-content: space-between;
  margin-top: 25px;
  margin-bottom: 25px;
}
.TCT_input_field {
  width: 100%;
}
.TCT_btns {
  justify-content: space-between;
}
.TCT_cancle_btn {
  border: none;
}

@media screen and (max-width: 600px) {
  .TCT_container {
    padding: 24px;
    width: 100%;
    position: relative;
    height: 100%;
    border-radius: 0;
  }
}
</style>
