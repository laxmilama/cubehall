<template>
  <div id="AdmCont" class="ParlorWrap">
    <form>
      <fieldset v-if="step == 1">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <h2 class="plr_uploder_title">What type of parlor are you focusing on?</h2>
            <span>Choose the theme that describes your parlor.</span>
            <div class="uploader_content">
              <div v-if="theme == null">
                <div>
                  <div>
                    <button class="btn-normalize btn-third" @click.prevent="OpenCategory">
                      Select a theme
                    </button>
                  </div>
                </div>
                <div v-if="showCategoryDialog" class="cateOptionDialog">
                  <div class="catD-box">
                    <div v-if="showCategories">
                      <div class="cat-header">
                        <div class="_cat_back" @click="closeCategory">
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
                        <div>Select a theme</div>
                      </div>
                      <div class="catFlx">
                        <div v-for="(section, k) in sections" :key="k" class="cat-item">
                          <div @click.prevent="expandSection(k)" class="cat-list">
                            <span>{{ section.name }}</span>
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
                              class="feather feather-chevron-right"
                            >
                              <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="sectionExpanded">
                      <div class="cat-header">
                        <div class="_cat_back" @click="backToSection">
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
                            class="feather feather-chevron-left"
                          >
                            <polyline points="15 18 9 12 15 6"></polyline>
                          </svg>
                        </div>
                        <div class="_cat_title">
                          What exactly in {{ sections[secId].name }}?
                        </div>
                      </div>
                      <div style="height: 100%; overflow: scroll">
                        <div class="catFlx">
                          <div
                            v-for="(category, i) in categories"
                            :key="category.id"
                            class="cat-item"
                          >
                            <div v-if="category.subcategories.length > 0">
                              <div @click.prevent="expandCategory(i)" class="cat-list">
                                <span>
                                  {{ category.name }}
                                </span>
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
                                  class="feather feather-chevron-right"
                                >
                                  <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                              </div>
                            </div>
                            <div v-else>
                              <label :for="`option_${category.slug}`">
                                <div class="cat-list">
                                  {{ category.name }}
                                  <input
                                    type="radio"
                                    :value="`${category.id}`"
                                    :id="`option_${category.slug}`"
                                    v-model="theme"
                                  />
                                </div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="categoryExpanded">
                      <div class="cat-header">
                        <div class="_cat_back" @click="backToCategory">
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
                            class="feather feather-chevron-left"
                          >
                            <polyline points="15 18 9 12 15 6"></polyline>
                          </svg>
                        </div>
                        <div class="_cat_title">
                          What exactly in {{ categories[catId].name }}?
                        </div>
                      </div>
                      <div class="catFlx">
                        <div v-for="sub in subcategories" :key="sub.id" class="cat-item">
                          <div>
                            <label :for="`option_${sub.slug}`">
                              <div class="cat-list">
                                {{ sub.name }}
                                <input
                                  type="radio"
                                  :value="`${sub.id}`"
                                  :id="`option_${sub.slug}`"
                                  v-model="theme"
                                />
                              </div>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="selected-theme">
                <div>
                  <div>
                    <strong>{{ selectedTheme[0].name }}</strong>
                  </div>
                  <div>
                    <span
                      @click.prevent="removeTheme"
                      style="color: var(--gray-dark); cursor: pointer"
                      >Remove</span
                    >
                  </div>
                </div>
              </div>
            </div>

            <div class="uploader_btns">
              <span></span>
              <button
                @click.prevent="next()"
                :disabled="!theme"
                class="btn-nest btn-normalize"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset v-if="step == 2">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">Give your parlor a title</h2>
            </div>
            <div class="uploader_content">
              <div class="uploader_content">
                <label for="title"
                  >Title should be short, descriptive and exciting.</label
                >
              </div>
              <textarea
                type="text"
                id="title"
                cols="50"
                rows="3"
                placeholder="eg. Drawing caricature of yourself."
                v-model="title"
                maxlength="60"
                name="title"
              />
              <div>
                <span>{{ title.length }}/60</span>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button
                @click.prevent="next()"
                class="btn-nest btn-normalize"
                :disabled="title.length <= 10"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset v-if="step == 3">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">What is your Parlor about</h2>
            </div>
            <div class="uploader_content">
              <label for="brief">
                <strong>What will you and your guests do?</strong>
                <ul>
                  <li>
                    Provide specific plans from start to finish, not multiple ideas or
                    options
                  </li>
                  <li>
                    Describe what makes your experience special—something that guests
                    wouldn’t do on their own
                  </li>
                </ul>
              </label>

              <div>
                <textarea
                  v-model="brief"
                  style="width: 100%; min-height: 180px; font-size: 16px"
                  id="brief"
                  maxlength="1400"
                  minlength="200"
                ></textarea>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button @click.prevent="next()" class="btn-nest btn-normalize">Next</button>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset v-if="step == 4">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">Things your guest expect to learn</h2>
            </div>
            <div class="uploader_content">
              <div class="uploader_content">
                <p>This list will help your guest to be prepared.</p>
                <p>Be as detailed as possible and add each item individually.</p>
              </div>
              <div v-if="learnings.length > 0">
                <div v-for="(learning, index) in learnings" v-bind:key="index">
                  <input v-model="learnings[index]" class="uploader_input" />
                  <span @click.prevent="learnings.splice(index, 1)">
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
                      <line x1="18" y1="6" x2="6" y2="18"></line>
                      <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                  </span>
                </div>
              </div>
              <input
                type="text"
                v-model="learnField"
                name="willlearn"
                class="uploader_input"
              />
              <button
                :disabled="learnField.length < 2"
                @click.prevent="addLearning"
                class="btn-add-list"
                autofocus
              >
                Add list
              </button>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button @click.prevent="next()" class="btn-nest btn-normalize">Next</button>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset v-if="step == 5">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div class="uploader_content">
              <h2 class="plr_uploder_title">
                Will guests need to bring anything to the parlor?
              </h2>
              <p>
                What guests need to bring This list will be emailed to guests when they
                book your parlor. Help them prepare by being specific and listing each
                item separately.
              </p>
              <ul>
                <li>Do not ask to buy expensive items.</li>
              </ul>
            </div>
            <div class="uploader_content">
              <div v-if="bringings.length > 0">
                <div v-for="(bringing, index) in bringings" v-bind:key="index">
                  <input
                    v-model="bringings[index]"
                    style="width: 80%"
                    class="uploader_input"
                  />
                  <span @click.prevent="bringings.splice(index, 1)">
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
                      <line x1="18" y1="6" x2="6" y2="18"></line>
                      <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                  </span>
                </div>
              </div>
              <div>
                <input
                  type="text"
                  v-model="bringField"
                  name="tobring"
                  style="width: 80%"
                  class="uploader_input"
                />
                <button
                  :disabled="bringField.length < 2"
                  @click.prevent="addBringing"
                  class="btn-add-list"
                >
                  Add list
                </button>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button @click.prevent="next()" class="btn-nest btn-normalize">Next</button>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset v-if="step == 6">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">Add Photos</h2>
            </div>
            <div class="uploader_content">
              <label v-if="!cover" for="_cover">
                <div class="upload-wrapper">
                  <input
                    type="file"
                    class="upload-thumbnail-input"
                    accept="image/*"
                    @change="uploadCover"
                    id="_cover"
                  />
                  <div class="drag-text">
                    <p>Drag and drop a file or select add Image</p>
                  </div>
                </div>
              </label>
              <div v-else class="img-preview">
                <img
                  class="imagethumb"
                  v-if="cover"
                  v-bind:src="`${$siteURL}/images/parlor/small/` + cover"
                />
              </div>
            </div>

            <div>
              <div>
                <h3 v-if="details.length < 4">
                  Upload at least {{ 4 - details.length }} more
                </h3>
              </div>
              <div>
                <div>
                  <label for="_details">
                    <div class="upload-wrapper">
                      <input
                        multiple
                        type="file"
                        class="upload-thumbnail-input"
                        accept="image/*"
                        id="_details"
                        @change="uploadDetails"
                      />
                      <div class="drag-text">
                        <p>Drag and drop a file or select add Image</p>
                      </div>
                    </div>
                  </label>
                </div>
                <div v-if="details.length > 0" class="_PLR_up_wrapper">
                  <div v-for="img in details" v-bind:key="img.image" class="_PLR_up_imgs">
                    <img
                      class="imagethumb round_c_s"
                      v-bind:src="`${$siteURL}/images/parlor/small/` + img"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="uploader_content">
              <div>
                <h3>Your photos must meet the requirements</h3>
                <ul>
                  <li>A variety of details including photos of people in action</li>
                  <li>
                    Good image quality with no filters, overlaid text, or watermarks
                  </li>
                </ul>
              </div>
            </div>

            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button
                @click.prevent="next()"
                :disabled="details.length < 4"
                class="btn-nest btn-normalize"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset v-if="step == 7">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div class="uploader_content">
              <h2 class="plr_uploder_title">Submit a video demonstration</h2>
            </div>
            <div class="uploader_content upload-wrapper">
              <progress
                class="uploader_progress"
                id="file"
                v-bind:value="uploadProgress"
                max="100"
                v-if="isUploading"
              >
                32%
              </progress>
              <input
                type="file"
                class="upload-thumbnail-input"
                accept="video/*"
                @change="uploadVideo"
                id="_plr_Vd_up"
              />
              <label for="_plr_Vd_up">
                <div class="drag-text">
                  <p>Drag and drop a file or select add Image</p>
                </div></label
              >
            </div>
            <div v-if="video" class="img-preview">
              <div id="videoContainer" data-fullscreen="false">
                <video
                  id="video"
                  controls
                  preload="metadata"
                  :poster="`${$siteURL}/img/cover.jpg`"
                  autoplay
                  muted
                  style="width: 100%"
                >
                  <source v-bind:src="`${$siteURL}/videos/` + video" type="video/mp4" />
                </video>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button
                @click.prevent="next()"
                :disabled="!video"
                class="btn-nest btn-normalize"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset v-if="step == 8">
        <div v-show="languageBox" class="_SVsf">
          <div class="_SO_overlay"></div>
          <div>
            <div class="_SO_card">
              <div class="_SO_dialog round_c_b">
                <div class="_SO_d_t">
                  <button @click.prevent="languageBox = false" class="_SO_d_bx">X</button>
                  <h3 class="mt-s mb-m">Select languages</h3>
                </div>
                <div class="_SO_d_b">
                  <div>
                    <div v-if="lang">
                      <div class="_lang_ck" v-for="l in lang" v-bind:key="l.code">
                        <label :for="`_checkbox_` + l.code">
                          <span>
                            <input
                              v-model="languages"
                              type="checkbox"
                              :value="l.name"
                              :id="`_checkbox_` + l.code"
                            />
                          </span>
                          <span>
                            {{ l.nativeName }}
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">Location and Language</h2>
            </div>
            <div>
              <h4>Where are you hosting from?</h4>
              <select class="_inp_admn" v-model="location">
                <option value="0" selected disabled>Select your country</option>
                <option v-for="c in countries" :key="c.code" :value="c.name">
                  {{ c.name }}
                </option>
              </select>
            </div>
            <div>
              <h4>Which language(s) will you offer your parlor in?</h4>
              <div
                class="_inp_c"
                v-if="languages.length > 0"
                @click.prevent="languageBox = true"
              >
                <span v-for="(lg, lid) in languages" :key="lid">
                  {{ lg }}<span v-if="lid < languages.length - 1">,</span>
                </span>
                <div>
                  <span>Languages</span>
                </div>
              </div>
              <div class="_inp_admn _inp_c" v-else @click.prevent="languageBox = true">
                <span>Select languages</span>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button
                :disabled="!(languages.length > 0 && location.length > 1)"
                @click.prevent="next()"
                class="btn-nest btn-normalize"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset v-if="step == 9">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">Minimum Requirements</h2>
            </div>
            <div class="uploader_content">
              <p>
                When you’re done, export the recording as an MP4 file. The file size must
                be under 1GB.
              </p>
              <div class="uploader_content">
                <h3>Minimum age</h3>
                <span
                  >Set age limits for guests. Minors can only attend with their legal
                  guardian.</span
                >
                <div>
                  <select class="age_select" v-model="age">
                    <option
                      v-for="i in [
                        2,
                        3,
                        4,
                        5,
                        6,
                        7,
                        8,
                        9,
                        10,
                        11,
                        12,
                        13,
                        14,
                        15,
                        16,
                        17,
                        18,
                        19,
                        20,
                        21,
                      ]"
                      :key="i"
                    >
                      {{ i }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button @click.prevent="next()" class="btn-nest btn-normalize">Next</button>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset v-if="step == 10">
        <div class="uploader_wrapper">
          <div class="uploader_container">
            <div>
              <h2 class="plr_uploder_title">Almost done!</h2>
            </div>
            <div class="uploader_content">
              <p>
                You may be required to have additional licenses, permits, or permissions
                because of details that are specific to your parlor:
              </p>
            </div>
            <div class="uploader_content">
              <div class="uploader_content">
                <label for="copyrightContent" class="submit_check">
                  <span
                    >By selecting this checkbox, I confirm that my parlor complies with
                    all applicable laws, rules and regulations and my descriptions, photos
                    and video are my own property. Further, I've not included any
                    copyrighted content.</span
                  >
                  <input
                    class="submit_check_box"
                    type="checkbox"
                    name="copyrightContent"
                    id="copyrightContent"
                    v-model="copyrightContent"
                  />
                </label>
              </div>

              <div class="uploader_content">
                <label for="agreeTerms" class="submit_check">
                  <span
                    >By selecting this chcekbox, I aggree that I've read the terms and
                    condition that applies to all the parlor hosting.
                  </span>
                  <input
                    class="submit_check_box"
                    type="checkbox"
                    name="agreeTerms"
                    id="agreeTerms"
                    v-model="agreeTerms"
                  />
                </label>
              </div>
              <div class="uploader_content">
                <label for="accuracy" class="submit_check">
                  <span
                    >By selecting this checkbox, I agree this parlor will be limited the
                    descriptions and nothing more will be conducted.
                  </span>
                  <input
                    class="submit_check_box"
                    type="checkbox"
                    name="accuracy"
                    id="accuracy"
                    v-model="accuracy"
                  />
                </label>
              </div>
            </div>
            <div class="uploader_btns">
              <button @click.prevent="prev()" class="btn-normalize">Previous</button>
              <button
                @click.prevent="submitReview()"
                :disabled="!(accuracy && agreeTerms && copyrightContent)"
                class="btn-nest btn-normalize"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</template>
<script>
// Date Picker
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
export default {
  props: ["studio", "creator"],

  data() {
    return {
      step: 1,
      location: "0",
      countries: null,
      lang: null,
      theme: null,
      languages: [],
      languageBox: false,
      brief: "",
      title: "",
      time: null,
      uploadProgress: 0,
      bringField: "",
      learnField: "",
      bringings: [],
      learnings: [],
      age: 18,
      page: this.studio,
      user: this.creator,
      cover: null,
      details: [],
      video: null,
      pricing: {
        individual: null,
        group: {
          size: "",
          price: "",
        },
      },
      copyrightContent: false,
      accuracy: false,
      agreeTerms: false,
      showCategoryDialog: false,
      sections: [],
      categories: [],
      subcategories: [],
      showCategories: false,
      categoryExpanded: false,
      sectionExpanded: false,
      secId: null,
      catId: null,
      isUploading: false,
    };
  },
  components: {
    VueCtkDateTimePicker,
  },
  methods: {
    removeTheme() {
      this.theme = null;
      this.showCategoryDialog = false;
      this.secId = null;
      this.catId = null;
      this.categories = null;
      this.subcategories = null;
      this.sectionExpanded = false;
      this.categoryExpanded = false;
    },
    OpenCategory() {
      this.showCategoryDialog = true;
      this.showCategories = true;
    },
    prev() {
      this.step--;
    },
    next() {
      this.step++;
    },
    closeCategory() {
      this.showCategoryDialog = false;
      this.showCategories = false;
    },
    isReady() {
      if (this.copyrightContent && this.accuracy && this.agreeTerms) {
        return true;
      }
      return false;
    },
    backToSection() {
      this.showCategories = true;
      this.sectionExpanded = true;
      this.categories = null;
      this.sectionExpanded = false;
    },
    backToCategory() {
      this.showCategories = false;
      this.sectionExpanded = true;
      this.subcategories = null;
      this.categoryExpanded = false;
    },
    addBringing(e) {
      let toBringInput = e.target.parentElement.querySelector("input[name=tobring]");
      this.bringings.push(toBringInput.value);
      this.bringField = "";
    },
    addLearning(e) {
      let willLearnInput = e.target.parentElement.querySelector("input[name=willlearn]");
      this.learnings.push(willLearnInput.value);
      this.learnField = "";
    },
    uploadCover(e) {
      let coverData = new FormData();
      coverData.append("image", e.target.files[0]);

      let imp = e.target.parentElement.querySelector(".img-preview");

      axios
        .post(this.$siteURL + "/parlor/cover/upload", coverData, {
          onUploadProgress: (progressEvent) => {
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
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
    uploadDetails(e) {
      let formData = new FormData();

      for (var i = 0; i < e.target.files.length; i++) {
        formData.append("files[" + i + "]", e.target.files[i]);
      }
      axios
        .post(this.$siteURL + "/parlor/cover/details", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          // this.details = res.data.images;
          res.data.images.forEach((e) => {
            this.details.push(e);
          });
          console.log(res.data.images);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    uploadVideo(e) {
      let vidData = new FormData();
      vidData.append("video", e.target.files[0]);

      axios
        .post(this.$siteURL + "/api/post/video", vidData, {
          onUploadProgress: (progressEvent) => {
            this.uploadProgress = Math.round(
              (progressEvent.loaded / progressEvent.total) * 100
            );
            this.isUploading = true;
          },
        })
        .then((res) => {
          this.video = res.data.video;
          this.isUploading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    submitReview() {
      axios
        .post(this.$siteURL + "/parlor/add", this.$data)
        .then((res) => {
          this.video = res.data.video;
          // console.log(res.data.video);
          // redirect back
          window.location.href = this.$siteURL + "/studio/parlors";
        })
        .catch((error) => {
          console.log(error);
        });
    },
    expandCategory(i) {
      this.catId = i;
      this.categoryExpanded = true;
      this.showCategories = false;
      this.sectionExpanded = false;
      this.subcategories = this.categories[i].subcategories;
    },
    expandSection(i) {
      this.catId = null;
      this.secId = i;
      this.showCategories = false;
      this.sectionExpanded = true;
      this.categories = this.sections[i].categories;
    },
    checkPhotos() {
      if (this.details.length <= 4 && this.cover == null) {
        return true;
      } else {
        return false;
      }
    },
  },
  computed: {
    selectedTheme: function () {
      if (this.catId != null) {
        return this.subcategories.filter((selected) => selected.id == this.theme);
      } else {
        return this.categories.filter((selected) => selected.id == this.theme);
      }
    },
  },
  mounted() {
    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
      console.log(this.countries);
    });

    axios.get(this.$siteURL + "/js/lang/languages.json").then((result) => {
      this.lang = result.data;
    });
    // Load Menu
    axios
      .get(this.$siteURL + "/get/parlor/section")
      .then((res) => {
        this.sections = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
<style>
.cateOptionDialog {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(0, 0, 0, 0.8);
  z-index: 1000;
}
.catD-box {
  background: var(--bg-color);
  box-sizing: border-box;
  width: 500px;
  position: relative;
  min-height: 50%;

  border-radius: 25px;
  overflow: hidden;
}
.catFlx {
  display: flex !important;
  flex-wrap: wrap !important;
  padding: 24px;
  justify-content: space-between;
}
.cat-item {
  width: 45%;
  padding-top: 24px;
  padding-bottom: 24px;
  border-bottom: solid 1px var(--gray-light);
}
.cat-header {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  min-height: 60px;
  position: relative;
}
._cat_back {
  position: absolute;
  left: 25px;
  top: 25px;
}
.cat-list {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
}
._cat_title {
  max-width: 80%;
  text-align: center;
}
.selected-theme {
  margin-top: 24px;
}

.uploader_wrapper {
  display: flex;
  justify-content: center;
  margin-top: 50px;
}
.uploader_progress {
  width: 100%;
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
}
.uploader_container {
  width: 625px;
  max-width: 625px;
}
.uploader_content {
  margin-top: 24px;
  margin-bottom: 24px;
}
.uploader_btns {
  display: flex;
  justify-content: space-between;
  padding: 15px 5px;
}
._PLR_up_imgs {
  width: 50%;
}
._PLR_up_wrapper {
  display: flex;
  flex-wrap: wrap;
}
fieldset {
  border: none;
}
.uploader_input {
  width: 80%;
  height: 30px;
  margin-bottom: 15px;
  font-size: 18px;
}
.btn-add-list {
  font-size: 16px;
  background: var(--bg-color);
  border-radius: 5px;
  padding: 5px 10px;
}
.btn-add-list:disabled {
  background: var(--gray-medium);
  color: var(--gray-dark);
}
.plr_uploder_title {
  font-size: 32px;
}
.submit_check {
  display: flex;
  justify-content: space-between;
}
.submit_check span {
  font-weight: 600;
}
.submit_check_box {
  height: 24px;
  width: 24px;
  flex-shrink: 0;
  margin-left: 16px;
}
.age_select {
  height: 47px;
  padding: 10px 25px;
  padding-left: 10px;
  margin-top: 15px;
  border-radius: 4px;
  font-size: 16px;
}
@media only screen and (max-width: 600px) {
  .uploader_container {
    width: 100%;
  }
  .ParlorWrap fieldset {
    padding: 0 15px;
  }
}
</style>
