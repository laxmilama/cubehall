<template>
  <div>
    <div style="margin-top: 40px; margin-bottom: 40px">
      <h1>Personal info</h1>
      <p>
        Add details about to your profile. Create your branded profile handle and manage
        other personal settings
      </p>
    </div>
    <div>
      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Photo</strong>
          <div class="_STn_lst_dtl flex-box" style="align-items: center">
            <div class="_STn_profile round_full">
              <img
                class="_STn_profile"
                :src="`${$siteURL}/images/profile/thumb/${photo}`"
                alt=""
              />
            </div>
            <div style="margin-left: 15px">
              <label for="_photo">
                <div class="btn-secondary btn-normalize">Change</div>
              </label>
              <input
                class="_STn_file_input"
                type="file"
                accept="image/x-png,image/jpeg"
                id="_photo"
                @change="updateProfile"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Legal name</strong>
          <div v-if="!editName" class="_STn_lst_dtl">
            <span>
              {{ name }}
            </span>
          </div>
          <div v-else>
            <div class="_STn_lst_dtl">
              <div class="_STn_lst_dtl">
                <div>This is the name on your government document.</div>
              </div>
              <div class="_STn_lst_dtl">
                <input
                  class="_STn_lst_inpt"
                  v-on:input="velidateName"
                  type="text"
                  v-model="name"
                />
              </div>
            </div>
            <div class="_STn_lst_dtl">
              <button
                class="_STn_lst_save"
                :disabled="!enableSave"
                @click.prevent="SaveName()"
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
            class="_STn_lst_edit"
          >
            Edit
          </button>
          <button v-else @click.prevent="cancle()" class="_STn_lst_edit">Cancle</button>
        </div>
      </div>

      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Username</strong>
          <div v-if="!editHandle" class="_STn_lst_dtl">
            <span> @{{ handle }} </span>
          </div>
          <div v-else>
            <div class="_STn_lst_dtl">
              <div class="_STn_lst_dtl">
                <div>www.website.com/@{{ handle }}</div>
              </div>
              <div class="_STn_lst_dtl">
                <input
                  v-on:input="velidateHandle"
                  type="text"
                  v-model="handle"
                  class="_STn_lst_inpt"
                />
              </div>
            </div>
            <div class="_STn_lst_dtl">
              <button
                class="_STn_lst_save"
                :disabled="!enableSave"
                @click.prevent="SaveHandle()"
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
            class="_STn_lst_edit"
          >
            Edit
          </button>
          <button v-else @click.prevent="cancle()" class="_STn_lst_edit">Cancle</button>
        </div>
      </div>

      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Bio</strong>
          <div v-if="!editBio" class="_STn_lst_dtl">
            <span> {{ bio }} </span>
          </div>
          <div v-else>
            <div class="_STn_lst_dtl">
              <div class="_STn_lst_dtl">
                <div>Tell about yourself in few words.</div>
              </div>
              <div class="_STn_lst_dtl">
                <textarea
                  type="text"
                  v-on:change="validateBio"
                  v-model="bio"
                  class="_STn_lst_inpt"
                />
              </div>
            </div>
            <div class="_STn_lst_dtl">
              <button class="_STn_lst_save" :disabled="enableSave" @click="SaveBio">
                Save
              </button>
            </div>
          </div>
        </div>
        <div>
          <button
            v-if="!editBio"
            :disabled="edit"
            @click.prevent="BioEdit()"
            class="_STn_lst_edit"
          >
            Edit
          </button>
          <button v-else @click.prevent="cancle()" class="_STn_lst_edit">Cancle</button>
        </div>
      </div>

      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Email address</strong>
          <div v-if="!editEmail" class="_STn_lst_dtl">
            <span>
              {{ email }}
            </span>
          </div>
        </div>
      </div>

      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Phone Number</strong>
          <div v-if="!editNumber" class="_STn_lst_dtl">
            <span v-if="number == 'null'"> {{ number }} </span>
            <span v-else>Not provided</span>
          </div>
          <div v-else>
            <div class="_STn_lst_dtl">
              <div class="_STn_lst_dtl">
                <div>
                  Only visible to store after you buy product from respective store. For
                  confirmation and delivery purpose only.
                </div>
              </div>
              <div class="_STn_lst_dtl">
                <input
                  v-on:input="velidateHandle"
                  type="text"
                  v-model="number"
                  class="_STn_lst_inpt"
                />
              </div>
            </div>
            <div class="_STn_lst_dtl">
              <button
                class="_STn_lst_save"
                :disabled="!enableSave"
                @click.prevent="SaveNumber()"
              >
                Save
              </button>
            </div>
          </div>
        </div>
        <div>
          <button
            v-if="!editNumber"
            :disabled="edit"
            @click.prevent="NumberEdit()"
            class="_STn_lst_edit"
          >
            Edit
          </button>
          <button v-else @click.prevent="cancle()" class="_STn_lst_edit">Cancle</button>
        </div>
      </div>

      <div class="_STn_lst _STn_lst_flx">
        <div>
          <strong>Government Id</strong>
          <div v-if="!editName" class="_STn_lst_dtl">
            <span v-if="person.kyc == 'verified'"> Verified </span>
            <span v-else> Unverified </span>
          </div>
        </div>
        <div v-if="person.kyc == 'verified'">
          <button class="_STn_lst_edit">
            <svg
              version="1.1"
              id="Capa_1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px"
              y="0px"
              width="24px"
              height="24px"
              viewBox="0 0 910.288 910.287"
              style="enable-background: new 0 0 910.288 910.287"
              xml:space="preserve"
            >
              <path
                d="M873.206,202.06l-1.212-28.51l-28.386-2.915c-109.036-11.198-202.773-51.887-262.21-84.049
			c-65.099-35.226-104.56-68.274-104.922-68.579L455.165,0L433.84,17.981c-0.392,0.33-39.853,33.379-104.951,68.604
			c-59.437,32.162-153.173,72.851-262.209,84.049l-28.387,2.915l-1.212,28.51c-0.217,5.104-4.777,126.698,42.059,273.937
			c27.637,86.887,67.549,164.736,118.627,231.396c64.139,83.701,145.948,149.68,243.155,196.102l14.221,6.793l14.221-6.793
			c97.207-46.422,179.017-112.398,243.155-196.102c51.079-66.658,90.991-144.51,118.628-231.395
			C877.982,328.759,873.423,207.165,873.206,202.06z M455.143,836.93c-81.095-41.209-149.731-97.887-204.194-168.646
			c-46.393-60.275-82.812-130.998-108.248-210.201c-31.088-96.808-38.06-183.144-39.471-225.538
			c43.735-6.494,87.949-17.421,131.833-32.597c42.9-14.836,85.598-33.752,126.907-56.221c41.915-22.798,73.81-44.573,93.172-58.812
			c19.362,14.238,51.258,36.014,93.173,58.812c41.309,22.47,84.007,41.385,126.907,56.221
			c43.896,15.181,88.123,26.108,131.87,32.602c-1.359,41.978-8.194,127.098-38.842,223.443
			c-25.317,79.594-61.694,150.672-108.12,211.258C605.537,738.494,536.632,795.52,455.143,836.93z"
              />
              <polygon
                points="635.013,305.016 588.969,351.06 417.368,522.662 330.399,435.693 318.573,423.867 295.239,447.201 
			295.239,447.202 271.904,470.537 417.368,616 681.682,351.686 		"
              />
            </svg>
          </button>
        </div>
        <div v-else>
          <button :disabled="edit" @click="AddKYC()" class="_STn_lst_edit">Add</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import axios from "axios";
