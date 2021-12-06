<template>
  <div style="z-index: 100">
    <a class="m_icos" href="#" @click.prevent="togleMenu()" ref="u">
      <img v-bind:src="avatar" alt="" srcset="" />
    </a>
    <div
      v-show="isOpen"
      v-closable="{
        exclude: ['u'],
        handler: 'closeMenu',
      }"
      class="user-dropdown round_c_s"
    >
      <ul class="user-drop-card">
        <li class="round_c_s">
          <a class="droplist" :href="`${$siteURL}/@` + profile">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Profile
          </a>
        </li>
        <li class="round_c_s">
          <a class="droplist" href="/orders"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline></svg
            >Orders</a
          >
        </li>
        <li class="round_c_s">
          <a class="droplist" href="/ticket">
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
              class="ico-drowdown"
            >
              <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
              <polyline points="17 2 12 7 7 2"></polyline></svg
            >Tickets</a
          >
        </li>
        <li class="round_c_s">
          <a class="droplist" :href="`${$siteURL}/@` + profile + `/board`">
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
              class="ico-drowdown"
            >
              <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg
            >Saved</a
          >
        </li>
        <li class="round_c_s">
          <a class="droplist" :href="`${$siteURL}/messages`">
            <svg
              width="24px"
              height="24px"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              class="ico-drowdown"
            >
              <path
                d="M17.2678 8.56104L13.0024 11.9953C12.1952 12.6282 11.0636 12.6282 10.2564 11.9953L5.95435 8.56104"
                stroke="#130F26"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M6.88787 3H16.3158C17.6752 3.01525 18.969 3.58993 19.896 4.5902C20.823 5.59048 21.3022 6.92903 21.222 8.29412V14.822C21.3022 16.1871 20.823 17.5256 19.896 18.5259C18.969 19.5262 17.6752 20.1009 16.3158 20.1161H6.88787C3.96796 20.1161 2 17.7407 2 14.822V8.29412C2 5.37545 3.96796 3 6.88787 3Z"
                stroke="#130F26"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>

            Messages</a
          >
        </li>
        <li v-if="studio" class="round_c_s">
          <a class="droplist" :href="`${$siteURL}/studio`">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 34 34"
              fill="var(--gray-dark)"
              stroke="none!important"
              stroke-width="0"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <title />
              <g data-name="Layer 47" id="Layer_47">
                <path
                  d="M3,11H25.88l-4.46,3.19A1,1,0,0,0,22,16a1,1,0,0,0,.58-.19l7-5h0a1,1,0,0,0,.25-.26,1.17,1.17,0,0,0,.05-.11.33.33,0,0,0,.07-.13.28.28,0,0,0,0-.09.51.51,0,0,0,0-.13.89.89,0,0,0,0-.23s0-.08,0-.12a1,1,0,0,0-.14-.3v0h0a.84.84,0,0,0-.23-.23l-7-5a1,1,0,0,0-1.16,1.62L25.88,9H3a1,1,0,0,0,0,2Z"
                />
                <path
                  d="M29,21H6.12l4.46-3.19a1,1,0,0,0-1.16-1.62l-7,5a.84.84,0,0,0-.23.23h0a0,0,0,0,0,0,0,1,1,0,0,0-.14.3s0,.08,0,.12a.89.89,0,0,0,0,.23.51.51,0,0,0,0,.13.28.28,0,0,0,0,.09.33.33,0,0,0,.07.13,1.17,1.17,0,0,0,0,.11,1,1,0,0,0,.25.26h0l7,5A1,1,0,0,0,10,28a1,1,0,0,0,.58-1.81L6.12,23H29a1,1,0,0,0,0-2Z"
                />
              </g></svg
            >Switch to Studio</a
          >
        </li>
        <li v-else class="round_c_s">
          <a class="droplist" :href="`${$siteURL}/studio/open`"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <polyline points="21 8 21 21 3 21 3 8"></polyline>
              <rect x="1" y="3" width="22" height="5"></rect>
              <line x1="10" y1="12" x2="14" y2="12"></line></svg
            >Open a Studio</a
          >
        </li>
        <li class="round_c_s">
          <a class="droplist" href="/associate"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <circle cx="12" cy="6" r="2"></circle>
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <circle cx="12" cy="18" r="2"></circle></svg
            >Associate Profile</a
          >
        </li>
        <li>
          <div class="divider-bar"></div>
        </li>
        <li class="round_c_s">
          <a class="droplist" :href="`${$siteURL}/account/settings`"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <circle cx="12" cy="12" r="3"></circle>
              <path
                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"
              ></path></svg
            >Settings</a
          >
        </li>
        <li class="round_c_s">
          <a class="droplist" @click.prevent="logOut()" href="#"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="ico-drowdown"
            >
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line></svg
            >Log Out</a
          >
        </li>
        <li>
          <div class="divider-bar"></div>
        </li>
        <li class="no-ico" style="display: flex">
          <label for="checkbox">Dark Mode</label>
          <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
              <input type="checkbox" id="checkbox" />
              <div class="toggle round"></div>
            </label>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  props: ["avatar", "profile", "studio"],
  data() {
    return {
      isOpen: false,
    };
  },
  methods: {
    togleMenu() {
      this.isOpen = !this.isOpen;
    },
    closeMenu() {
      this.isOpen = false;
    },
    logOut() {
      axios
        .post("/logout")
        .then((res) => {
          location.reload();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    console.log(this.studio);
    const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    const currentTheme = localStorage.getItem("theme");

    if (currentTheme) {
      document.documentElement.setAttribute("data-theme", currentTheme);

      if (currentTheme === "dark") {
        toggleSwitch.checked = true;
      }
    }

    function switchTheme(e) {
      if (e.target.checked) {
        document.documentElement.setAttribute("data-theme", "dark");
        localStorage.setItem("theme", "dark");
      } else {
        document.documentElement.setAttribute("data-theme", "light");
        localStorage.setItem("theme", "light");
      }
    }

    toggleSwitch.addEventListener("change", switchTheme, false);
  },
};
</script>
<style></style>
