<template>
  <div>
    <div v-if="cookieModel" class="model-overlay">
      <div v-if="cookieDialog" class="model_cookie round_c_m">
        <div class="_pd">
          <div>
            <h3 style="margin: 0">Accept cookies from CubeHall?</h3>
          </div>
          <div>
            <p>
              CubeHall requires you to accept cookies for personalized content. Some are
              strictly necessary to run the site and others are used for measuring site
              usage and marketing.
            </p>
          </div>
          <div class="">
            <div class="flex-box" style="justify-content: center">
              <button class="btn-normalize btn-secondary MG_8" @click="moreDialog">
                More Settings
              </button>
              <button class="btn-normalize btn-third MG_8" @click="acceptCookies">
                Accept All
              </button>
            </div>

            <div>
              <span class="_information">
                You can always change your preferences by accessing the "Cookie settings"
                section at the bottom of the page. For complete details, see the
                <a href="#" class="_blue_text">Privacy Policy and Cookie.</a>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div v-if="moreSettings" class="model_cookie_setting round_c_m">
        <div class="_pd">
          <div>
            <h3>Privacy Preference Center</h3>
          </div>
          <div>
            <p>
              When you visit any website, it may store or retrieve information on your
              browser, mostly in the form of cookies. This information might be about you,
              your preferences or your device and is mostly used to make the site work as
              you expect it to. The information does not usually directly identify you,
              but it can give you a more personalized web experience. Because we respect
              your right to privacy, you can choose not to allow some types of cookies.
              Click on the different category headings to find out more and change our
              default settings. However, blocking some types of cookies may impact your
              experience of the site and the services we can offer.
            </p>
          </div>
          <div>
            <div>
              <div class="model_card_head">
                <div>
                  <h3 class="model_info_head">Strictly Necessary Cookies</h3>
                </div>
                <div class="_blue_text">Always Active</div>
              </div>
              <div>
                <p>
                  These cookies are necessary for the website to function and cannot be
                  switched off in our systems. They are usually only set in response to
                  actions made by you which amount to a request for services, such as
                  setting your privacy preferences, logging in or filling in forms. You
                  can set your browser to block or alert you about these cookies, but some
                  parts of the site will not then work. These cookies do not store any
                  personally identifiable information.
                </p>
              </div>
            </div>
            <div>
              <button class="btn-normalize btn-third" @click="acceptCustomized">
                Confirm my preferences
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "cookieHandler",
  data() {
    return {
      moreSettings: false,
      cookieDialog: false,
      cookieModel: false,
    };
  },
  methods: {
    moreDialog() {
      this.moreSettings = true;
      this.cookieDialog = false;
    },
    acceptCookies() {
      this.$cookies.set("cubehall_cookieconsent", "true", -1);
      this.cookieDialog = false;
      this.cookieModel = false;
    },
    acceptCustomized() {
      this.$cookies.set("cubehall_cookieconsent", "true", -1);
      this.moreSettings = false;
      this.cookieModel = false;
    },
  },
  mounted() {
    if (!this.$cookies.isKey("cubehall_cookieconsent")) {
      this.cookieDialog = true;
      this.cookieModel = true;
    }
  },
};
</script>
<style>
.model-overlay {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.65);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
}
.model_cookie {
  max-width: 600px;
  background: var(--gray-very-light);
}
.model_cookie_setting {
  max-width: 900px;
  background: var(--gray-very-light);
}
.model_card_head {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
._pd {
  padding: 25px;
}
._information {
  font-size: 14px;
  color: var(--gray-medium-dark);
}
._blue_text {
  color: var(--blue);
}
.MG_8 {
  margin: 8px;
}
.more_CS {
  position: fixed;
  top: 0;
  left: 0;
}
.model_info_head {
  margin-top: 15px;
  margin-bottom: 0;
}
</style>
