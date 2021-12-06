<template>
  <div class="noselect">
    <div v-show="isVisible" class="slides">
      <div class="story-overlay"></div>
      <div class="slide-container-d round_c_m" :style="{ width: sliderWidth + 'px' }">
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
        <div class="bar-d"></div>
        <div v-if="isVisible" class="slide-wrap" :style="{ height: singleHeight + 'px' }">
          <div
            :style="{
              height: innerHeight + 'px',
              marginTop: '-' + slidesInnerMarginLeft + 'px',
            }"
            class="slides-inner"
          >
            <Slide
              :v-bind="slides"
              ref="obj"
              v-for="slide in slides"
              :key="slide.id"
              :slide="slide"
              :reacts="reacts"
              :viewer="viewer"
              :style="{ height: singleHeight + 'px' }"
              @emitPause="emitPause"
              @updateFollow="updateFollow"
            />
          </div>
        </div>
      </div>
    </div>
    <ul class="story-display-wrapper">
      <div
        v-for="(slide, index) in slides.slice(0, 15)"
        :key="index"
        @click="goToSlideIndex(index, slide.id)"
      >
        <div
          class="story-box"
          :class="{ seenStory: slide.have_seen, unSeenStory: !slide.have_seen }"
        >
          <img
            v-bind:src="`${$siteURL}/images/story/thumb/${slide.media}`"
            class="story-image"
          />
        </div>
        <span class="_Story_caption" v-text="truncateName(slide.owner.name)"></span>
      </div>
    </ul>
  </div>
</template>
<script>
import Slide from "./Slide";
import EventBus from "../eventBus";

export default {
  name: "discover",
  props: {
    viewer: Object,
  },
  data() {
    return {
      slides: [],
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
      bar: null,
      itemsPerSlide: 1,
      thumbSlides: "",
      reacts: null,
      commentOn: false,
      page: 1,
      data: null,
    };
  },
  computed: {
    slidesInnerMarginLeft() {
      return this.currentIndex * this.singleHeight;
    },
  },
  methods: {
    emitPause(e) {
      this.isPause = e;
    },
    updateFollow(e) {
      console.log("emit" + e);
    },
    close() {
      this.isPause = true;
      this.isVisible = false;
      this.enableScroll();
      // this.refreshDiscover();
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
      this.createBar();
      this.isPause = false;
      this.currentIndex++;
      if (this.currentIndex === this.slides.length) {
        if (this.data.current_page === this.data.last_page) {
          this.close();
        }
        if (this.data) {
          if (this.data.current_page < this.data.last_page) {
            this.page = this.data.current_page + 1;
          } else {
            this.canLoadMore = false;
            return true;
          }
        } else {
          this.page = 1;
        }
        axios
          .get(this.$siteURL + "/stories/discover?page=" + this.page)
          .then((result) => {
            Object.values(result.data.data).forEach((e) => {
              this.slides.push(e);
            });
            this.data = result.data;
            this.count = this.slides.length;
          });
      }

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
        this.bar = document.querySelector(".bar-d");
        this.bar.style.width = 0 + "%";
      }
    },
    truncateName(string) {
      var n = string;
      if (string.length > 12) {
        n = string.substring(0, 12) + "..";
      }
      return n;
    },
    seen(id) {
      // console.log(this.viewerid);
      let seenData = new FormData();
      seenData.append("seenbyId", this.viewer.id);
      seenData.append("ownerId", this.slides[id].owner.id);
      seenData.append("storyId", this.slides[id].id);
      // send watched data;
      axios
        .post(this.$siteURL + "/stories/seen", seenData)
        .then((res) => {})
        .catch((error) => {
          console.log(error);
        });
    },
    disableScroll() {
      let body = document.querySelector("body");
      body.className = "noscroll";
    },
    enableScroll() {
      let body = document.querySelector("body");
      body.classList.remove("noscroll");
    },
    refreshDiscover() {
      this.isPause = true;
      this.createBar();
      // this.slides.splice(16);
      this.count = 16;
    },
  },
  components: {
    Slide,
  },
  mounted() {
    // console.log(user);
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
    this.slidContainer = document.querySelector(".slide-container-d");
    var time = 8;

    this.$nextTick(() => {
      let that = this;

      that.isPause = true;
      axios.get(this.$siteURL + "/stories/discover").then((result) => {
        // console.log(result.data.data);
        Object.values(result.data.data).forEach((e) => {
          that.slides.push(e);
        });
        that.data = result.data;

        // console.log(that.slides);
        that.count = that.slides.length;
      });

      start();

      that.bar = document.querySelector(".bar-d");

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
            // console.log(that.currentIndex + "and" + that.count);
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
.slide-container-d {
  position: absolute;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  top: 50%;
}
@media only screen and (max-width: 600px) {
  .slide-container-d {
    left: 0;
    transform: translateX(0) translateY(0);
    top: 0;
    height: 100vh;
    width: 100vw !important;
  }
}
.str-ctn {
  position: relative;
}
.d-story {
  overflow: hidden;
  position: absolute;
  border-radius: 50%;
  border: solid 2px var(--gray-very-light);
}
.d-story img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.d-story:nth-child(1) {
  height: 25px;
  width: 25px;
  z-index: -1;
  transform: translate(35px, -5px);
}
.d-story:nth-child(2) {
  height: 50px;
  width: 50px;
  transform: translate(0px, 5px);
}
.d-story:nth-child(3) {
  height: 25px;
  width: 25px;
  transform: translate(-7px, 0px);
}
.d-story:nth-child(4) {
  height: 20px;
  width: 20px;
  transform: translate(40px, 40px);
}

.bar-d {
  position: absolute;
  width: 53%;
  height: 5px;
  background: rgb(146, 27, 27);
  z-index: 99999;
}
.flx-clm {
  flex-direction: column;
}
</style>
