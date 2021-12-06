<template>
  <div>
    <a @click.prevent="togleMenu()" href="/shop" ref="w">Shop</a>
    <div
      v-show="isOpen"
      v-closable="{
        exclude: ['w'],
        handler: 'closeMenu',
      }"
      class="mega-menu"
    >
      <div class="container">
        <div class="mega-menu-wrapper">
          <div class="mega-menu-category">
            <div class="mega-menu-category-item">
              <div
                v-for="(sec, index) in megaData"
                :key="sec.id"
                class="_MM_right _MM_Flx"
              >
                <a
                  v-if="index == catID - 1"
                  @click.prevent="expandCategory(index)"
                  class="_MM_active _MM_item"
                  >{{ sec.name }}</a
                >
                <a class="_MM_item" v-else @click.prevent="expandCategory(sec.id)">{{
                  sec.name
                }}</a>
              </div>
              <div class="_MM_right _MM_Flx">
                <a class="_MM_item" :href="`${$siteURL}/shops`">Browse All Shops</a>
              </div>
            </div>
          </div>
          <div v-if="catID" class="mega-menu-category">
            <div class="mega-menu-sub-category-item">
              <div
                v-for="(c, index) in categories"
                :key="index"
                class="_MM_right _MM_Flx"
              >
                <a
                  href=""
                  v-if="index == subID"
                  @click.prevent="expandSubCat(index)"
                  class="_MM_active _MM_item"
                >
                  {{ c.name }}
                </a>
                <a href="" class="_MM_item" v-else @click.prevent="expandSubCat(index)">{{
                  c.name
                }}</a>
              </div>
            </div>
          </div>
          <div v-if="subID >= 0" class="mega-menu-category">
            <div class="mega-menu-sub-category-item">
              <a
                class="_MM_item"
                v-for="s in subCategories"
                :key="s.id"
                :href="`${$siteURL}/cat/` + categories[subID].slug + `/` + s.slug"
              >
                {{ s.name }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { isNumber } from "lodash";
export default {
  data() {
    return {
      isOpen: false,
      megaData: null,
      catID: 0,
      subID: 0,
      subCategories: null,
      categories: null,
    };
  },
  mounted() {
    // Load Menu
    axios
      .get(this.$siteURL + "/get/product/section/available")
      .then((res) => {
        this.megaData = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    togleMenu() {
      this.isOpen = !this.isOpen;
      if (this.isOpen) {
        this.expandCategory(1);
      }
    },
    closeMenu() {
      this.isOpen = false;
    },
    expandCategory(i) {
      if (isNumber(i)) {
        if (i) {
          this.catID = i;
          this.categories = this.megaData[i - 1].categories;
        }
        this.expandSubCat(0);
      }
      return false;
    },
    expandSubCat(i) {
      this.subID = i;
      this.subCategories = this.categories[i].subcategories;
    },
    activeCat() {
      if (this.catID == 0) {
        return true;
      }
      return false;
    },
  },
};
</script>
<style>
._MM_active {
  background: var(--bg-color);
}
._MM_active::after {
  content: "\203A";
  font-size: 24px;
}
._MM_right {
  margin-right: 5px;
}
._MM_Flx,
._MM_Flx a {
  justify-content: space-between;
  display: flex;
  width: 100%;
  align-items: center;
}
._MM_item {
  font-weight: 400 !important;
  font-size: 16px;
  padding: 10px !important;
}
._MM_item:hover {
  text-decoration: underline !important;
  cursor: pointer;
}
@media only screen and (max-width: 600px) {
  ._MM_item {
    font-size: 12px;
  }
}
</style>
