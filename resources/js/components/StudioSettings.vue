<template>
  <div id="AdmCont" class="fullwidth padlft">
    <div class="sm-container">
      <div class="lft-stn">
        <h1 class="mb-m mt-m typography-headline3">Studio Settings</h1>
        <tabs-dyna>
          <tab name="About" :background="textColor()">
            <div>
              <h2>General Informations</h2>
              <span>Change identifying details for your studio</span>
            </div>
            <div class="mt-m">
              <div class="dflx stn-ctnr mt-m mb-m">
                <div>
                  <strong>Studio Name</strong>
                  <div v-if="!editName">
                    <span>
                      {{ name }}
                    </span>
                  </div>
                  <div v-else>
                    <div>
                      <input v-on:input="velidateName" type="text" v-model="name" />
                    </div>
                    <div>
                      <button
                        class="save-btn"
                        :disabled="!enableSave"
                        @click.prevent="SaveName()"
                        :style="saveButton"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
                <div>
                  <button
                    v-if="!editName"
                    :disabled="edit"
                    @click.prevent="NameEdit()"
                    class="btn-edt"
                  >
                    Edit
                  </button>
                  <button v-else @click.prevent="cancle()" class="btn-edt">Cancle</button>
                </div>
              </div>
              <div class="dflx stn-ctnr mt-m mb-m">
                <div>
                  <strong>Handle</strong>
                  <div v-if="!editHandle">
                    <span>
                      {{ handle }}
                    </span>
                  </div>
                  <div v-else>
                    <div>
                      <input v-on:input="validateHandle" type="text" v-model="handle" />
                    </div>
                    <div>
                      <button
                        class="save-btn"
                        :disabled="!enableSave"
                        @click.prevent="SaveHandle()"
                        :style="saveButton"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
                <div>
                  <button
                    v-if="!editHandle"
                    :disabled="edit"
                    @click.prevent="HandleEdit()"
                    class="btn-edt"
                  >
                    Edit
                  </button>
                  <button v-else @click.prevent="cancle()" class="btn-edt">Cancle</button>
                </div>
              </div>
              <div class="dflx stn-ctnr mt-m mb-m">
                <div>
                  <strong>About</strong>
                  <div v-if="!editAbout">
                    <span>
                      {{ about }}
                    </span>
                  </div>
                  <div v-else>
                    <div>
                      <textarea
                        v-on:input="velidateAbout"
                        type="text"
                        v-model="about"
                        style="width: 100%"
                        rows="10"
                      ></textarea>
                    </div>
                    <div>
                      <button
                        class="save-btn"
                        :disabled="!enableSave"
                        @click.prevent="SaveAbout()"
                        :style="saveButton"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
                <div>
                  <button
                    v-if="!editAbout"
                    :disabled="edit"
                    @click.prevent="AboutEdit()"
                    class="btn-edt"
                  >
                    Edit
                  </button>
                  <button v-else @click.prevent="cancle()" class="btn-edt">Cancle</button>
                </div>
              </div>
            </div>
          </tab>
          <tab name="Brand" :background="textColor()">
            <div>
              <div>
                <h2>Profile Photo</h2>
              </div>
              <div class="mt-m mb-m">
                <div class="mt-m">
                  <figure class="flex-box" style="align-items: center">
                    <img
                      style="height: 100px; width: 100px"
                      :src="`${$siteURL}/images/profile/small/` + profile"
                    />
                    <div>
                      <label for="_profile">
                        <div
                          class="btn-secondary btn-normalize"
                          style="margin-left: 15px"
                        >
                          Change
                        </div>
                      </label>
                      <input
                        type="file"
                        id="_profile"
                        accept="image/x-png,image/jpeg"
                        @change="changeProfile"
                        class="_STn_file_input"
                      />
                    </div>
                  </figure>
                </div>
              </div>
              <div class="mb-m mt-m">
                <div>
                  <strong>Custom Brand Color</strong>
                  <p>
                    Choose the color visitors will see for links and buttons on your page.
                  </p>
                </div>
                <div>
                  <div class="dflx clr-btn">
                    <button
                      class="sc-selector"
                      v-for="(color, index) in palette"
                      :key="index"
                      :style="{ background: color.hex }"
                      :class="{ checked: paletteIndex === index }"
                      @click="selectColor(index)"
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
                      >
                        <polyline points="20 6 9 17 4 12"></polyline>
                      </svg>
                    </button>
                    <label
                      class="sc-selector bnd-col-pick"
                      :style="{ background: color }"
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
                        class="pik-ico"
                      >
                        <path
                          d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"
                        ></path>
                      </svg>
                      <input
                        v-bind:value="color"
                        class="sc-selector"
                        type="color"
                        @change="colorChange"
                      />
                    </label>
                  </div>
                  <div>
                    <div class="mt-m mb-m">
                      <button
                        :disabled="!colorSaveEnable"
                        @click.prevent="saveBrandColor"
                        class="save-btn"
                        :style="saveButton"
                      >
                        Change Color
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-m mt-m">
                <div>
                  <h2>Cover Photo</h2>
                </div>
                <div>
                  <figure>
                    <img
                      style="width: 100%"
                      class="round_c_s"
                      :src="`${$siteURL}/images/cover/small/` + cover"
                      alt=""
                    />
                    <label for="_cover">
                      <div class="btn-secondary btn-normalize" style="margin-left: 15px">
                        Change
                      </div>
                    </label>
                    <input
                      type="file"
                      class="_STn_file_input"
                      accept="image/x-png,image/jpeg"
                      @change="changeCover"
                      id="_cover"
                    />
                  </figure>
                </div>
              </div>
            </div>
          </tab>
          <tab name="Payment" :background="textColor()">
            <studio-payment></studio-payment>
          </tab>
          <tab name="Address" :background="textColor()">
            <studio-address></studio-address>
          </tab>
        </tabs-dyna>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import TabsDyna from "./TabsDyna";
