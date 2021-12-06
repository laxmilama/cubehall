<template>
  <div style="position: relative">
    <div class="showoff-show-wrapper _MBL-addPad">
      <div
        class="showoff-show-card round_c_s"
        v-for="(showoff, index) in showoffs"
        :key="index"
      >
        <div style="position: relative">
          <div class="showoff-show">
            <div class="showof-show-content">
              <a :href="`${$siteURL}/showoff/${showoff.slug}`">
                <img
                  class="showoff-show-img"
                  :src="`${$siteURL}/images/showoff/medium/${showoff.media}`"
                  width="100%"
                />
              </a>
            </div>
          </div>
          <div class="showoff-shop-tag p-helper round_c_b">
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
              class="feather feather-tag"
            >
              <path
                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"
              ></path>
              <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            <span>View All Products</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showoffs: Array,
  },
  methods: {
    toBash(slug, type, parent) {
      var i = "item=" + slug + "&type=" + type + "&parent=" + parent;
      return btoa(i);
    },
  },
};
</script>
