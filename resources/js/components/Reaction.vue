<template>
  <div class="">
    <button
      v-if="!story.has_reacted"
      class="story-btn-rct act-btn-stry"
      @tap="sendReact(1)"
      @longtap="expandReact"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="25"
        height="25"
        viewBox="0 0 24 24"
        fill="none"
        stroke="white"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="feather feather-heart"
      >
        <path
          d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
        ></path>
      </svg>
      <label for="" class="act-lbl">{{ story.reactions_count }}</label>
    </button>
    <div v-else class="story-btn-rct act-btn-stry" @tap="Unreact">
      <span
        class="rct-ico-bg"
        v-bind:style="{
          'background-image': 'url(' + $siteURL + '/assets/' + story.has_reacted + ')',
        }"
      ></span>
      <label for="" class="act-lbl">{{ story.reactions_count }}</label>
    </div>

    <div class="reacts" v-show="showReact">
      <div
        class="rct-ico"
        v-for="react in reacts"
        :key="react.id"
        :react="react"
        @click="sendReact(react.id)"
        v-bind:style="{
          'background-image': 'url(' + $siteURL + '/assets/' + react.reaction + ')',
          animation: '3000ms steps(90) 0s infinite normal forwards running',
        }"
      ></div>
    </div>
  </div>
</template>

<script>
import EventBus from "../eventBus";
export default {
  name: "reaction",
  props: {
    story: Object,
    reacts: Array,
  },
  data() {
    return {
      showReact: false,
    };
  },
  methods: {
    sendReact(react) {
      this.story.has_reacted = this.reacts[react - 1].reaction;
      this.showReact = false;
      let reactData = new FormData();
      reactData.append("storyId", this.story.id);
      reactData.append("reaction", react);
      axios
        .post(this.$siteURL + "/post/reaction", reactData)
        .then((res) => {
          // console.log(res);
          this.story.has;
          this.closeReacts();
        })
        .catch((error) => {
          console.log(error);
        });
      this.story.reactions_count++;
    },
    Unreact() {
      this.story.has_reacted = false;
      axios
        .delete(this.$siteURL + "/story/" + this.story.id)
        .then((res) => {
          this.story.reactions_count--;
          this.story.has_reacted = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    expandReact(i) {
      this.showReact = true;
      EventBus.$emit("PAUSED", true);
    },
    closeReacts() {
      EventBus.$emit("PAUSED", false);
    },
  },
  mounted() {
    // document.addEventListener("contextmenu", (event) => event.preventDefault());
  },
};
</script>
<style>
.reacts {
  display: flex;
  position: absolute;
  background: var(--bg-color);
  top: -30px;
  padding: 10px;
  border-radius: 60px;
  left: 50%;
  transform: translateX(-50%);
}
.rct-ico {
  height: 40px;
  width: 40px;
  margin: 10px;
  background-repeat: no-repeat;
  border: none;
  outline-style: none;
  transition: all 0.2s ease-out;
}
.rct-ico:hover {
  transform: scale(2) translateY(-10px);
  background-image: url("https://192.168.1.85/assets/goodIdea-3a74afad.svg");
  animation: 3000ms steps(90) 0s infinite normal forwards running play90;
}
.reacted {
  fill: olive;
}
.story-btn-rct {
  background: none;
  border: none;
  outline-style: none;
  color: white;
  font-size: 16px;
}
.act-btn-stry {
  display: flex;
  flex-direction: row;
  align-items: center;
}
.act-lbl {
  padding: 6px;
}
.rct-ico-bg {
  width: 25px;
  height: 25px;
  background-repeat: no-repeat;
}
</style>
