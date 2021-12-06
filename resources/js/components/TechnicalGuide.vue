<template>
  <div>
    <div v-if="isOpen">
      <div class="_bag_address_overlay"></div>
      <div class="_bag_address">
        <div class="_bag_address_wrap">
          <div class="_bag_address_card round_c_m">
            <button class="list_tech_btn_x" @click="closeGuide">
              <svg
                data-v-efc25010=""
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
                <line data-v-efc25010="" x1="18" y1="6" x2="6" y2="18"></line>
                <line data-v-efc25010="" x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
            <div class="_bag_address_cont list_tech_clear_mt">
              <div style="text-align: center">
                <h2 style="margin-top: 0">Technical guide</h2>
                <span></span>
              </div>
              <div class="">{{ guide.title }}</div>
              <div>
                <table class="list_tech_table">
                  <tr>
                    <td v-for="(header, index) in guide.headers" :key="index">
                      <strong>{{ header }}</strong>
                    </td>
                  </tr>
                  <tr v-for="(detail, index) in guide.details" :key="index">
                    <td v-for="(field, i) in detail" :key="i">
                      {{ guide.details[index][i] }}
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="_MBL-addPad" v-if="guide.details.length > 0">
      <button @click="showGuide" class="list_tech_btn">Technical Guides</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["guide"],
  data() {
    return {
      isOpen: false,
    };
  },
  methods: {
    showGuide() {
      this.isOpen = true;
    },
    closeGuide() {
      this.isOpen = false;
    },
  },
};
</script>