export default {
  props: {
    person: Object,
  },
  data() {
    return {
      name: this.person.name,
      handle: this.person.slug,
      number: this.person.number,
      email: this.person.email,
      bio: this.person.bio,
      photo: this.person.profile_image,
      edit: false,
      editName: false,
      editEmail: false,
      editBio: false,
      editHandle: false,
      editNumber: false,
      enableSave: false,
      color: "#111111",
    };
  },
  methods: {
    cancle() {
      if (this.editName) {
        this.name = this.person.name;
      }
      if (this.editHandle) {
        this.handle = this.person.slug;
      }
      if (this.editAbout) {
        this.about = this.person.meta_description;
      }
      if (this.editNumber) {
        this.number = this.person.number;
      }
      if (this.editBio) {
        this.bio = this.person.bio;
      }
      this.reset();
    },
    reset() {
      this.editName = false;
      this.editHandle = false;
      this.edit = false;
      this.enableSave = false;
      this.editEmail = false;
      this.editNumber = false;
      this.editBio = false;
    },
    NameEdit() {
      this.editName = true;
      this.edit = true;
      this.enableSave = false;
    },

    NumberEdit() {
      this.editNumber = true;
      this.edit = true;
      this.enableSave = false;
    },

    EmailEdit() {
      this.editEmail = true;
      this.edit = true;
      this.enableSave = false;
    },
    HandleEdit() {
      this.editHandle = true;
      this.edit = true;
      this.enableSave = false;
    },
    BioEdit() {
      this.editBio = true;
      this.edit = true;
      this.enableSave = false;
    },
    SaveName() {
      let nameData = new FormData();
      nameData.append("name", this.name);
      nameData.append("userId", this.person.id);
      axios
        .post(this.$siteURL + "/account/update/name", nameData)
        .then((res) => {
          this.reset();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateProfile(e) {
      let profileData = new FormData();
      profileData.append("image", e.target.files[0]);
      profileData.append("userId", this.person.id);

      axios
        .post(this.$siteURL + "/account/profile/upload", profileData, {
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
          this.photo = res.data.image;
        })
        .catch((error) => {
          console.log(error);
        });
      console.log("UPDate");
    },
    SaveBio() {
      let bioData = new FormData();
      bioData.append("bio", this.bio);
      bioData.append("userId", this.person.id);
      axios
        .post(this.$siteURL + "/account/post/bio", bioData)
        .then((res) => {
          this.reset();
        })
        .catch((error) => {
          console.log(error);
        });
      this.enableSave = false;
    },
    SaveNumber() {},
    AddKYC() {
      window.location.href = this.$siteURL + "/account/settings/gov";
    },
    SaveHandle() {
      let handleData = new FormData();
      handleData.append("handle", this.handle);
      handleData.append("userId", this.person.id);
      axios
        .post(this.$siteURL + "/account/update/handle", handleData)
        .then((res) => {
          this.reset();
          this.handle = this.handle;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    velidateHandle: _.debounce(function (e) {
      var handleRegx = /^[a-zA-Z]+[a-zA-Z0-9-_]{6,}$/;

      if (handleRegx.test(this.handle)) {
        let handleData = new FormData();
        handleData.append("handle", this.handle);
        axios
          .post(this.$siteURL + "/account/validate/handle", handleData)
          .then((res) => {
            this.enableSave = true;
          })
          .catch((error) => {
            console.log(error);
          });
      }
      if (this.handle.length < 6) {
        this.enableSave = false;
        this.handle = this.studio.slug;
      }
    }, 500),
    velidateName: _.debounce(function (e) {
      var userRegx = /^[a-zA-Z]+[a-zA-Z ]{6,}$/;

      if (userRegx.test(this.name)) {
        this.enableSave = true;
      } else {
        this.enableSave = false;
      }
    }, 500),
    validateBio: _.debounce(function (e) {
      if (this.bio.length != this.person.bio) {
        this.enableSave = true;
      } else {
        this.enableSave = false;
      }
    }, 500),
    validateEmail: _.debounce(function (e) {
      var userRegx = /^[a-zA-Z]+[a-zA-Z ]{6,}$/;

      if (userRegx.test(this.name)) {
        this.enableSave = true;
      } else {
        this.enableSave = false;
      }
    }, 500),
  },
};
</script>
