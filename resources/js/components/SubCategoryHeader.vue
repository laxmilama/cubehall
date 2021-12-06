<template>
  <div class="_Cat_tab_wrap flex-box scrollable">
    <div class="_Cat_tab round_c_s _cat_tab_itms" v-for="(item, i) in items" :key="i">
      <img
        class="_Cat_tab_img"
        :src="$siteURL + '/images/product/thumb/' + item.product.thumbnail"
        :alt="item.name"
      />
      <div class="_Cat_tab_overlay"></div>
      <span class="_Cat_tab_name">
        {{ item.name }}
      </span>
      <a class="_Cat_tab_link" :href="'/cat/' + sub + '/' + item.slug"></a>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["cid", "sub"],
  data() {
    return {
      items: null,
    };
  },
  mounted() {
    axios
      .get(this.$siteURL + "/categories/" + this.cid + "/sub")
      .then((res) => {
        this.items = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>
<style>
._Cat_tab {
  -webkit-box-align: center;
  align-items: center;
  cursor: pointer;
  display: -webkit-inline-box;
  display: inline-flex;
  font-size: calc(14px + 0.2vw);
  -webkit-box-pack: center;
  justify-content: center;
  min-height: 65px;
  min-width: 150px;
  overflow: hidden;
  position: relative;
  text-align: center;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  width: 14vw;
}
._cat_tab_itms {
  margin: 10px 5px;
}

._Cat_tab_img {
  position: absolute;
  height: 100%;
  width: 100%;
  object-fit: cover;
}
._Cat_tab_name {
  color: white;
  z-index: 2;
}
._Cat_tab_overlay {
  bottom: 0;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1;
}
._Cat_tab_link {
  bottom: 0;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  z-index: 3;
}
</style>
