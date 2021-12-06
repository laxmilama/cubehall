<template>
  <div>
    <div v-if="showBagModel" class="_BAG_wrap">
      <div class="_BAG_card round_c_m">
        <div class="_BAG_head">
          <div class="flex-box">
            <button @click="close" class="_BAG_btn_close round_full">
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
                class="feather feather-x"
              >
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
            <div>
              <h2 style="margin: 0px">Added to your bag</h2>
            </div>
          </div>
        </div>
        <div v-if="product" class="_BAG_body">
          <div class="flex-box">
            <div class="_bag_thumb round_c_s">
              <img
                class="_bag_img"
                :src="`${$siteURL}/images/product/thumb/${product.thumbnail}`"
              />
            </div>
            <div>
              <h3>
                {{ product.product.name }}
              </h3>
              <span>{{ product.title }}</span>
              <div>
                <span>Size: {{ product.size }}</span>
              </div>
            </div>
          </div>
          <div class="mt-m">
            <a class="btn-normalize _btn_Cart btn-primary" :href="$siteURL + '/bag'"
              >Check your bag</a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from "../eventBus";
export default {
  data() {
    return {
      product: null,
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
      this.product = data;
      this.showBagModel = true;
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
    z-index: 9999;
    background: rgba(0, 0, 0, 0.6);
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
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
@media only screen and (max-width: 600px) {
  ._BAG {
    &_card {
      width: 90%;
    }
  }
}
</style>
