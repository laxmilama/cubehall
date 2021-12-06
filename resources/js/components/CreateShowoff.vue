<template>
  <div class="showoff-create">
    <div v-if="closeDialog" class="_bag_address_overlay">
      <div class="_bag_address_card round_c_m">
        <div class="_bag_address_cont">
          <div>
            <h4>Discard changes?</h4>
            <p>If you leave now, you will lose any changes you've made.</p>
          </div>
          <div>
            <div class="flx_btn_w">
              <div class="btn_showoff_wrap flx_btn_m">
                <button @click="discard" class="btn-normalize btn-secondary">
                  Discard
                </button>
                <button @click="cancle" class="btn-normalize btn-third">Cancle</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <fieldset v-if="step == 1" class="showoff-container round_c_m">
      <div class="showoff-head">
        <div class="showoff-back" @click="closeCreate">
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
        </div>
        <div>
          <h3>Create new showoff</h3>
        </div>
        <div></div>
      </div>
      <div class="d-flx-showoff flx-overflow">
        <div v-if="!hasItem" class="showoff-uploader-wrap">
          <input
            type="file"
            ref="fileInput"
            accept="image/x-png,image/jpeg"
            @change="uploadImage"
            class="showoff-uploader-input"
          />
          <div class="showoff-file">
            <svg
              width="80px"
              height="80px"
              viewBox="0 0 48 48"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>ONE-xicons</title>
              <path
                d="M42.21,36.75l-36.42,0a0.79,0.79,0,0,1-.7-0.42,0.77,0.77,0,0,1,0-.8L13.29,25a0.78,0.78,0,0,1,.63-0.32,0.85,0.85,0,0,1,.65.33l5.19,5.82,9.39-12.79a0.83,0.83,0,0,1,1.31,0L42.86,35.53h0a0.77,0.77,0,0,1,0,.79A0.79,0.79,0,0,1,42.21,36.75Zm-36-1,35.56,0-12-16.85L20.41,31.66a0.78,0.78,0,0,1-.63.33,0.8,0.8,0,0,1-.66-0.33l-5.19-5.83ZM19.6,31.07v0Zm0.29,0h0Zm-6.11-5.36h0Zm0.31,0,0,0Zm15.53-7h0Zm0.34,0v0Z"
              />
              <path
                d="M19,21.25h0a5,5,0,0,1,0-10h0A5,5,0,0,1,19,21.25Zm0-9a4,4,0,0,0,0,8h0a4,4,0,0,0,0-8h0Z"
              />
              <path
                d="M43.5,45H4.5A4.5,4.5,0,0,1,0,40.5V7.5A4.5,4.5,0,0,1,4.5,3h39A4.5,4.5,0,0,1,48,7.5v33A4.5,4.5,0,0,1,43.5,45ZM4.5,4A3.5,3.5,0,0,0,1,7.5v33A3.5,3.5,0,0,0,4.5,44h39A3.5,3.5,0,0,0,47,40.5V7.5A3.5,3.5,0,0,0,43.5,4H4.5Z"
              />
              <rect width="48" height="48" fill="none" />
            </svg>
            <h1 class="mbl-show">Tap here to add photo.</h1>
            <h1 class="mbl-hide">Drag and drop photo here.</h1>
            <div>
              <button class="btn-normalize btn-secondary">Select from your device</button>
            </div>
          </div>
        </div>
        <div v-if="isUploading" class="sf-uploadingmsg">uploading..</div>

        <div class="right-showoff">
          <div class="flex-box">
            <img
              class="showoff-hint-img"
              :src="`${$siteURL}/assets/lightBulb.png`"
              alt=""
            />
            <h3>Tips for quality photos</h3>
          </div>
          <div>
            <article>
              <ul>
                <li>
                  Use a vertical image with at least an aspected ratio of 2 x 3 tall.
                </li>
                <li>Use natural daylight and avoid flash</li>
                <li>Take photos in bright, clear and in color</li>
                <li>Highlight products</li>
              </ul>
            </article>
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset v-if="step == 2" class="showoff-container round_c_m">
      <div class="showoff-head">
        <div class="showoff-back" @click="closeCreate">
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
        </div>
        <div>
          <h3>Tag Products</h3>
        </div>
        <div></div>
      </div>
      <div class="d-flx-showoff flx-overflow">
        <div v-if="image != null" class="showoff-img-wrap">
          <img
            :src="`${$siteURL}/images/showoff/medium/${image}`"
            alt=""
            @click="tagProduct"
            class="image_point showoff-img round_c_s"
          />
          <div
            v-for="(tag, index) in tags"
            id="tagged"
            :key="index"
            class="tag"
            :style="{ top: tag.top, left: tag.left, visibility: 'visible' }"
          ></div>
        </div>
        <div class="right-showoff">
          <div>
            <h3>You can add {{ 10 - listedCount }} more products.</h3>
            <span
              >Hint: Make sure to tap on exact items on the image for more accuracy.</span
            >
            <div class="mt-m showoff-pd-slt">
              <div
                style="position: relative; margin: 8px"
                v-for="(item, ind) in listedItems"
                :key="ind"
              >
                <div class="showoff-select-img">
                  <img
                    v-bind:src="`${$siteURL}/images/product/thumb/` + item.thumbnail"
                    class="round_c_s"
                  />
                </div>
                {{ item.product.name }}
                <button
                  class="showoff-cross"
                  @click.prevent="removeItem(item.product.id)"
                >
                  X
                </button>
              </div>
            </div>
          </div>
          <div class="flx_btn_w">
            <div class="btn_showoff_wrap flx_btn_m">
              <span></span>
              <button
                class="btn-normalize btn-third"
                @click.prevent="next"
                :disabled="!hasItems"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="showItems" class="tag-items-wrapper">
        <div v-if="unlisted.length <= 0">
          <h1>You've no products to tag or you have tagged all products.</h1>
          <p>Buy more products to increase your list in showoff.</p>
          <button @click.prevent="cancelItemSelection">Cancel</button>
        </div>
        <div style="height: 100%" v-else>
          <div class="showoff-tag-header">
            <h2>Tag products</h2>
            <article>Tag products to your image to build a Pin people can shop</article>
          </div>
          <div style="height: calc(100% - 115px); width: 100%; overflow: auto">
            <div
              class="showoff-select"
              v-for="item in unlisted"
              :key="item.id"
              @click.prevent="selectItem(item.product.id)"
            >
              <div class="showoff-select-img">
                <img
                  v-bind:src="`${$siteURL}/images/product/thumb/` + item.thumbnail"
                  class="round_c_s"
                />
              </div>
              <span>{{ item.product.name }} </span>
            </div>
          </div>
          <button
            class="showoff-tag-cancle btn-normalize btn-secondary"
            @click.prevent="cancelItemSelection"
          >
            Cancel
          </button>
        </div>
      </div>
    </fieldset>
    <fieldset v-if="step == 3" class="showoff-container round_c_m">
      <div class="showoff-head">
        <div class="showoff-back" @click="closeCreate">
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
        </div>
        <div>
          <h3>Compose</h3>
        </div>
        <div></div>
      </div>
      <div class="d-flx-showoff flx-overflow">
        <div v-if="image != null" class="showoff-img-wrap mb-hide">
          <img
            :src="`${$siteURL}/images/showoff/medium/${image}`"
            alt=""
            @click="tagProduct"
            class="image_point showoff-img round_c_s"
          />
          <div
            v-for="(tag, index) in tags"
            id="tagged"
            :key="index"
            class="tag"
            :style="{ top: tag.top, left: tag.left, visibility: 'visible' }"
          ></div>
          <div class="tag">
            <span>
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
              >
                <path
                  d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"
                ></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line></svg
            ></span>
          </div>
        </div>
        <div class="right-showoff">
          <div class="mt-s">
            <h4>Title for your showoff</h4>
            <input
              type="text"
              class="input_showoff"
              v-model="title"
              placeholder="Add Title"
            />
          </div>
          <div class="mt-s">
            <h4>Next, let's describe your showoff</h4>
            <textarea
              v-model="description"
              placeholder="Write story, context that is inspiring."
              class="input_t_area"
            ></textarea>
            <div v-if="description.length < 100">
              {{ 100 - description.length }} more required
            </div>
            <div v-else>{{ description.length }}/1500</div>
          </div>
          <div class="flx_btn_w">
            <div class="btn_showoff_wrap flx_btn_m">
              <button @click.prevent="back" class="btn-normalize btn-secondary">
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
                  class="feather feather-arrow-left"
                >
                  <line x1="19" y1="12" x2="5" y2="12"></line>
                  <polyline points="12 19 5 12 12 5"></polyline></svg
                >Back
              </button>
              <button
                class="btn-normalize btn-third"
                @click.prevent="save"
                :disabled="!canPublish"
              >
                Publish
              </button>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
  </div>
