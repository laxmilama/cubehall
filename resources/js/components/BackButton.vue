<template>
  <figure class="mobileDisplay btn-back">
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
  </figure>
</template>

<script>
import hcSticky from "../hc-sticky";
export default {
  mounted() {
    var back = document.getElementsByClassName("btn-back");
    for (var i = 0; i < back.length; i++) {
      new hcSticky(back[i], {
        stickTo: back[i].parentNode.parentNode,
        top: 24,
      });
    }
  },
  methods: {
    goBack() {
      window.history.back();
    },
  },
};
</script>
