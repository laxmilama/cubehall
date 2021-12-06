<template>
  <div style="margin-left: 15px">
    <a
      ref="c"
      class="btn-secondary btn-normalize create-btn"
      href=""
      @click.prevent="togleMenu()"
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
      <span class="hide600"> Create </span>
    </a>
    <div
      v-show="isOpen"
      v-closable="{
        exclude: ['c'],
        handler: 'closeMenu',
      }"
      class="user-dropdown round_c_s"
    >
      <ul class="user-drop-card">
        <li class="round_c_s">
          <a class="droplist" v-bind:href="list"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="admin-icon"
            >
              <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
              <polyline points="2 17 12 22 22 17"></polyline>
              <polyline points="2 12 12 17 22 12"></polyline></svg
            >Add new Listing</a
          >
        </li>
        <li class="round_c_s">
          <a class="droplist" v-bind:href="parlor"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="admin-icon"
            >
              <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
              <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
              <line x1="6" y1="1" x2="6" y2="4"></line>
              <line x1="10" y1="1" x2="10" y2="4"></line>
              <line x1="14" y1="1" x2="14" y2="4"></line></svg
            >Add new Parlor</a
          >
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isOpen: false,
    };
  },
  props: ["list", "parlor"],
  methods: {
    togleMenu() {
      this.isOpen = !this.isOpen;
    },
    closeMenu() {
      this.isOpen = false;
    },
  },
};
</script>
<style>
@media only screen and (max-width: 600px) {
  .hide600 {
    display: none;
  }
}
@media only screen and (max-width: 920px) and (min-width: 600px) {
  .hide600 {
    display: inline;
  }
}
</style>
