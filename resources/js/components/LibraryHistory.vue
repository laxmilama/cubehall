<template>
  <div class="_H_wrp0 scrollable">
    <div v-for="(item, i) in items" :key="i" class="_HL_card">
      <div style="position: relative">
        <div class="recent-showoff-show">
          <div class="recent-show-content round_c_s">
            <a href="http://192.168.1.85/list/portrait">
              <img
                class="recent-show-img"
                :src="$siteURL + item.data.thumb"
                width="100%"
                alt="Portrait"
              />
            </a>
          </div>
        </div>
        <div>{{ truncateString(item.data.name) }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["items"],
  methods: {
    truncateString(str) {
      var num = 20;
      if (str.length > num) {
        return str.slice(0, num) + "...";
      } else {
        return str;
      }
    },
  },
};
</script>
<style>
._H_wrp0 {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
}
._HL_card {
  width: 12.5%;
  position: relative;
  flex-shrink: 0;
  margin: 12px;
}
</style>
