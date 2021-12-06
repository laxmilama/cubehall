<template>
  <div style="display: flex">
    <div>
      <button @click.prevent="addStory()" class="add-story-btn">
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
          class="feather feather-plus"
        >
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
      </button>
      Add Yours
    </div>
    <div v-if="canAdd" class="story-overlay">
      <div class="story-wrapper">
        <div class="story-card">
          <button @click.prevent="cancleStory()" class="story-cross-btn">
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
              class="feather feather-x"
            >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
          <div class="story-uploader">
            <div class="story-uploader-wrap">
              <input
                type="file"
                class="story-uploader-input"
                accept="image/x-png,image/jpeg"
                @change="previewFile"
              />
              <div class="story-file">
                <div>
                  <svg
                    width="80px"
                    height="80px"
                    viewBox="0 0 48 48"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <title>ONE-xicons</title>
                    <path
                      d="M42.21,36.75l-36.42,0a0.79,0.79,0,0,1-.7-0.42,0.77,0.77,0,0,1,0-.8L13.29,25a0.78,0.78,0,0,1,.63-0.32,0.85,0.85,0,0,1,.65.33l5.19,5.82,9.39-12.79a0.83,0.83,0,0,1,1.31,0L42.86,35.53h0a0.77,0.77,0,0,1,0,.79A0.79,0.79,0,0,1,42.21,36.75Zm-36-1,35.56,0-12-16.85L20.41,31.66a0.78,0.78,0,0,1-.63.33,0.8,0.8,0,0,1-.66-0.33l-5.19-5.83ZM19.6,31.07v0Zm0.29,0h0Zm-6.11-5.36h0Zm0.31,0,0,0Zm15.53-7h0Zm0.34,0v0Z"
                    ></path>
                    <path
                      d="M19,21.25h0a5,5,0,0,1,0-10h0A5,5,0,0,1,19,21.25Zm0-9a4,4,0,0,0,0,8h0a4,4,0,0,0,0-8h0Z"
                    ></path>
                    <path
                      d="M43.5,45H4.5A4.5,4.5,0,0,1,0,40.5V7.5A4.5,4.5,0,0,1,4.5,3h39A4.5,4.5,0,0,1,48,7.5v33A4.5,4.5,0,0,1,43.5,45ZM4.5,4A3.5,3.5,0,0,0,1,7.5v33A3.5,3.5,0,0,0,4.5,44h39A3.5,3.5,0,0,0,47,40.5V7.5A3.5,3.5,0,0,0,43.5,4H4.5Z"
                    ></path>
                    <rect width="48" height="48" fill="none"></rect>
                  </svg>
                </div>
                <h3 class="mbl-hide">Drop file here or click anywhere.</h3>
                <h3 class="mbl-show">Tap anywhere to add photo</h3>
              </div>
            </div>
          </div>
          <div v-if="mediaUrl" class="story-preview">
            <img id="blah" v-bind:src="mediaUrl" alt="your image" />
            <div v-show="!hasAttatch" class="story-options">
              <div style="display: flex">
                <button @click="linkProduct" ref="pdt" class="story_ap_btn">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-shopping-bag"
                  >
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                  </svg>
                </button>
                <button @click="linkParlor" ref="pr" class="story_ap_btn">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-coffee"
                  >
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                  </svg>
                </button>
              </div>
            </div>
            <div class="upload-story">
              <button
                class="add-to-button-story"
                @click.prevent="save()"
                :disabled="disabled == true"
              >
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
                  class="feather feather-plus-circle"
                >
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="8" x2="12" y2="16"></line>
                  <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                <span> Add to story </span>
              </button>
            </div>
            <div v-if="cancleDialog" class="story-cancle-dialog-box-wrapper">
              <div class="story-cancle-dialog-box">
                <h3>Discard your WIP?</h3>
                <p>You will lose your media</p>
                <div>
                  <button class="add-to-button-story" @click.prevent="keepStory()">
                    Keep
                  </button>
                  <button class="add-to-button-story" @click.prevent="resetStory()">
                    Discard
                  </button>
                </div>
              </div>
            </div>
            <div v-if="isUploading" class="story-cancle-dialog-box-wrapper">
              isUploading
            </div>

            <div
              class="addtostory round_c_m"
              v-show="productDialog"
              v-closable="{
                exclude: ['pdt'],
                handler: 'closelinkProduct',
              }"
            >
              <div class="">
                <h3>Select Your Product</h3>
                <div>
                  <ul>
                    <li
                      class="str_lst"
                      v-for="(product, index) in products"
                      v-bind:key="index"
                      @click="addThisProduct(index)"
                    >
                      <div class="str_atc_thumb round_c_s">
                        <img
                          :src="`${$siteURL}/images/product/thumb/${product.meta.thumbnail}`"
                          alt=""
                        />
                      </div>
                      {{ product.name }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div
              class="addtostory round_c_m"
              v-show="parlorDialog"
              v-closable="{
                exclude: ['pr'],
                handler: 'closelinkParlor',
              }"
            >
              <div class="">
                <h3>Select Your Parlor</h3>
                <div>
                  <ul>
                    <li
                      class="str_lst"
                      v-for="(parlor, index) in parlors"
                      v-bind:key="index"
                      @click="addThisParlor(index)"
                    >
                      <div class="str_atc_thumb round_c_s">
                        <img
                          :src="`${$siteURL}/images/parlor/thumb/${parlor.cover}`"
                          alt=""
                        />
                      </div>

                      {{ parlor.title }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div v-if="hasAttatch" class="showhasath">
              <button @click="removeAttatch()" class="remove_Att">
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
                  class="feather feather-x"
                >
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
              <div v-if="product_id">
                <img
                  :src="`${$siteURL}/images/product/thumb/${products[index].meta.thumbnail}`"
                  alt=""
                />
                {{ products[index].name }}
              </div>
              <div v-if="parlor_id">
                <img
                  :src="`${$siteURL}/images/parlor/thumb/${parlors[index].cover}`"
                  alt=""
                />
                {{ parlors[index].title }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "addStory",
  props: {
    userid: String,
    pageid: String,
    viewer: Object,
  },
  data() {
    return {
      disabled: false,
      canAdd: false,
      mediaUrl: null,
      media: null,
      formData: null,
      cancleDialog: false,
      hasChange: false,
      upvalue: 0,
      parlor_id: null,
      product_id: null,
      user_id: this.userid,
      page_id: this.pageid,
      productDialog: false,
      parlorDialog: false,
      products: [],
      parlors: [],
      hasAttatch: false,
      index: null,
      isUploading: false,
    };
  },
  methods: {
    addStory() {
      this.canAdd = !this.canAdd;
    },
    togleMenu() {
      this.isOpen = !this.isOpen;
    },
    closeMenu() {
      this.isOpen = false;
    },
    previewFile(e) {
      const file = e.target.files[0];
      this.mediaUrl = URL.createObjectURL(file);

      this.formData = file;
      this.hasChange = true;
    },

    save() {
      let storyData = new FormData();
      storyData.append("file", this.formData);

      axios
        .post(this.$siteURL + "/post/story/media", storyData, {
          onUploadProgress: (progressEvent) => {
            this.disabled = true;
            this.isUploading = true;
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          this.media = res.data.image;
          this.shareStory();
        })
        .catch((error) => {
          this.$toast.error("Image not supported.", {
            position: "top-center",
            timeout: 3000,
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
        });
    },

    shareStory() {
      let storyData = new FormData();
      // storyData.append("file", this.formData);
      let d = JSON.stringify(this.$data);
      storyData.append("data", d);

      axios
        .post(this.$siteURL + "/post/story", storyData, {
          onUploadProgress: (progressEvent) => {
            this.disabled = true;
            this.isUploading = true;
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          this.$toast.success("Successfuly shared your story", {
            position: "top-center",
            timeout: 3000,
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
          this.resetStory();
        })
        .catch((error) => {
          this.$toast.error("Something went wrong", {
            position: "top-center",
            timeout: 3000,
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
        });
    },
    cancleStory() {
      if (this.hasChange) {
        this.cancleDialog = true;
      } else {
        this.canAdd = false;
      }
    },

    resetStory() {
      this.canAdd = false;
      this.mediaUrl = null;
      this.formData = null;
      this.hasChange = false;
      this.cancleDialog = false;
      this.product_id = null;
      this.parlor_id = null;
      this.index = null;
      this.hasAttatch = false;
      this.isUploading = false;
      this.disabled = false;
    },

    keepStory() {
      this.cancleDialog = false;
    },

    linkProduct() {
      // add product
      this.productDialog = true;
      this.listProducts();
    },

    closelinkProduct() {
      this.productDialog = false;
    },

    listProducts() {
      if (!this.products.length) {
        axios.get(this.$siteURL + "/products/" + this.page_id).then((result) => {
          this.products = result.data;
        });
      }
    },

    addThisProduct(e) {
      this.index = e;
      this.product_id = this.products[e].id;
      this.checkAttatch();
      this.productDialog = false;
    },

    checkAttatch() {
      if (this.product_id || this.parlor_id) {
        this.hasAttatch = true;
      }
    },

    linkParlor() {
      this.parlorDialog = true;
      this.listParlors();
    },

    listParlors() {
      if (!this.parlors.length) {
        axios.get(this.$siteURL + "/parlors/" + this.page_id).then((result) => {
          this.parlors = result.data;
        });
      }
    },
    addThisParlor(e) {
      this.index = e;
      this.parlor_id = this.parlors[e].id;
      this.checkAttatch();
      this.parlorDialog = false;
    },
    closelinkParlor() {
      this.parlorDialog = false;
    },

    removeAttatch() {
      this.hasAttatch = false;
      this.index = null;
      this.parlor_id = null;
      this.product_id = null;
    },
  },
};
</script>
<style>
.story-progress {
  position: absolute;
  width: 80%;
  /* top: 0; */
  left: 50%;
  transform: translateX(-50%);
}
.story-options {
  position: absolute;
  top: 15px;
  left: 15px;
  color: white;
}
.addtostory {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  background: var(--bg-color);
  padding: 15px;
  color: var(--secondary-color);
  max-height: 50%;
  bottom: 0;
  overflow-y: auto;
  width: 90%;
}
.showhasath {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateX(-50%);
  background: var(--bg-color);
  padding: 15px;
  padding-top: 30px;
  color: var(--secondary-color);
  border-radius: 16px;
}
</style>
