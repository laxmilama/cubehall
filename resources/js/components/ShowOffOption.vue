<template>
  <div>
    <div style="position: relative">
      <button @click.prevent="toggleBox()" class="show_opt_btn">
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
          class="feather feather-more-horizontal"
        >
          <circle cx="12" cy="12" r="1"></circle>
          <circle cx="19" cy="12" r="1"></circle>
          <circle cx="5" cy="12" r="1"></circle>
        </svg>
      </button>
      <div class="show_opt_box round_c_s" v-if="optionBox">
        <ul class="reset_UL">
          <li v-if="is_owner == 1" class="flex-box _opt_li" @click="deleteBox = true">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              style="margin-right: 8px"
            >
              <polyline points="3 6 5 6 21 6"></polyline>
              <path
                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
              ></path>
            </svg>
            <span> Remove </span>
          </li>
          <li class="flex-box _opt_li">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              style="margin-right: 8px"
            >
              <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
              <line x1="4" y1="22" x2="4" y2="15"></line>
            </svg>
            <span> Report </span>
          </li>
        </ul>
      </div>
    </div>
    <div v-if="deleteBox">
      <div class="_overlay">
        <div class="_show_model round_c_m">
          <div style="padding: 15px">
            <h2>Permanently delete?</h2>
            <p>This is non recoverable action.</p>
          </div>
          <div style="padding: 15px">
            <button @click="deleteBox = false">Cancle</button>
            <button @click.prevent="remove">Delete Forever</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["is_owner", "slug"],

  data() {
    return {
      optionBox: false,
      deleteBox: false,
    };
  },
  methods: {
    toggleBox() {
      this.optionBox = !this.optionBox;
    },
    remove() {
      axios
        .delete(this.$siteURL + "/showoff/delete/" + this.slug)
        .then((res) => {
          this.optionBox = false;
          this.$toast.success("ShowOff deleted successfully.", {
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
          setTimeout(function () {
            window.history.back();
          }, 2000);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style>
.show_opt_btn {
  height: 35px;
  width: 35px;
  background: transparent;
  border: none;
}
.show_opt_box {
  position: absolute;
  right: 0;
  background: var(--gray-very-light);
  border: solid 1px var(--gray-light);
}
.reset_UL {
  padding: 0;
  margin: 0;
}
._opt_li {
  padding: 8px 15px;
  list-style: none;
}
._opt_li:hover {
  cursor: pointer;
  background: var(--gray-light);
}
._overlay {
  height: 100vh;
  width: 100vw;
  top: 0;
  left: 0;
  overflow: auto;
  padding: 0px !important;
  position: fixed !important;
  z-index: 9999;
  background: rgba(0, 0, 0, 0.6);
  -webkit-backdrop-filter: blur(8px);
  backdrop-filter: blur(8px);
}
._show_model {
  position: absolute;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  top: 50%;
  max-width: 400px;
  width: 400px;
  background: var(--gray-very-light);
  height: -webkit-min-content;
  height: -moz-min-content;
  height: min-content;
  max-height: 100%;
}
</style>
