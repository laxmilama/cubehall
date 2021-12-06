<template>
  <div class="slide">
    <!-- for attatchment -->
    <div v-if="attatch.has" class="attatchedIndicator">{{ attatch.type }}</div>
    <div v-if="slide.message" class="str-msg">
      <h2>Congratulations</h2>
      <span>You're all up-to-date</span>
    </div>
    <div v-if="attatch.has" v-show="open" class="sl-dtl">
      <a
        class="attatch-link"
        v-if="attatch.type == 'Parlor'"
        :href="`${$siteURL}/parlor/${slide.parlor.slug}`"
      >
        <div>
          <img
            class="att-img"
            :src="`${$siteURL}/images/parlor/thumb/${slide.parlor.cover}`"
          />
          <span class="stl_p_name0">
            {{ slide.parlor.title }}
          </span>
        </div>
      </a>
      <a
        class="attatch-link"
        v-if="attatch.type == 'Product'"
        :href="`${$siteURL}/list/${slide.product.slug}`"
      >
        <div>
          <img
            class="att-img"
            :src="`${$siteURL}/images/product/thumb/${slide.product.meta.thumbnail}`"
          />
          <span class="stl_p_name0">
            {{ slide.product.name }}
          </span>
        </div>
      </a>
    </div>
    <div class="hack" @tap="toggleShow"></div>
    <img class="story-img" :data-src="`${$siteURL}/images/story/medium/${slide.media}`" />
    <div class="story-helper-overlay"></div>
    <div class="story-helper">
      <div class="story-owner allow-int">
        <a :href="`${$siteURL}/${slide.owner.slug}`">
          <img
            class="story-profile"
            :data-src="`${$siteURL}/images/profile/thumb/${slide.owner.profile_image}`"
          />
          <p class="story-owner-details">
            <span class="story-owner-name">{{ slide.owner.name }}</span>

            <span class="story-owner-count">
              {{ slide.owner.followers_count }} followers</span
            >
          </p>
        </a>

        <follow-button :studio="slide.owner" @updateFollow="updateFollow"></follow-button>
      </div>
      <div class="story-action allow-int">
        <reaction :story="slide" :reacts="reacts"></reaction>
        <comment :story="slide" :viewer="viewer"></comment>
      </div>
    </div>
  </div>
</template>
<script>
import FollowButton from "./FollowButton";
import Reaction from "./Reaction";
import Comment from "./Comment";
import anime from "../anime";
export default {
  data() {
    return {
      open: false,
      attatch: {
        has: false,
        type: null,
      },
    };
  },
  components: {
    FollowButton,
    Reaction,
    Comment,
  },
  props: {
    slide: Object,
    reacts: Array,
    viewer: Object,
  },
  methods: {
    emitPause() {
      this.$emit("emitPause", true);
    },
    toggleShow() {
      this.open = !this.open;
      this.$emit("emitPause", this.open);
    },
    updateFollow(e) {
      console.log("emmiteeeee: " + e);
    },
  },
  mounted() {
    if (this.slide.product_id) {
      this.attatch.has = true;
      this.attatch.type = "Product";
    } else if (this.slide.parlor_id) {
      this.attatch.has = true;
      this.attatch.type = "Parlor";
    }

    const images = document.querySelectorAll("[data-src]");
    function preloadImage(img) {
      const src = img.getAttribute("data-src");
      if (!src) {
        return;
      }
      img.src = src;
    }

    const imgOptions = {};

    const imgOvserver = new IntersectionObserver((entries, imgObserver) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        } else {
          preloadImage(entry.target);
          imgObserver.unobserve(entry.target);
        }
      });
    }, imgOptions);

    images.forEach((image) => {
      imgOvserver.observe(image);
    });
  },
};
</script>
<style scoped>
.str-msg {
  position: absolute;
  background: rgba(0, 0, 0, 0.465);
  top: 50%;
  color: var(--gray-very-light);
}
.attatchedIndicator {
  z-index: 1;
  position: absolute;
  background: var(--gray-very-light);
  display: block;
  bottom: 20%;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 25px;
  padding: 10px 15px;
  font-size: 12px;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
}
.att-img {
  width: 100px;
  border-radius: 8px;
}
.story-owner {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}
.allow-int {
  pointer-events: auto;
}
.story-owner a {
  display: flex;
  color: white;
  text-decoration: none;
}
.attatch-link {
  color: var(--gray-very-dark);
  text-decoration: none;
}
.story-owner-details {
  display: flex;
  flex-direction: column;
  padding-left: 10px;
  margin: 0;
}
.story-action {
  display: flex;
  justify-content: space-evenly;
}
.stry-act-btn {
  background: transparent;
  border: none;
  outline-style: none;
  display: flex;
  flex-direction: row;
  padding: 10px;
  font-weight: 600;
  color: var(--gray-very-light);
  font-size: 16px;
}
.stry-act-btn svg {
  stroke: var(--gray-very-light);
  margin-right: 8px;
}
img {
  width: inherit;
  height: inherit;
}
.sl-dtl {
  z-index: 9999;
  position: absolute;
  background: var(--gray-very-light);
  display: block;
  top: 50%;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 16px;
  padding: 8px;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
}
.stl_p_name0 {
  padding: 10px 0;
  font-size: 12px;
}

.hack {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
.slide {
  display: block;
  position: relative;
}
.story-helper {
  position: absolute;
  width: 100%;
  bottom: 10px;
  padding: 15px;
  box-sizing: border-box;
  pointer-events: none;
}
.story-helper-overlay {
  position: absolute;
  width: 100%;
  height: 200px;
  bottom: 0;
  background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1));
  box-sizing: border-box;
  pointer-events: none;
}
.story-profile {
  height: 38px;
  width: 38px;
  border-radius: 50%;
  border: solid 2px var(--gray-very-white);
}
.story-owner-name {
  font-size: 16px;
  font-weight: 600;
}
.story-owner-count {
  font-size: 14px;
  font-weight: 400;
}
.story-img {
  object-fit: cover;
  height: 100%;
  width: 100%;
}
</style>
