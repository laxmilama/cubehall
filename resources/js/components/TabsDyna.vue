<template>
  <div>
    <ul class="tab-scopes">
      <li
        v-for="(tab, index) in tabs"
        v-bind:key="index"
        :class="{ 'is-active': tab.isActive }"
      >
        <a href="#" @click.prevent="selectTab(tab)" class="scope-filter-list">
          {{ tab.name }}
        </a>
      </li>
    </ul>
    <div class="tabs-details">
      <slot></slot>
    </div>
  </div>
</template>
<script>
export default {
  name: "DynamicTabs",
  data() {
    return { tabs: [], adr: "" };
  },

  created() {
    this.tabs = this.$children;
  },
  methods: {
    selectTab(selectedTab) {
      // console.log(selectedTab.name);
      this.tabs.forEach((tab) => {
        tab.isActive = tab.name == selectedTab.name;
      });
    },
  },
  mounted() {
    this.tabs[0].isActive = this.tabs[0].name;
    this.adr = window.location.hostname;
  },
};
</script>
<style>
.tab-scopes {
  display: flex;
  padding: 0;
  margin-bottom: 25px;
}
.tab-scopes li {
  list-style: none;
  margin-right: 20px;
  position: relative;
}
.tab-scopes a {
  color: var(--secondary-color);
  text-decoration: none;
  font-weight: 800;
}
.tab-scopes .is-active a {
  color: var(--primary-color);
}
.tab-scopes .is-active:after {
  content: "";
  width: 100%;
  height: 3px;
  background-color: var(--primary-color);
  display: block;
  position: absolute;
  bottom: -5px;
}
</style>
