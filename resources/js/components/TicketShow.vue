<template>
  <div>
    <div v-if="ticket.length > 0" class="_TCT_wrap">
      <div v-for="t in ticket" :key="t.id" class="_TCT_card round_c_m">
        <div class="_TCT_container">
          <div class="_TCT_img_holder">
            <img
              class="_TCT_img"
              :src="`${$siteURL}/images/parlor/small/${t.ticket.parlor.cover}`"
              alt=""
            />
          </div>
        </div>

        <div style="padding: 15px">
          <h3>
            {{ t.ticket.parlor.title }}
          </h3>
          <h2>{{ localDay(t.ticket.time) }}</h2>
          <strong> {{ humanizeTime(t.ticket.time) }}</strong>
          <div>
            <span>{{ localTime(t.ticket.time) }}</span> -
            <span>{{ endTime(t.ticket.time, t.ticket.duration) }}</span>
          </div>
        </div>
        <div
          v-if="t.ticket.can_attend"
          style="display: flex; justify-content: center; margin-bottom: 15px"
        >
          <button @click="attend(t.ticket.id, t.id)" class="btn-normalize btn-primary">
            Attend Now
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <span>Your tickets for the future parlor are listed here.</span>
    </div>
    <div v-if="attendBox" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <button @click.prevent="closeBox()" class="_SO_d_bx">X</button>
            <h3>Attend Parlor Now</h3>
          </div>

          <div class="_SO_d_b">
            <div>Use details bellow to attend this parlor</div>
            <div v-if="detail" style="white-space: pre; height: 500px">
              {{ detail }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import momenttimezone from "moment-timezone";
import axios from "axios";
export default {
  props: {
    ticket: Array,
  },
  computed: {
    now: function () {
      return moment();
    },
  },
  data() {
    return {
      attendBox: false,
      detail: "",
      currentTime: null,
    };
  },
  mounted() {
    setInterval(this.counter, 1);
  },
  methods: {
    counter() {
      this.currentTime = moment();
    },
    attend(i, b) {
      axios
        .get(this.$siteURL + "/get/ticket/" + i + "/" + b)
        .then((res) => {
          this.detail = res.data;
          this.attendBox = true;
        })
        .catch((err) => {
          if (err.response.status == 405) {
            this.$toast.error("Something went wrong.", {
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
    closeBox() {
      this.attendBox = false;
    },
  },
};
</script>
