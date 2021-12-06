<template>
  <div class="noselect">
    <div v-show="isVisible" class="slides">
      <div class="story-overlay"></div>
      <div class="slide-container round_c_m" :style="{ width: sliderWidth + 'px' }">
        <button @click="close" class="close-x round_full">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-chevron-left"
          >
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>
        <div class="bar"></div>
        <div v-if="isVisible" class="slide-wrap" :style="{ height: singleHeight + 'px' }">
          <div
            :style="{
              height: innerHeight + 'px',
              marginTop: '-' + slidesInnerMarginLeft + 'px',
            }"
            class="slides-inner"
          >
            <Slide
              ref="obj"
              v-for="slide in stories"
              :key="slide.id"
              :slide="slide"
              :reacts="reacts"
              :viewer="viewer"
              :style="{ height: singleHeight + 'px' }"
              @emitPause="emitPause"
            />
          </div>
        </div>
      </div>
    </div>
    <ul class="story-display-wrapper">
      <li
        class="story-box"
        v-for="(slide, index) in stories"
        :key="index"
        :class="{ seenStory: slide.have_seen, unSeenStory: !slide.have_seen }"
        @click="goToSlideIndex(index, slide.id)"
      >
        <img
          v-bind:src="`${$siteURL}/images/story/thumb/${slide.media}`"
          class="story-image"
        />
      </li>
    </ul>
  </div>
</template>
<script>
import Slide from "./Slide";
import EventBus from "../eventBus";

