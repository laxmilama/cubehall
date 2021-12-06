<template>
  <div v-if="isMobile()" class="mobile-menu flx mbl-show">
    <div class="mbl4">
      <div class="mbl4-itm">
        <a :href="`${$siteURL}`" class="mbl4-cap">
          <div class="flx-clm">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 43 43"
              fill="var(--gray-very-dark)"
              stroke="none"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="mbl4-ico"
            >
              <path
                class="cls-1"
                d="M18.94,41H3.61A3.61,3.61,0,0,1,0,37.35V21.84A5.35,5.35,0,0,1,5.34,16.5h3A5.51,5.51,0,0,1,13.8,22v4.17a1,1,0,0,0,1,1h4.12a5.51,5.51,0,0,1,5.5,5.51v2.8A5.49,5.49,0,0,1,18.94,41ZM5.34,19.12a2.73,2.73,0,0,0-2.73,2.72V37.35a1,1,0,0,0,1,1H18.94a2.88,2.88,0,0,0,2.87-2.87v-2.8a2.89,2.89,0,0,0-2.89-2.89H14.8a3.61,3.61,0,0,1-3.61-3.61V22A2.89,2.89,0,0,0,8.3,19.12Z"
              />
              <path
                class="cls-1"
                d="M30.39,41a3.32,3.32,0,0,1-1.23-.24,3.19,3.19,0,0,1-2-3V14.38a.58.58,0,0,0-.58-.58H3.24A3.19,3.19,0,0,1,1,8.35L8.39.94A3.15,3.15,0,0,1,10.65,0H37.8A3.2,3.2,0,0,1,41,3.2V30.36a3.19,3.19,0,0,1-.94,2.26L32.64,40A3.17,3.17,0,0,1,30.39,41ZM10.65,2.61a.58.58,0,0,0-.41.17L2.83,10.19a.57.57,0,0,0-.13.64.57.57,0,0,0,.54.36H26.61a3.19,3.19,0,0,1,3.19,3.19V37.76a.56.56,0,0,0,.36.54.55.55,0,0,0,.64-.12l7.41-7.41a.59.59,0,0,0,.18-.41V3.2a.59.59,0,0,0-.59-.59Z"
              />
            </svg>

            <span>Home</span>
          </div>
        </a>
      </div>
      <div class="mbl4-itm">
        <a :href="`${$siteURL}/explore`" class="mbl4-cap">
          <div class="flx-clm">
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
              class="mbl4-ico"
            >
              <circle cx="12" cy="12" r="10"></circle>
              <polygon
                points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"
              ></polygon>
            </svg>
            <span>Explore</span>
          </div>
        </a>
      </div>
      <div class="mbl4-itm" v-if="canshowoff">
        <a :href="`${$siteURL}/create/showoff`" class="mbl4-cap">
          <div class="flx-clm">
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
              class="mbl4-ico"
            >
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>create</span>
          </div>
        </a>
      </div>
      <div class="mbl4-itm">
        <a :href="`${$siteURL}/following`" class="mbl4-cap">
          <div class="flx-clm">
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
              class="mbl4-ico"
            >
              <path
                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
              ></path>
            </svg>
            <span>Following</span>
          </div>
        </a>
      </div>
      <div class="mbl4-itm">
        <a :href="`${$siteURL}/history`" class="mbl4-cap">
          <div class="flx-clm">
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
              class="mbl4-ico"
            >
              <path
                class="st0"
                d="M16.1,17.9L12,15.6l-4.1,2.4v-7.6c0-0.5,0.5-0.9,1.2-0.9h5.9c0.6,0,1.2,0.4,1.2,0.9V17.9z"
              />
              <path
                class="st0"
                d="M22,19c0,1.1-0.9,2-2,2H4c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h5l2,3h9c1.1,0,2,0.9,2,2V19z"
              />
            </svg>
            <span>History</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isMobile() {
      return true;
    },
  },
  props: ["canshowoff"],
};
</script>
<style scoped></style>
