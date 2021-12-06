<template>
  <div>
    <div class="container">
      <div>
        <div class="flex-box">
          <div style="width: 100%">
            <div class="mt">
              <a href="/">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="36"
                  height="36"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="studio_logo"
                  viewBox="0 0 20.36 20.34"
                >
                  <g id="Layer_2" data-name="Layer 2">
                    <g id="Layer_1-2" data-name="Layer 1">
                      <path
                        d="M9.4,20.34H1.79A1.79,1.79,0,0,1,0,18.55v-7.7A2.65,2.65,0,0,1,2.65,8.2H4.12a2.73,2.73,0,0,1,2.73,2.73V13a.5.5,0,0,0,.5.49h2a2.74,2.74,0,0,1,2.74,2.74v1.39A2.72,2.72,0,0,1,9.4,20.34ZM2.65,9.49A1.36,1.36,0,0,0,1.3,10.85v7.7a.5.5,0,0,0,.49.5H9.4a1.43,1.43,0,0,0,1.43-1.43V16.23a1.44,1.44,0,0,0-1.44-1.44h-2A1.79,1.79,0,0,1,5.56,13V10.93A1.45,1.45,0,0,0,4.12,9.49Z"
                      />
                      <path
                        d="M15.09,20.34a1.66,1.66,0,0,1-.61-.12,1.59,1.59,0,0,1-1-1.47V7.14a.29.29,0,0,0-.29-.29H1.61A1.58,1.58,0,0,1,.49,4.14L4.17.46A1.62,1.62,0,0,1,5.29,0H18.77a1.59,1.59,0,0,1,1.59,1.59V15.08a1.6,1.6,0,0,1-.47,1.12l-3.68,3.68A1.59,1.59,0,0,1,15.09,20.34Zm-9.8-19a.32.32,0,0,0-.21.08L1.41,5.06a.3.3,0,0,0-.07.32.29.29,0,0,0,.27.18h11.6A1.59,1.59,0,0,1,14.8,7.14V18.75A.28.28,0,0,0,15,19a.26.26,0,0,0,.31-.06L19,15.28a.3.3,0,0,0,.08-.2V1.59a.29.29,0,0,0-.29-.29Z"
                      />
                    </g>
                  </g>
                </svg>
              </a>
            </div>
            <template v-if="step == 1">
              <div class="pdR">
                <div>
                  <h1 class="typography-headline2">Start your studio in 3 steps.</h1>
                  <p class="_AS_content">
                    Our studio space is limited only to the most qualified creators and
                    brands at the moment.
                  </p>
                </div>
                <div>
                  <div class="st_btn_wrap">
                    <span></span>
                    <button class="st_btn" @click.prevent="next">Let's start</button>
                  </div>
                </div>
              </div>
            </template>
            <template v-if="step == 2">
              <div>
                <div>
                  <h1 class="typography-headline2">What is your studio about?</h1>
                  <div>
                    <div
                      v-for="(type, index) in types"
                      :key="index"
                      @click="selected = type"
                    >
                      <div
                        class="stH_cCard"
                        v-bind:class="{ selected_: selected == type }"
                      >
                        <div class="stH_cBody">
                          <div>
                            <div>{{ type }}</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div @click="selected = 'parlor'">
                      <div
                        class="stH_cCard"
                        v-bind:class="{ selected_: selected == 'parlor' }"
                      >
                        <div class="stH_cBody">
                          <div>
                            <div>Online Activities</div>
                            <span class="typography-caption"
                              >I just want host parlors at CubeHall</span
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="flex-box" style="align-items: center">
                    <div>
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
                        style="margin-right: 15px"
                        class="feather feather-alert-triangle"
                      >
                        <path
                          d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
                        ></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                      </svg>
                    </div>

                    <p>
                      We do not support Dropshipping or Retailing, Foods & Groceries, and
                      Digital Downloads at the moment. If you can't find your category,
                      please consider checking us in the future.
                    </p>
                  </div>
                </div>
                <div>
                  <div class="st_btn_wrap">
                    <button class="st_btn_back" @click.prevent="back">Back</button>
                    <button class="st_btn" @click.prevent="next" :disabled="!selected">
                      Next
                    </button>
                  </div>
                </div>
              </div>
            </template>
            <template v-if="step == 3">
              <div>
                <div>
                  <h1 class="typography-headline2">Let's set-up your studio.</h1>
                  <div>
                    <div class="inp_g">
                      <label for="name" class="inp_l">Name</label>
                      <div class="inp_r">
                        <input
                          v-on:input="validateName"
                          v-bind:class="{ st_invalid: !isValidName }"
                          type="text"
                          id="name"
                          spellcheck="false"
                          placeholder="Ex. Your Name or Business Name"
                          class="inp_height inp_100"
                          v-model="name"
                        />
                        <span v-if="!isValidName" class="inp_warning">
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
                          >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="inp_g">
                      <label for="handle" class="inp_l">Handle</label>
                      <div class="inp_r">
                        <input
                          v-on:input="validateHandle"
                          type="text"
                          id="handle"
                          v-model="handle"
                          spellcheck="false"
                          class="inp_height inp_100"
                          v-bind:class="{ st_invalid: !isValidHandle }"
                        />
                        <span v-if="!isValidHandle" class="inp_warning">
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
                          >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                          </svg>
                        </span>
                      </div>
                      <div>
                        <span class="inp_handle">cubehall.com/</span
                        ><span>{{ handle }}</span>
                      </div>
                    </div>

                    <div class="inp_g">
                      <label for="description" class="inp_l"
                        >Create your studio description</label
                      >
                      <div class="inp_r">
                        <textarea
                          v-model="description"
                          v-on:input="validateDescription"
                          v-bind:class="{ st_invalid: !isValidDescription }"
                          name="description"
                          id="description"
                          cols="30"
                          rows="10"
                          class="inp_100 inp_tarea"
                          :maxlength="validDescriptionLength"
                        ></textarea>
                        <span v-if="!isValidDescription" class="inp_warning">
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
                          >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                          </svg>
                        </span>
                      </div>
                      <div>
                        <div v-if="description.length <= validDescriptionLength">
                          <span>{{ description.length }}/500</span>
                        </div>
                        <div v-else>
                          <span>{{ validDescriptionLength - description.length }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="st_btn_wrap">
                    <button class="st_btn_back" @click.prevent="back">Back</button>
                    <button class="st_btn" @click.prevent="next" :disabled="!validBasics">
                      Next
                    </button>
                  </div>
                </div>
              </div>
            </template>
            <template v-if="step == 4">
              <div class="pdR">
                <div>
                  <h1 class="typography-headline2">Where's your studio located?</h1>
                </div>
                <div>
                  <div class="inp_s inp_g">
                    <div>
                      <label for="country" class="inp_l">Country/region</label>
                    </div>
                    <div>
                      <select
                        class="inp_height"
                        name=""
                        id="country"
                        v-model="address.country"
                      >
                        <option v-for="c in countries" :key="c.code" :value="c.code">
                          {{ c.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div>
                    <div class="inp_g">
                      <label for="name" class="inp_l">City</label>
                      <div class="inp_r">
                        <input
                          type="text"
                          id="name"
                          name="city"
                          spellcheck="false"
                          class="inp_height inp_100"
                          v-model="address.city"
                        />
                        <span v-if="!isValidName" class="inp_warning">
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
                          >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="inp_g">
                      <label for="addressstate" class="inp_l">State</label>
                      <div class="inp_r">
                        <input
                          type="text"
                          id="addressstate"
                          name="state"
                          spellcheck="false"
                          class="inp_height inp_100"
                          v-model="address.state"
                        />
                        <span v-if="!isValidName" class="inp_warning">
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
                          >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="inp_g">
                    <label for="addressstreet" class="inp_l">Street</label>
                    <div class="inp_r">
                      <input
                        type="text"
                        id="addressstreet"
                        name="street"
                        placeholder="Ex: Trishakti Marg 2"
                        spellcheck="false"
                        class="inp_height inp_100"
                        v-model="address.street"
                      />
                      <span v-if="!isValidName" class="inp_warning">
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
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="8" x2="12" y2="12"></line>
                          <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                      </span>
                    </div>
                  </div>
                  <div class="inp_g">
                    <label for="addressapt" class="inp_l">Apt, suite. (optional)</label>
                    <div class="inp_r">
                      <input
                        type="text"
                        id="addressapt"
                        name="apt"
                        placeholder="Ex: 123 Main St."
                        spellcheck="false"
                        class="inp_height inp_100"
                        v-model="address.apt"
                      />
                      <span v-if="!isValidName" class="inp_warning">
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
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="8" x2="12" y2="12"></line>
                          <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                      </span>
                    </div>
                  </div>
                  <div class="inp_g">
                    <label for="addresspostal" class="inp_l"
                      >Postal Code (optional)</label
                    >
                    <div class="inp_r">
                      <input
                        type="text"
                        id="addresspostal"
                        name="zipcode"
                        spellcheck="false"
                        class="inp_height inp_100"
                        v-model="address.postal"
                      />
                      <span v-if="!isValidName" class="inp_warning">
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
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="8" x2="12" y2="12"></line>
                          <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                      </span>
                    </div>
                  </div>
                </div>
                <div>
                  <p class="">
                    We need your business location for delivery or pick-up service. We'll
                    share your address only with customers who bought items from you and
                    delivery service providers.
                  </p>
                </div>
                <div>
                  <div class="st_btn_wrap">
                    <button class="st_btn_back" @click.prevent="back">Back</button>
                    <button
                      class="st_btn"
                      @click.prevent="next"
                      :disabled="!validAddress"
                    >
                      Next
                    </button>
                  </div>
                </div>
              </div>
            </template>
            <template v-if="step == 5">
              <div>
                <div>
                  <h1 class="typography-headline2">Some important things to know</h1>
                </div>
                <div>
                  <div>
                    By completing this form you agree that information provided is
                    accurate. Be sure you respect your <strong>local laws</strong> and you
                    also agree to our <strong>Terms</strong>.
                  </div>
                </div>
                <div>
                  <div class="st_btn_wrap">
                    <button class="st_btn_back" @click.prevent="back">Back</button>
                    <button class="st_btn" @click.prevent="save">Save and Publish</button>
                  </div>
                </div>
              </div>
            </template>
          </div>
          <div class="mbl-hide" style="width: 100%">
            <div class="stH_">
              <div class="stH_c"></div>
              <div class="stH_d">
                <div class="stH_p_w">
                  <div class="stH_p"></div>
                  <div>
                    <div>
                      <div v-if="name.length > 0">{{ name }}</div>
                      <div v-else>Studio Name</div>
                    </div>
                    <div>
                      <div v-if="handle.length > 0">@{{ handle }}</div>
                      <div v-else>Your handle here</div>
                    </div>
                    <div class="flex-box">
                      <div class="stH_f"></div>
                      <div class="stH_f"></div>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="flex-box">
                    <div class="stH_list">Store</div>
                    <div class="stH_list">Parlor</div>
                    <div class="stH_list">Reviews</div>
                    <div class="stH_list">About</div>
                  </div>
                  <div class="mt-s">
                    <div class="stH_grid">
                      <div v-for="i in 4" :key="i" class="stH_imgs">
                        <div class="stH_img1"></div>
                        <div class="stH_i_c"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
export default {
  data() {
    return {
      step: 1,
      name: "",
      isValidName: true,
      handle: "",
      countries: [],
      isValidHandle: true,
      description: "",
      validDescriptionLength: 500,
      isValidDescription: true,
      selected: null,
      address: {
        city: "",
        state: "",
        country: "NP",
        street: "",
        postal: "",
        apt: "",
      },
      categories: [
        "Clothing Line",
        "Shoes & Bags",
        "Artwork & Design",
        "Jewelry & Accessories",
        "Furniture & Home improvement",
        "Stationary",
        "Plant & Gardening",
        "Pet Supplies",
        "DIY and Craft",
      ],
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  computed: {
    validBasics: function () {
      if (
        this.isValidName &&
        this.name.length > 1 &&
        this.isValidHandle & (this.handle.length > 1) &&
        this.isValidDescription &&
        this.description.length > 1
      ) {
        return true;
      }
      return false;
    },
    types: function () {
      return this.categories.sort();
    },
    validAddress: function () {
      if (
        this.address.country != "" &&
        this.address.city != "" &&
        this.address.state != "" &&
        this.address.street != ""
      ) {
        return true;
      }
      return false;
    },
  },
  created() {
    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
      console.log(this.countries);
    });
  },
  methods: {
    next() {
      this.step++;
    },
    back() {
      this.step--;
    },
    success() {
      this.$toast.success("Successfull! Loading your studio.", {
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
    },
    save() {
      let studioData = new FormData();
      studioData.append("name", this.name);
      studioData.append("handle", this.handle);
      studioData.append("description", this.description);
      studioData.append("address", JSON.stringify(this.address));

      axios
        .post(this.$siteURL + "/studio/create", studioData)
        .then((res) => {
          this.success();
          setTimeout(function () {
            window.location.href = "/studio";
          }, 3000);
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("Failed! something went wrong", {
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
            console.log(res);
          })
          .catch((error) => {
            this.isValidHandle = false;
            console.log(error);
          });
      } else {
        this.isValidHandle = false;
      }
      if (this.handle.length < 6) {
        this.enableSave = false;
      }
    }, 500),
    validateName: _.debounce(function (e) {
      var handleRegx = /^[a-zA-Z]+[a-zA-Z0-9-_ ]{4,}$/;

      if (handleRegx.test(this.name)) {
        this.isValidName = true;
      } else {
        this.isValidName = false;
      }
      if (this.name.length < 6) {
        this.enableSave = false;
      }
    }, 100),
    validateDescription: _.debounce(function (e) {
      if (this.description.length > 6 && this.description.length < 500) {
        this.isValidDescription = true;
        this.enableSave = false;
      } else {
        this.isValidDescription = false;
      }
    }, 100),
  },
};
</script>
<style>
.inp_height {
  max-width: 100%;
  height: 47px;
  padding: 10px 25px;
  border-radius: 4px;
  font-size: 16px;
  border: solid 2px var(--gray-medium);
  box-sizing: border-box;
}
.inp_tarea {
  min-height: 100px;
  padding: 10px 25px;
  border-radius: 4px;
  font-size: 16px;
  border: solid 2px var(--gray-medium);
  box-sizing: border-box;
}
.inp_100 {
  width: 100%;
}
.inp_handle {
  color: var(--gray-medium-dark);
}
.inp_g {
  margin-bottom: 16px;
}
.inp_l {
  margin-bottom: 8px;
  display: block;
}
.inp_r {
  display: flex;
  align-items: center;
  position: relative;
}
.inp_s {
  margin-top: 15px;
}
.inp_warning {
  position: absolute;
  right: 15px;
}
.inp_warning svg {
  stroke: var(--primary-color);
  height: 20px;
  width: 20px;
}
.pdR {
  padding-right: 25px;
}
.st_btn {
  font-weight: 600;
  background: var(--gradient);
  border-radius: 0.25rem;
  border: none;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.5rem;
  box-sizing: border-box;
  color: rgba(255, 255, 255, 1);
}
.st_btn:disabled {
  background: var(--gray-light);
}
.st_invalid {
  outline: none;
  border: solid 2px var(--primary-color) !important;
}
.stH_imgs {
  width: 100%;
  position: relative;
}
.stH_img1 {
  width: 100%;
  padding-top: 133%;
  display: flex;
  background: var(--gray-light);
}
.stH_i_c {
  margin-top: 10px;
  height: 15px;
  width: 100%;
  background: var(--gray-light);
}
.stH_grid {
  display: grid;
  grid-column-gap: 25px;
  grid-template-columns: auto auto auto auto;
  grid-row-gap: 25px;
}
.st_btn_back {
  font-weight: 600;
  border: none;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.5rem 0.75rem 0;
  box-sizing: border-box;
  color: black;
  background: transparent;
}
.st_btn_wrap {
  display: flex;
  justify-content: space-between;
  margin-top: 15px;
  margin-bottom: 15px;
}
.stH_ {
  width: 100%;
  position: relative;
}
.stH_list {
  margin-right: 15px;
  color: var(--gray-medium);
}
.stH_c {
  background-color: var(--gray-light);
  width: 100%;
  padding-top: 30%; /* 1:1 Aspect Ratio */
  position: relative;
}
.stH_d {
  width: 90%;
  min-height: 100px;
  background: var(--gray-very-light);
  margin: 0 auto;
  position: relative;
  transform: translateY(-60px);
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  overflow: hiddenhi;
}
.stH_p_w {
  position: absoluteso;
  width: 100%;
  height: 100%;
  padding: 30px;
  display: flex;
}
.stH_p {
  background-color: var(--gray-light);
  width: 90px;
  height: 90px; /* 1:1 Aspect Ratio */
  position: relative;
  border-radius: 50%;
  margin-right: 15px;
}
.selected_ {
  border: solid 2px var(--blue) !important;
}
.stH_f {
  height: 20px;
  min-width: 100px;
  background: var(--gray-light);
  margin-right: 15px;
}
.stH_cCard {
  border-radius: 16px;
  border: solid 1px var(--gray-light);
  max-width: 464px !important;
  margin-left: auto !important;
  margin-right: auto !important;
  margin-bottom: 14px;
  cursor: pointer;
}
.stH_cBody {
  margin: 24px !important;
}
</style>
