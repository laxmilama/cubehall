<template>
  <div>
    <div v-show="shareDiag" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button @click.prevent="closeDialog()" class="_SO_d_bx">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-x"
                >
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
              <h3>Share with friends and family</h3>
            </div>
            <div class="_SO_d_b">
              <div class="flex-box _Share_detail">
                <div class="_Share_detail_img round_c_s">
                  <img :src="thumbnail" />
                </div>
                <div>
                  <h5 class="_Share_title">{{ name }}</h5>
                  <div class="share_des">Board {{ name }} shared by @{{ owner }}</div>
                </div>
              </div>
              <div>
                <section class="shareBTN" @click="shareOnFacebook">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="#000000"
                    stroke="currentColor"
                    stroke-width="0"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="_share_ico"
                  >
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M21 12C21 7.02943 16.9706 3 12 3C7.02943 3 3 7.02943 3 12C3 16.4922 6.29117 20.2155 10.5938 20.8907V14.6016H8.30859V12H10.5938V10.0172C10.5938 7.76156 11.9374 6.51562 13.9932 6.51562C14.9779 6.51562 16.0078 6.69141 16.0078 6.69141V8.90625H14.8729C13.7549 8.90625 13.4062 9.60001 13.4062 10.3117V12H15.9023L15.5033 14.6016H13.4062V20.8907C17.7088 20.2155 21 16.4922 21 12Z"
                    ></path>
                  </svg>
                  Facebook
                </section>
                <section class="shareBTN" @click="shareOnTwitter">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="#000000"
                    stroke="currentColor"
                    stroke-width="0"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="_share_ico"
                  >
                    <path
                      d="M19.1367 8.5C19.8398 7.99519 20.4727 7.38942 21 6.64904C20.2969 6.95192 19.5938 7.15385 18.8906 7.22115C19.6641 6.75 20.2266 6.11058 20.5078 5.26923C19.7695 5.67308 18.9961 5.97596 18.1523 6.11058C17.8008 5.77404 17.3789 5.50481 16.9219 5.30288C16.4648 5.10096 15.9727 5 15.4453 5C14.7773 5 14.1797 5.16827 13.6172 5.47115C13.0547 5.80769 12.5977 6.24519 12.2812 6.78365C11.9297 7.32212 11.7891 7.92788 11.7891 8.53365C11.7891 8.80288 11.7891 9.07212 11.8594 9.34135C10.3477 9.27404 8.94141 8.9375 7.60547 8.26442C6.26953 7.625 5.17969 6.75 4.26562 5.63942C3.91406 6.21154 3.73828 6.81731 3.73828 7.42308C3.73828 8.02885 3.87891 8.60096 4.19531 9.10577C4.47656 9.64423 4.89844 10.0481 5.39062 10.3846C4.79297 10.3846 4.23047 10.2163 3.73828 9.91346V9.98077C3.73828 10.8221 4.01953 11.5625 4.58203 12.2019C5.14453 12.875 5.84766 13.2788 6.69141 13.4471C6.33984 13.5144 6.02344 13.5481 5.70703 13.5481C5.49609 13.5481 5.25 13.5481 5.03906 13.5144C5.25 14.2212 5.67188 14.7933 6.30469 15.2644C6.9375 15.7356 7.64062 15.9375 8.48438 15.9375C7.11328 16.9471 5.56641 17.4519 3.87891 17.4519C3.52734 17.4519 3.24609 17.4519 3 17.4183C4.6875 18.4952 6.58594 19 8.66016 19C10.8047 19 12.7031 18.4952 14.3906 17.4183C15.9023 16.476 17.0977 15.2308 17.9414 13.6154C18.75 12.1346 19.1719 10.5529 19.1719 8.9375C19.1719 8.73558 19.1367 8.60096 19.1367 8.5Z"
                    ></path>
                  </svg>
                  Twitter
                </section>
                <section class="shareBTN" @click="shareOnPinterest">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="#000000"
                    stroke="currentColor"
                    stroke-width="0"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="_share_ico"
                  >
                    <path
                      d="M12 3C7.02963 3 3 7.02632 3 11.9926C3 15.8043 5.37037 19.0609 8.71852 20.3709C8.63704 19.6604 8.57037 18.565 8.74815 17.7878C8.91111 17.0847 9.8 13.3174 9.8 13.3174C9.8 13.3174 9.53333 12.7771 9.53333 11.9852C9.53333 10.7344 10.2593 9.80181 11.163 9.80181C11.9333 9.80181 12.3037 10.3791 12.3037 11.0674C12.3037 11.8372 11.8148 12.9918 11.5556 14.065C11.3407 14.9605 12.0074 15.6933 12.8889 15.6933C14.4889 15.6933 15.7185 14.0058 15.7185 11.5781C15.7185 9.42434 14.1704 7.92188 11.9556 7.92188C9.39259 7.92188 7.88889 9.83882 7.88889 11.8224C7.88889 12.5921 8.18519 13.4211 8.55556 13.8725C8.62963 13.9613 8.63704 14.0428 8.61482 14.1316C8.54815 14.4128 8.39259 15.0271 8.36296 15.153C8.32593 15.3158 8.22963 15.3528 8.05926 15.2714C6.93333 14.7459 6.22963 13.1102 6.22963 11.7854C6.22963 8.95066 8.28889 6.34539 12.1778 6.34539C15.2963 6.34539 17.7259 8.56579 17.7259 11.5411C17.7259 14.6423 15.7704 17.1365 13.0593 17.1365C12.1481 17.1365 11.2889 16.6628 11 16.1003C11 16.1003 10.5481 17.8174 10.437 18.2393C10.237 19.0238 9.68889 20.0008 9.31852 20.6003C10.163 20.8594 11.0519 21 11.9852 21C16.9556 21 20.9852 16.9737 20.9852 12.0074C21 7.02632 16.9704 3 12 3Z"
                    ></path>
                  </svg>
                  Pinterest
                </section>
                <section class="shareBTN" @click="copyLink">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="_share_ico"
                  >
                    <path
                      d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"
                    ></path>
                    <path
                      d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"
                    ></path>
                  </svg>
                  Copy Link
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="share_btn_ico round_full">
      <div class="card-body" @click="enableShare">
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
          class="feather feather-share"
        >
          <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
          <polyline points="16 6 12 2 8 6"></polyline>
          <line x1="12" y1="2" x2="12" y2="15"></line>
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "shareBoard",
  props: {
    board: String,
    name: String,
    thumbnail: String,
    owner: String,
  },
  data() {
    return {
      shareDiag: false,
    };
  },
  methods: {
    enableShare() {
      this.shareDiag = true;
    },
    closeDialog() {
      this.shareDiag = false;
    },
    shareOnTwitter() {
      let text = this.name + " board shared by @" + this.owner;
      let URL =
        "https://twitter.com/intent/tweet?source=tweetbutton&url=" +
        this.$siteURL +
        "/board/" +
        this.board +
        "&text=" +
        text +
        "&related=CubeHall";

      window.open(URL, "_blank");
    },
    shareOnPinterest() {
      let URL =
        "https://www.pinterest.com/pin/create/bookmarklet/?url=" +
        this.$siteURL +
        "/board/" +
        this.board +
        "&media=" +
        this.$siteURL +
        "/images/showoff/small/" +
        this.thumbnail +
        "&description=" +
        this.name +
        " board shared by @" +
        this.owner;

      window.open(URL, "_blank");
    },
    shareOnFacebook() {
      let URL =
        "https://www.facebook.com/sharer.php?u=" + this.$siteURL + "/board" + this.board;

      window.open(URL, "_blank");
    },
    copyLink() {
      this.$clipboard(this.$siteURL + "/board/" + this.board);
      this.$toast.success("Copied!", {
        position: "top-center",
        timeout: 2000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false,
      });
      this.closeDialog();
    },
  },
};
</script>

<style>
.shareBTN {
  display: flex;
  padding: 20px;
  box-sizing: border-box;
  margin: 10px;
  cursor: pointer;
  border-bottom: solid 1px var(--bg-color);
}
.shareBTN:hover {
  background: var(--bg-color);
}
._Share_detail {
  padding: 10px;
  margin-bottom: 15px;
}
._Share_detail_img {
  height: 80px;
  width: 80px;
  margin-right: 25px;
  flex-shrink: 0;
}
._Share_detail_img img {
  object-fit: cover;
  height: 100%;
  width: 100%;
}
._share_ico {
  margin-right: 8px;
}
._Share_title {
  margin: 0px;
  color: var(--gray-very-dark);
  font-size: 17px;
  line-height: 1.2;
  font-weight: 700;
}
.share_des {
  margin: 0px;
  color: var(--gray-dark);
  font-size: 16px;
  line-height: 1.2;
  font-weight: 400;
}
.share_btn_ico {
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--gray-very-light);
  height: 35px;
  width: 35px;
  margin-right: 10px;
  margin-left: 10px;
}
.share_btn_ico:hover {
  cursor: pointer;
  background: var(--bg-color);
}
</style>
