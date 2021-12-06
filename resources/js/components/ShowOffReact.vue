<template>
  <div class="" style="position: relative">
    <div>
      <div class="_SO_btn" v-if="!hasReacted" @tap="sendReact(1)" @longtap="expandReact">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="25"
          height="25"
          viewBox="0 0 24 24"
          fill="none"
          stroke="black"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          style="cursor: pointer"
          class="uncreacted"
        >
          <path
            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
          ></path>
        </svg>
      </div>
      <div v-else class="_SO_btn story-btn-rct act-btn-stry" @tap="Unreact">
        <svg
          class="rct-ico-bg"
          v-bind:style="{
            'background-image': 'url(' + $siteURL + '/assets/' + hasReacted + ')',
          }"
        ></svg>
      </div>
    </div>

    <div class="_SO_reacts" v-show="showReact">
      <div
        class="rct-ico"
        v-for="react in reacts"
        :key="react.id"
        :react="react"
        @click="sendReact(react.id)"
        v-bind:style="{
          'background-image': 'url(' + $siteURL + '/assets/' + react.reaction + ')',
        }"
      ></div>
    </div>
  </div>
</template>

<style>
.uncreacted {
  stroke: var(--gray-very-dark);
}
._SO_reacts {
  display: flex;
  position: absolute;
  background: var(--bg-color);
  top: -30px;
  padding: 10px;
  border-radius: 60px;
  left: 50%;
  z-index: 2000;
  transform: translateX(-50%);
  box-shadow: 1px 1px 25px #0000008a;
}
.rct-ico {
  cursor: pointer;
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
@media only screen and (max-width: 600px) {
  ._SO_reacts {
    display: flex;
    position: absolute;
    background: var(--bg-color);
    top: -30px;
    padding: 10px;
    border-radius: 60px;
    left: 50%;
    transform: translateX(0);
  }
}
</style>

<script>
import EventBus from "../eventBus";
export default {
  name: "ShowoffReaction",
  props: {
    item: Object,
  },
  data() {
    return {
      showReact: false,
      reacts: null,
      showReact: false,
      hasReacted: this.item.has_reacted,
    };
  },
  methods: {
    sendReact(react) {
      this.hasReacted = this.reacts[react - 1].reaction;
      console.log((this.hasReacted = this.reacts[react - 1].reaction));
      this.showReact = false;
      let reactData = new FormData();
      reactData.append("showoffId", this.item.id);
      reactData.append("reaction", react);
      axios
        .post(this.$siteURL + "/post/showoff/react", reactData)
        .then((res) => {
          console.log(res);
          this.closeReacts();
        })
        .catch((error) => {
          console.log(error);
        });
      this.item.reactions_count++;
    },
    Unreact() {
      this.hasReacted = false;
      let reactData = new FormData();
      reactData.append("showoffId", this.item.id);
      axios
        .post(this.$siteURL + "/showoff/unreact", reactData)
        .then((res) => {
          this.item.reactions_count--;
          this.hasReacted = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    expandReact() {
      this.showReact = true;
    },
    closeReacts() {
      this.showReact = false;
    },
  },
  mounted() {
    axios
      .get(this.$siteURL + "/get/reacts")
      .then((res) => {
        this.reacts = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
