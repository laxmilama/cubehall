<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div>
            <input type="text" name="header" id="header" v-model="title" />
            <button @click.prevent="addHeader">Add</button>
          </div>
          <div class="flex-box">
            <div v-for="(header, index) in headers" :key="index">
              <input type="text" v-model="headers[index]" />
            </div>
          </div>
          <div>
            <div v-for="(detail, index) in details" :key="index" class="flex-box">
              <div v-for="(field, i) in detail" :key="i">
                <input type="text" v-model="details[index][i]" />
              </div>
            </div>
          </div>
          <div>
            <button @click.prevent="addFields">+</button>
          </div>
        </div>
        <div>
          <table>
            <tr>
              <td v-for="(header, index) in headers" :key="index">
                {{ header }}
              </td>
            </tr>
            <tr v-for="(detail, index) in details" :key="index">
              <td v-for="(field, i) in detail" :key="i">
                {{ details[index][i] }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div>
      <button @click="notifyMe">Notify me!</button>
      <button @click="webPushMe">Web Push me!</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      headers: [],
      title: null,
      details: [],
      fields: [],
    };
  },
  methods: {
    addHeader() {
      this.headers.push(this.title);
    },
    addFields() {
      this.fields = [];
      this.headers.forEach((element) => {
        this.fields.push("");
      });
      this.details.push(this.fields);
    },
  },
  methods: {
    webPushMe() {
      console.log("SUCKS");
      axios.get(this.$siteURL + "/push");
    },
    notifyMe() {
      // Let's check if the browser supports notifications
      if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
      }

      // Let's check whether notification permissions have already been granted
      else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification("Hi there!");
      }

      // Otherwise, we need to ask the user for permission
      else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
          // If the user accepts, let's create a notification
          if (permission === "granted") {
            var notification = new Notification("Hi there!");
          }
        });
      }

      // At last, if the user has denied notifications, and you
      // want to be respectful there is no need to bother them any more.
    },
  },
};
</script>