import Tab from "./Tab";
import Vibrant from "node-vibrant";
import StudioPayment from "./StudioPayment.vue";
import StudioAddress from "./StudioAddress.vue";
import * as Color from "../Color";
export default {
  components: {
    TabsDyna,
    Tab,
    StudioPayment,
    StudioAddress,
  },
  props: {
    studio: Object,
  },
  data() {
    return {
      name: this.studio.name,
      handle: this.studio.slug,
      color: "#111111",
      about: this.studio.meta_description,
      profile: this.studio.profile_image,
      cover: this.studio.cover_image,
      edit: false,
      editName: false,
      editHandle: false,
      editAbout: false,
      enableSave: false,
      palette: [],
      paletteIndex: null,
      colorSaveEnable: false,
    };
  },
  methods: {
    expand() {},
    uploadProfile() {},
    uploadCover() {},
    NameEdit() {
      this.editName = true;
      this.edit = true;
      this.enableSave = false;
    },
    HandleEdit() {
      this.editHandle = true;
      this.edit = true;
      this.enableSave = false;
    },
    AboutEdit() {
      this.editAbout = true;
      this.edit = true;
      this.enableSave = false;
    },
    cancle() {
      if (this.editName) {
        this.name = this.studio.name;
      }
      if (this.editHandle) {
        this.handle = this.studio.slug;
      }
      if (this.editAbout) {
        this.about = this.studio.meta_description;
      }
      this.reset();
    },
    reset() {
      this.editName = false;
      this.editHandle = false;
      this.editAbout = false;
      this.edit = false;
      this.enableSave = false;
    },
    SaveName() {
      let nameData = new FormData();
      nameData.append("name", this.name);
      nameData.append("studioId", this.studio.id);
      axios
        .post(this.$siteURL + "/studio/name/update", nameData)
        .then((res) => {
          this.reset();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    SaveHandle() {
      let handleData = new FormData();
      handleData.append("handle", this.handle);
      handleData.append("studioId", this.studio.id);
      axios
        .post(this.$siteURL + "/studio/handle/update", handleData)
        .then((res) => {
          this.reset();
          this.handle = this.handle;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    SaveAbout() {
      let nameData = new FormData();
      nameData.append("about", this.about);
      nameData.append("studioId", this.studio.id);
      axios
        .post(this.$siteURL + "/studio/about/update", nameData)
        .then((res) => {
          this.reset();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    validateHandle: _.debounce(function (e) {
      var handleRegx = /^[a-zA-Z]+[a-zA-Z0-9-_]{6,}$/;

      if (handleRegx.test(this.handle)) {
        let handleData = new FormData();
        handleData.append("handle", this.handle);
        axios
          .post(this.$siteURL + "/studio/handle/validation", handleData)
          .then((res) => {
            this.enableSave = true;
            this.isValidHandle = true;
          })
          .catch((error) => {
            this.isValidHandle = false;
            this.enableSave = false;
          });
      } else {
        this.isValidHandle = false;
      }
      if (this.handle.length < 6) {
        this.enableSave = false;
      }
    }, 100),
    velidateName: _.debounce(function (e) {
      var handleRegx = /^[a-zA-Z]+[a-zA-Z0-9-_ ]{6,}$/;

      if (handleRegx.test(this.name)) {
        this.enableSave = true;
      }
      if (this.handle.length < 6) {
        this.enableSave = false;
        this.handle = this.studio.slug;
      }
    }, 500),
    velidateAbout: _.debounce(function (e) {
      if (this.handle.length < 6) {
        this.enableSave = false;
        this.handle = this.studio.slug;
      } else {
        this.enableSave = true;
      }
    }, 500),
    changeProfile(e) {
      console.log(e);
      let profileData = new FormData();
      profileData.append("image", e.target.files[0]);
      profileData.append("studioId", this.studio.id);

      axios
        .post(this.$siteURL + "/studio/profile/upload", profileData, {
          onUploadProgress: (progressEvent) => {
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          this.profile = res.data.image;
          this.getPalette(this.$siteURL + "/images/profile/small/" + this.profile);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeCover(e) {
      let coverData = new FormData();
      coverData.append("image", e.target.files[0]);
      coverData.append("studioId", this.studio.id);

      axios
        .post(this.$siteURL + "/studio/cover/upload", coverData, {
          onUploadProgress: (progressEvent) => {
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            console.log(
              Math.round((progressEvent.loaded / progressEvent.total) * 100) + "%"
            );
          },
        })
        .then((res) => {
          this.cover = res.data.image;
          console.log(res.data.image);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getPalette(imageSrc) {
      this.imageSrc = imageSrc;
      Vibrant.from(imageSrc)
        .maxColorCount(200)
        .getPalette()
        .then((palette) => {
          const colors = [];
          var number = 0;
          for (let color in palette) {
            const hex = palette[color].getHex();
            colors.push({
              hex,
            });
          }
          this.palette = colors;
        });
    },
    selectColor(i) {
      this.paletteIndex = i;
      this.colorSaveEnable = true;
    },
    colorChange(e) {
      this.color = e.target.value;
      this.paletteIndex = null;
      this.colorSaveEnable = true;
    },
    saveBrandColor() {
      let colorData = new FormData();
      if (this.paletteIndex != null) {
        colorData.append("color", this.palette[this.paletteIndex].hex);
      } else {
        colorData.append("color", this.color);
      }
      colorData.append("studioId", this.studio.id);
      axios
        .post(this.$siteURL + "/studio/color/update", colorData)
        .then((res) => {
          this.colorSaveEnable = false;
          this.color = res.data.color;
          this.changeStyle();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeStyle() {
      document.documentElement.style.setProperty("--primary-color", this.color);
      console.log(Color.GetTextColor(this.color));
    },
    textColor() {
      return Color.GetTextColor(this.color);
    },
  },
  created() {
    this.getPalette(this.$siteURL + "/images/profile/small/" + this.profile);
    if (this.studio.brand_color) {
      this.color = this.studio.brand_color;
    }
    this.changeStyle();
  },
  computed: {
    saveButton() {
      if (this.enableSave) {
        return {
          background: this.textColor(),
          color: this.color,
        };
      }
    },
  },
};
</script>
<style>
.save-btn {
  background-color: var(--primary-color);
  color: var(--bg-color);
  border-radius: 8px;
  padding: 8px 15px;
  border: none;
  font-weight: 600;
  font-size: 16px;
}

.save-btn:disabled,
.save-btn[disabled] {
  border: none;
  background-color: var(--gray-light);
  color: var(--gray-medium);
}
.btn-edt {
  background: none;
  border: none;
  outline-style: none;
  color: var(--primary-color);
  font-weight: 600;
  font-size: 16.2px;
  text-decoration: underline;
}
.btn-edt:disabled,
.btn-edt[disabled] {
  border: none;
  color: var(--gray-medium);
}

.sc-selector {
  border-radius: 50%;
  height: 50px;
  width: 50px;
  border: none;
  display: block;
  cursor: pointer;
}
input[type="color"] {
  visibility: hidden;
}
._STn_file_input {
  visibility: hidden;
}
.dflx {
  display: flex;
}
.bnd-col-pick {
  display: flex;
  align-items: center;
}
.pik-ico {
  height: 20px;
  width: 20px;
  margin-left: 15px;
  flex-shrink: 0;
  visibility: visible !important;
}
.clr-btn .checked svg {
  visibility: visible;
  stroke: white !important;
}
.clr-btn svg {
  visibility: hidden;
}
.stn-ctnr {
  justify-content: space-between;
}
.lft-stn {
  width: 50%;
}
@media only screen and (max-width: 600px) {
  .lft-stn {
    width: 100%;
  }
}
</style>
