<template>
  <div style="width: 100%">
    <div class="scope-filter">
      <ul class="scope-filter-tabs">
        <li
          class="sc-tab"
          v-for="(tab, index) in tabs"
          v-bind:key="index"
          :class="{ 'is-active': tab.isActive }"
        >
          <a
            v-if="tab.isActive"
            :href="`${$siteURL}` + '/' + studio + '/' + tab.href"
            @click.prevent="selectTab(tab)"
            class="btn-normalize scope-filter-list"
            :style="activeBtn()"
          >
            {{ tab.name }}
          </a>

          <a
            v-else
            :href="`${$siteURL}` + '/' + studio + '/' + tab.href"
            @click.prevent="selectTab(tab)"
            class="btn-normalize scope-filter-list"
          >
            {{ tab.name }}
          </a>
        </li>
      </ul>
    </div>

    <div class="tabs-details">
      <slot></slot>
    </div>
  </div>
</template>
<script>
import * as Color from "../Color";
export default {
  name: "tabs",
  props: ["studio"],
  data() {
    return {
      tabs: [],
      adr: "",
      color: "",
      back: "",
      current: null,
    };
  },
  created() {
    this.tabs = this.$children;
  },
  methods: {
    selectTab(selectedTab) {
      this.tabs.forEach((tab) => {
        tab.isActive = tab.name == selectedTab.name;
      });
    },
    activeBtn() {
      let rtstyle = getComputedStyle(document.documentElement);
      this.color = rtstyle.getPropertyValue("--brand").trim();
      let [back, txt] = Color.LightButtonColor(this.color);
      return {
        background: back,
        color: txt,
      };
    },
  },
  mounted() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const t = urlParams.get("tab");
    var c;
    if (t) {
      this.current = t.charAt(0).toUpperCase() + t.slice(1).toLowerCase();
      c = Object.values(this.tabs).filter((n) => n.name == this.current);
    }

    if (c) {
      this.tabs.forEach((tab) => {
        if (tab.name.toLowerCase() == t.toLowerCase()) {
          tab.isActive = tab.name == this.current;
        }
      });
    } else {
      this.tabs[0].isActive = this.tabs[0].name;
    }
  },
};
</script>
