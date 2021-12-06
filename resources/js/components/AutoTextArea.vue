<template>
  <div class="textarea">
    <textarea v-model="currentValue" :style="inputStyle"></textarea>
    <textarea class="shadow" v-model="currentValue" ref="shadow" tabindex="0"></textarea>
  </div>
</template>

<script>
import EventBus from "../eventBus";
export default {
  name: "AutoTextarea",
  props: {
    value: String,
  },
  data() {
    return {
      currentValue: "",
      inputHeight: "0",
    };
  },
  watch: {
    currentValue() {
      this.resize();
      this.$emit("input", this.currentValue);
    },
  },
  computed: {
    inputStyle() {
      return {
        "min-height": this.inputHeight,
      };
    },
  },
  mounted() {
    EventBus.$on("emptyComment", (data) => {
      if (data == true) {
        this.currentValue = "";
      }
    });
    this.resize();
  },
  methods: {
    resize() {
      this.inputHeight = `${this.$refs.shadow.scrollHeight}px`;
    },
  },
};
</script>

<style scoped lang="scss">
.textarea {
  width: 100%;
  color: var(--gray-very-dark);
}
.textarea {
  textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #aeaeae;
    background: var(--gray-light);
    resize: none;
    overflow: hidden;
    font-size: 16px;
    color: var(--gray-very-dark);
    &.shadow {
      max-height: 0;
      pointer-events: none;
      opacity: 0;
      margin: 0;
      visibility: hidden;
    }
  }
}
</style>
