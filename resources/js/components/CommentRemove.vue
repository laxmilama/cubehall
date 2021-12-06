<template>
  <div style="position: relative">
    <button class="cmt-rmv-btn" @click="toggleMore()">
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
        class="svg-ico-more"
      >
        <circle cx="12" cy="12" r="1"></circle>
        <circle cx="12" cy="5" r="1"></circle>
        <circle cx="12" cy="19" r="1"></circle>
      </svg>
    </button>
    <div v-show="expandMore" class="cmt-more-model">
      <a href="" @click.prevent="remove(id, index)" class="remove-tab">
        <div class="inr-rmv">
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
            class="feather feather-trash"
          >
            <polyline points="3 6 5 6 21 6"></polyline>
            <path
              d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
            ></path>
          </svg>
          Remove
        </div>
      </a>
    </div>
  </div>
</template>
<script>
export default {
  props: ["id", "index"],
  data() {
    return {
      expandMore: false,
    };
  },
  methods: {
    remove(id, index) {
      //Reomve Comment
      axios
        .delete(this.$siteURL + "/delete/comment/" + id)
        .then((res) => {
          this.$parent.remove(index);
        })
        .catch((error) => {
          //
        });
    },
    toggleMore() {
      if (this.expandMore) {
        this.expandMore = false;
      } else {
        this.expandMore = true;
      }
    },
  },
};
</script>
<style>
.cmt-rmv-btn {
  height: 30px;
  width: 35px;
  display: flex;
  position: relative;
  background: transparent;
  border: none;
  outline-style: none;
  top: 10px;
}
.svg-ico-more {
  stroke: var(--gray-dark);
}
.remove-tab {
  display: block;
  color: var(--gray-dark);
  padding: 10px;
}
.inr-rmv {
  display: flex;
  padding: 5px;
}
.inr-rmv svg {
  margin-right: 10px;
}
.cmt-more-model {
  position: absolute;
  right: 10px;
  border-radius: 10px;
  background: var(--gray-light);
  top: 43px;
  z-index: 99999;
}
</style>
