<template>
  <div class="tooltip-box">
    <slot />
    <div class="tooltip">
      <span class="text">{{ text }}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
.tooltip-box {
  position: relative;
  display: inline-block;
}

.tooltip-box:hover .tooltip {
  display: block;
}

.tooltip {
  color: var(--bg-color);
  text-align: center;
  padding: 5px 0;
  border-radius: 2px;

  width: 180px;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  padding: 10px;
  border-radius: 10px;
  display: none;
  transition: opacity 1s;

  position: absolute;
  z-index: 1;

  background: var(--secondary-color);
}

.text::after {
  content: " ";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: var(--secondary-color) transparent transparent transparent;
}
</style>
