<template lang="">
  <div class="price-section"> <div class="price-section-wrapper"> <div
  class="product-action"> <button v-on:click.prevent="copyLink" class="copyLink_simple">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
  stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0
  7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3
  3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>{{ message }}
  </button> </div> </div> </div>
</template>
<script>
export default {
  name: "AssociateLink",
  props: ["link"],
  data() {
    return {
      source: this.$siteURL + "/a/" + this.link,
      message: this.$siteURL + "/a/" + this.link,
    };
  },
  methods: {
    async copyLink() {
      // navigator.clipboard.writeText(this.$siteURL + "/a/" + result.data.url);
      this.$clipboard(this.source);
      var v = this;
      v.message = "Copied!";
      setTimeout(function () {
        v.message = v.source;
      }, 2000);
    },
  },
};
</script>
<style>
.copyLink_simple {
  background: none;
  display: flex;
  justify-content: center;
  border: none;
}
.copyLink_simple svg {
  margin-right: 8px;
  height: 15px;
  width: 15px;
}
.link_img_wrap {
  height: 90px;
  width: 90px;
  overflow: hidden;
}
.link_img_wrap img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}
</style>
