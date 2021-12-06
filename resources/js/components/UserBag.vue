<template>
  <div>
    <a class="do-notify m_icos" :href="`${$siteURL}/bag`">
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
        class="feather feather-shopping-bag"
      >
        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <path d="M16 10a4 4 0 0 1-8 0"></path>
      </svg>
      <div v-if="count > 0" class="notify_counter">
        <template v-if="count < 10">
          {{ count }}
        </template>
        <template v-else> 9+ </template>
      </div>
    </a>
  </div>
</template>

<script>
import axios from "axios";
import EventBus from "../eventBus";
export default {
  data() {
    return {
      product: null,
      count: 0,
      showBagModel: false,
    };
  },
  methods: {
    gotoBag() {
      console.log("BAG");
    },
    close() {
      this.showBagModel = false;
    },
  },
  mounted() {
    EventBus.$on("BAGADDED", (data) => {
      this.count++;
      this.product = data;
      this.showBagModel = true;
    });

    EventBus.$on("BAGRREMOVE", (data) => {
      this.count--;
    });

    // Loat bag data
    axios
      .get(this.$siteURL + "/bag/items")
      .then((res) => {
        this.count = res.data;
      })
      .catch((err) => {
        console.log("ERROR");
      });
  },
};
</script>
<style lang="scss" scoped>
._BAG {
  &_btn {
    &_close {
      height: 35px;
      width: 35px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: none;
      border: none;
      margin-right: 25px;
      &:hover {
        background: var(--gray-light);
      }
    }
  }
  &_wrap {
    height: 100vh;
    width: 100vw;
    top: 0;
    left: 0;
    overflow: auto;
    padding: 0px !important;
    position: fixed !important;
    z-index: 1;
    background: rgba(0, 0, 0, 0.4);
  }
  &_card {
    background: var(--gray-very-light);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  &_head {
    padding: 15px;
  }
  &_body {
    padding: 15px;
  }
}
</style>
>
