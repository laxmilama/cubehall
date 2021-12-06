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
          <strong>{{ localDay(t.ticket.time) }}</strong>
          <div>
            <span>{{ localTime(t.ticket.time) }}</span> -
            <span>{{ endTime(t.ticket.time, t.ticket.duration) }}</span>
            <div>
              Hosted <span> {{ humanizeTime(t.ticket.time) }} ago</span>
            </div>
          </div>
        </div>
        <div>
          {{ t.ticket.parlor.title }}
        </div>
        <div v-if="t.attended_at">
          <div v-if="t.review == null">
            <ratting-parlor
              :grade="0"
              :maxStars="5"
              :hasCounter="1"
              :booked="t"
            ></ratting-parlor>
          </div>
          <div v-else>
            <h3>Reviewed</h3>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <span>
        You don’t have any past tickets yet—but when you do, you’ll find them here.
      </span>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import momenttimezone from "moment-timezone";
import RattingParlor from "./RattingParlor.vue";
export default {
  props: {
    ticket: Array,
  },
  components: {
    RattingParlor,
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
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

    reviewDialog(id) {
      console.log(id);
    },
  },
};
</script>
