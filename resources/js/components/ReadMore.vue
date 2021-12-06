<template>
  <div class="mb-m">
    <p v-html="formattedString" class="_read_text" style="white-space: pre-line"></p>
    <span v-show="text.length > maxChars">
      <a
        :href="link"
        class="_readMore"
        id="readmore"
        v-show="!isReadMore"
        v-on:click="triggerReadMore($event, true)"
        >{{ moreStr }}</a
      >
      <a
        :href="link"
        class="_readMore"
        id="readmore"
        v-show="isReadMore"
        v-on:click="triggerReadMore($event, false)"
        >{{ lessStr }}</a
      >
    </span>
  </div>
</template>

<script>
export default {
  props: {
    moreStr: {
      type: String,
      default: "read more",
    },
    lessStr: {
      type: String,
      default: "",
    },
    text: {
      type: String,
      required: true,
    },
    link: {
      type: String,
      default: "#",
    },
    maxChars: {
      type: Number,
      default: 100,
    },
  },

  data() {
    return {
      isReadMore: false,
    };
  },

  computed: {
    formattedString() {
      var val_container = this.text;

      if (!this.isReadMore && this.text.length > this.maxChars) {
        val_container = val_container.substring(0, this.maxChars) + "...";
      }

      return val_container;
    },
  },

  methods: {
    triggerReadMore(e, b) {
      if (this.link == "#") {
        e.preventDefault();
      }
      if (this.lessStr !== null || this.lessStr !== "") this.isReadMore = b;
    },
  },
};
</script>
<style>
._readMore {
  text-decoration: underline;
  font-weight: 800;
  color: var(--gray-very-dark);
}
._read_text {
  line-height: 24px;
  margin: 0;
  margin-top: 20px;
}
</style>