</template>

<script>
export default {
  name: "createShowOff",
  data() {
    return {
      step: 1,
      items: [],
      showItems: false,
      image: null,
      tags: [],
      canTag: false,
      taggedId: [],
      title: "",
      description: "",
      hasItem: false,
      isUploading: false,
      errorModel: false,
      closeDialog: false,
    };
  },
  mounted() {
    this.getItems();
  },
  methods: {
    save() {
      let shoffData = new FormData();
      shoffData.append("image", this.image);
      shoffData.append("tags", JSON.stringify(this.tags));
      shoffData.append("title", this.title);
      shoffData.append("description", this.description);

      axios
        .post(this.$siteURL + "/user/showoff/save", shoffData)
        .then((res) => {
          console.log(res.data);
          // window.history.back();
          window.location.href = this.$siteURL + "/showoff/" + res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    next() {
      this.step++;
      this.canTag = false;
    },
    cancle() {
      this.closeDialog = false;
    },
    discard() {
      window.history.back();
    },

    back() {
      this.step--;
      this.canTag = true;
    },
    closeCreate() {
      if (this.image) {
        this.closeDialog = true;
      } else {
        window.history.back();
      }
    },
    getItems() {
      if (this.items != null) {
        axios
          .get("/user/get/list")
          .then((result) => {
            console.log(result.data);
            this.items = result.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    addItems() {
      if (this.items != null) {
        this.getItems();
      }
      this.canTag = true;
    },
    selectItem(id) {
      if (this.tags.length > 0) {
        this.taggedId.push(id);

        this.tags[this.tags.length - 1]["pid"] = id;
        this.tags[this.tags.length - 1]["type"] = "ProductList";

        this.showItems = false;
        this.canTag = true;
      }
    },
    removeItem(j) {
      for (var i = 0; i < this.tags.length; i++) {
        if (this.tags[i].pid === j) {
          this.tags.splice(i, 1);
        }
        if (this.taggedId[i] === j) {
          this.taggedId.splice(i, 1);
        }
      }
    },
    cancelItemSelection() {
      this.tags.pop();
      this.canTag = true;
      this.showItems = false;
    },
    validImage(e) {
      var reader = new FileReader();
      var image = new Image();

      reader.onload = function (ev) {
        //Initiate the JavaScript Image object.

        //Set the Base64 string return from FileReader as source.
        image.src = ev.target.result;

        //Validate the aspected ratio;
        image.onload = function (callback) {
          var height = this.height;
          var width = this.width;
          var ratio;
          if (height > width) {
            ratio = width / height;
          } else {
            ratio = height / width;
          }
          console.log("Ratio: " + ratio);
          // if (ratio >= 0.43 && ratio <= 1) {
          //   return true;
          // }
          return callback(ratio);
        };
      };
      reader.readAsDataURL(e.target.files[0]);
      console.log(image.imgHeight);
    },
    uploadImage(e) {
      // console.log("ratio is: " + this.validImage(e));
      console.log(this.$refs.fileInput.value);
      var imgfile = e.target.files[0];
      // allow only file size smaller than 30 MB
      if (imgfile.size / 1024 / 1024 <= 30) {
        var ratio = 1;
        console.log("Height: " + imgfile);
        // console.log((this.$refs.fileInput.value = ""));

        if (ratio >= 0.43 && ratio <= 1) {
          let imageData = new FormData();
          imageData.append("image", imgfile);

          axios
            .post(this.$siteURL + "/user/showoff/upload", imageData, {
              onUploadProgress: (progressEvent) => {
                this.isUploading = true;
                this.uploadProgress = Math.round(
                  (progressEvent.loaded / progressEvent.total) * 100
                );
                console.log(
                  Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
                );
              },
            })
            .then((res) => {
              this.image = res.data.image;
              this.hasItem = true;
              this.canTag = true;
              this.step++;
              this.isUploading = false;
            })
            .catch((error) => {
              if (error.response.status == 405) {
                this.$toast.error("Invalid image aspected ratio", {
                  position: "top-center",
                  timeout: 5000,
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
              } else {
                this.$toast.error("Something went wrong.", {
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
              }

              this.isUploading = false;
            });
        } else {
          this.$toast.error("Something went wrong!", {
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
        }
      }
    },
    tagProduct(event) {
      if (this.canTag) {
        var image = event.target;

        const rect = image.getBoundingClientRect();
        const x = event.clientX - rect.left + image.offsetLeft;
        const y = event.clientY - rect.top + image.offsetTop;

        const height = rect.height;
        const width = rect.width;

        const top = (y / height) * 100;
        const left = (x / width) * 100;

        this.canTag = false;
        this.showItems = true;

        this.tags.push({
          top: top.toFixed(2) + "%",
          left: left.toFixed(2) + "%",
        });
      }
    },
  },
  computed: {
    unlisted: function () {
      return this.items.filter((x) => !this.taggedId.includes(x.product.id));
    },
    listedItems: function () {
      return this.items.filter((x) => this.taggedId.includes(x.product.id));
    },
    listedCount: function () {
      return this.tags.length;
    },
    hasItems: function () {
      if (this.tags.length > 0) {
        return true;
      }
      return false;
    },
    canPublish: function () {
      if (this.title.length > 5 && this.description.length > 99) {
        return true;
      }
      return false;
    },
  },
};
</script>

<style>
.sf-uploadingmsg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
}
.flx-overflow {
  overflow: auto;
}
</style>
