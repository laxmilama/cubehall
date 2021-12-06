<template>
  <div class="noselect">
    <discover-tab>
      <tab name="Studio" :background="`#4b231b`">
        <studio-discovery></studio-discovery>
      </tab>
      <tab name="People" :background="`#4b231b`">
        <people-discovery></people-discovery>
      </tab>
    </discover-tab>

    <ul class="story-display-wrapper flx-clm">
      <li class="story-box unSeenStory" @click="findCreators">
        <img
          v-bind:src="`${$siteURL}/assets/303s3eb-e9be-3fb2a7-caf3df.webp`"
          class="story-image"
        />
      </li>
      <span class="_Story_caption"> Discover Creators</span>
    </ul>
  </div>
</template>

<script>
import EventBus from "../eventBus";
import DiscoverTab from "./DiscoverTab.vue";
import Tab from "./Tab";
import PeopleDiscovery from "./PeopleDiscovery.vue";
import StudioDiscovery from "./StudioDiscovery.vue";
export default {
  components: {
    DiscoverTab,
    StudioDiscovery,
    PeopleDiscovery,
    Tab,
  },
  data() {
    return {
      isVisible: true, // to open discover bar
    };
  },
  methods: {
    findCreators() {
      EventBus.$emit("DISCOVERTAB", true);
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
};
</script>
<style>
.replaceOverlay {
  background: var(--gray-very-light) !important;
}
._Story_caption {
  font-size: 14px;
  width: 100%;
  justify-content: center;
  display: flex;
  /* width: min-content; */
  text-align: center;
  padding: 2px;
}

@media only screen and (max-width: 920px) {
  ._Story_caption {
    font-size: 12px;
    width: 100%;
    justify-content: center;
    display: flex;
    /* width: min-content; */
    text-align: center;
    padding: 2px;
    margin-block: 10px;
  }
}
</style>
