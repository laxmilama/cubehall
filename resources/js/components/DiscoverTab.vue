<template>
  <div class="noselect">
    <div v-show="isVisible" class="_SVsf">
      <div class="_bag_address_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button @click.prevent="closeDiscovery()" class="_SO_d_bx">X</button>
              <ul class="disc-scopes" id="dscope">
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
            </div>
            <div class="">
              <div class="tabs-details">
                <slot></slot>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from "../eventBus";
export default {
  name: "DynamicTabs",
  data() {
    return { isVisible: false, tabs: [], adr: "" };
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

    findCreators() {
      this.isVisible = true;
      this.disableScroll();
    },
    closeDiscovery() {
      this.isVisible = false;
      this.enableScroll();
    },
    disableScroll() {
      let body = document.querySelector("body");
      body.className = "noscroll";
    },
    enableScroll() {
      let body = document.querySelector("body");
      body.classList.remove("noscroll");
    },
  },
  mounted() {
    this.tabs[0].isActive = this.tabs[0].name;
    this.adr = window.location.hostname;

    EventBus.$on("DISCOVERTAB", (data) => {
      this.isPause = data;
      if (data == true) {
        this.isVisible = true;
      } else {
        this.isVisible = false;
      }
    });
  },
};
</script>
<style>
.disc-scopes {
  display: flex;
  justify-content: center;
  margin: 24px 0;
}
.disc-scopes li {
  list-style: none;
  margin-right: 20px;
  position: relative;
}
.disc-scopes a {
  color: var(--secondary-color);
  text-decoration: none;
  font-weight: 800;
}
.disc-scopes .is-active a {
  color: var(--primary-color);
}
.disc-scopes .is-active:after {
  content: "";
  width: 100%;
  height: 3px;
  background-color: var(--primary-color);
  display: block;
  position: absolute;
  bottom: -5px;
}
</style>