export default {
  name: "storySlider",
  props: {
    viewer: Object,
  },
  data() {
    return {
      slides: "",
      innerHeight: 0, // width of all slides
      singleHeight: 0, // width of one slide
      currentIndex: 0, // index of current slide
      isPause: true,
      percentTime: 0,
      tick: null,
      isVisible: false,
      count: 0,
      sliderWidth: 0,
      slidContainer: null,
      commentOn: false,
      itemsPerSlide: 1,
      bar: null,
      reacts: null,
    };
  },
  computed: {
    slidesInnerMarginLeft() {
      return this.currentIndex * this.singleHeight;
    },
    fiterSeenStories: function () {
      return Object.values(this.slides).filter((slide) => slide.have_seen == true);
    },
    fiterUnseenStories: function () {
      return Object.values(this.slides).filter((slide) => slide.have_seen == false);
    },
    stories: function () {
      // console.log(this.slides);
      var unseen = Object.values(this.slides).filter((slide) => slide.have_seen == false);

      var seen = Object.values(this.slides).filter((slide) => slide.have_seen == true);

      seen.forEach((e) => {
        unseen.push(e);
      });

      this.slides = unseen;

      return unseen;
    },
  },
  methods: {
    refreshSlider() {
      this.isPause = true;
      axios.get(this.$siteURL + "/get/stories").then((result) => {
        this.slides = result.data;
        this.count = this.slides.length;
      });
    },
    emitPause(e) {
      this.isPause = e;
    },
    close() {
      this.isPause = true;
      this.isVisible = false;
      this.enableScroll();
      this.refreshSlider();
    },
    goToPrev() {
      this.createBar();
      this.isPause = false;
      this.currentIndex--;
      if (this.currentIndex < 0) {
        this.currentIndex = 0;
      }
      this.seen(this.currentIndex);
    },
    goToNext() {
      this.currentIndex++;
      if (this.currentIndex === this.slides.length) {
        this.currentIndex = this.slides.length - 1;
        this.close();
        return;
      }

      this.createBar();
      this.isPause = false;

      this.seen(this.currentIndex);
    },
    goToSlideIndex(index) {
      this.createBar();
      this.currentIndex = index;
      this.seen(index);
      this.isVisible = true;
      this.isPause = false;
      this.disableScroll();
    },
    createBar() {
      if (this.isVisible) {
        this.bar = document.querySelector(".bar");
        this.bar.style.width = 0 + "%";
      }
    },
    seen(id) {
      let seenData = new FormData();
      seenData.append("seenbyId", this.viewer.id);
      seenData.append("ownerId", this.slides[id].owner.id);
      seenData.append("storyId", this.slides[id].id);
      // send watched data;
      axios
        .post(this.$siteURL + "/stories/seen", seenData)
        .then((res) => {
          // console.log(res);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    sendMessage() {
      console.log("wow");
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
  components: {
    Slide,
  },
  mounted() {
    EventBus.$on("COMMENT", (data) => {
      this.isPause = data;
      if (data == true) {
        this.commentOn = true;
      } else {
        this.commentOn = false;
      }
    });
    EventBus.$on("PAUSED", (data) => {
      this.isPause = data;
    });

    axios
      .get(this.$siteURL + "/get/reacts")
      .then((res) => {
        this.reacts = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
    this.slidContainer = document.querySelector(".slide-container");
    var time = 8;

    this.$nextTick(() => {
      let that = this;

      that.isPause = true;
      axios.get(this.$siteURL + "/stories/following").then((result) => {
        that.slides = result.data;

        // console.log(that.slides);
        that.count = that.slides.length;
      });

      start();

      that.bar = document.querySelector(".bar");

      // slide possition
      let singleHeight = window.innerHeight / this.itemsPerSlide;

      that.singleHeight = singleHeight;
      that.sliderWidth = singleHeight * (9 / 16);
      this.$set(this.$data, "singleHeight", singleHeight);
      this.$set(this.$data, "innerHeight", singleHeight * this.slides.length);

      that.slidContainer.addEventListener("swipedown", function (event) {
        if (that.commentOn == false) {
          that.goToPrev();
          moved();
        }
      });

      that.slidContainer.addEventListener("swipeup", function (event) {
        if (that.commentOn == false) {
          that.goToNext();
          moved();
        }
      });

      function interval() {
        if (that.isPause === false) {
          that.percentTime += 1 / time;
          if (that.isVisible) {
            that.bar.style.width = that.percentTime + "%";
          }
          //if percentTime is equal or greater than 100
          if (that.percentTime >= 100) {
            console.log(that.currentIndex + "and" + that.count);
            if (that.currentIndex >= that.count - 1) {
              that.isPause = true;
              return;
            }
            //slide to next item
            that.goToNext();
            moved();
          }
        }
      }

      function start() {
        that.percentTime = 0;
        that.tick = window.setInterval(interval, 10);
        that.isPause = true;
      }

      function moved() {
        clearTimeout(that.tick);
        that.percentTime = 0;
        that.tick = window.setInterval(interval, 10);
      }
    });
  },
};
</script>
<style>
.story-overlay {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.9);
}
.slides {
  z-index: 9999;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.slides-inner {
  transition: margin 0.4s ease-in-out;
}
.slide-container {
  position: absolute;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  top: 50%;
  z-index: 900;
}
@media only screen and (max-width: 600px) {
  .slide-container {
    left: 0;
    transform: translateX(0) translateY(0);
    top: 0;
    height: 100vh;
    width: 100vw !important;
  }
}
.prev {
  padding-top: -50%;
}
.slide-wrap {
  overflow: hidden;
}
.close-x {
  z-index: 500;
  position: absolute;
  display: flex;
  padding: 15px;
  background: none;
  border: none;
  color: white;
  background: rgba(0, 0, 0, 0.274);
  outline-style: none;
  cursor: pointer;
  align-items: center;
  top: 10px;
  left: 10px;
  height: 50px;
  width: 50px;
}
.m-nav {
  padding: 0 10px;
  line-height: 30px;
}

.left-right {
  padding: 0 10px;
  line-height: 26px;
}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
}
.bar {
  position: absolute;
  width: 53%;
  height: 5px;
  background: var(--gradient);
  z-index: 99999;
}

body,
html {
  margin: 0;
  padding: 0;
}
.noscroll {
  margin: 0;
  height: 100%;
  overflow: hidden;
}
.story-box {
  display: flex;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  padding: 4px;
  margin: 8px;
  cursor: pointer;
}
.seenStory {
  border: solid 2px var(--gray-medium);
}
.unSeenStory {
  border: solid 2px var(--primary-color);
}
.story-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
  overflow: hidden;
}
.story-display-wrapper {
  display: flex;
  padding: 0;
  margin: 0;
}
[data-init="story"] {
  display: flex;
  overflow: auto;
}
</style>
