<template>
  <div v-show="isActive"><slot></slot></div>
</template>
<script>
export default {
  name: "Tab",
  props: {
    name: { required: true },
    selected: { default: false },
    icon: String,
  },

  data() {
    return {
      isActive: false,
    };
  },

  computed: {
    href() {
      return this.name.toLowerCase();
    },
  },

  mounted() {
    this.isActive = this.selected;
  },
  methods: {
    buttonColor() {},
  },
};
</script>
