<template lang="">
  <div class=""> <div class="price-section-wrapper"> <div class="product-action"> <button
  v-on:click.prevent="createLink" class="copyLink as_mobile btn-normalize bag-btn bag">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
  stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0
  7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3
  3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg><span>{{ message }}</span> </button>
  </div> </div></div>
</template>
<script>
export default {
  name: "AssociateLink",
  props: ["owner_id", "product_id"],
  data() {
    return {
      listid: this.product_id,
      owner: this.owner_id,
      message: "Copy link",
    };
  },
  methods: {
    async createLink() {
      let associateData = new FormData();
      associateData.append("listid", this.listid);
      associateData.append("ownerid", this.owner);
      axios.post(this.$siteURL + "/post/associate", associateData).then((result) => {
        // navigator.clipboard.writeText(this.$siteURL + "/a/" + result.data.url);
        this.$clipboard(this.$siteURL + "/a/" + result.data.url);
        var v = this;
        this.$toast.success("Associate created successfully!", {
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
        v.message = "Copied!";
        v.showModel = true;
        setTimeout(function () {
          v.message = "Copy link";
        }, 500);
      });
    },
  },
};
</script>
<style>
.copyLink {
  background: none;
  display: flex;
  justify-content: center;
  border: solid 1px var(--gray-medium);
  color: var(--gray-medium-dark);
  background: var(--gray-very-light);
}
.copyLink svg {
  margin-right: 8px;
}
@media only screen and (max-width: 600px) {
  .as_mobile span {
    display: none;
  }
  .as_mobile {
    height: 45px !important;
    width: 45px !important;
    padding: 0px;
    margin-right: 15px;
  }
  .copyLink svg {
    margin-right: 0px;
  }
  .copyLink {
    border: none;
    color: var(--gray-dark);
  }
}
</style>
