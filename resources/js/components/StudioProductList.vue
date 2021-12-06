<template>
  <div>
    <div>
      <div>
        <h1>Products</h1>
      </div>
      <div>
        <div>
          <span
            >You have {{ studioSections.length }} collections for products.
            <a href="#manage" @click.prevent="openManage"> Manage </a>
          </span>
        </div>
      </div>
    </div>
    <div>
      <div v-for="(product, index) in items" :key="product.id" class="_AL_card">
        <div class="_AL_card _AL_container _AL_box">
          <div class="_AL_c36">
            <div class="_AL_cmg round_c_s">
              <img
                v-if="product.meta"
                img
                class="_AL_img"
                :src="`${$siteURL}/images/product/thumb/${product.meta.thumbnail}`"
              />
            </div>
            <div class="Amn_list-details">
              <div>
                <div>
                  {{ product.name }}
                </div>
                <div>
                  <span>
                    <span v-if="product.status" style="color: var(--gray-medium-dark)"
                      >Listed {{ humanizeTime(product.created_at) }} ago</span
                    >
                    <span v-else style="color: var(--gray-medium-dark)"
                      >Not Approved</span
                    >
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="Amn_list-actions">
            <ul>
              <li>
                <a :href="`${$siteURL}/studio/product/${product.slug}/edit`"
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
                    class="feather feather-edit-2"
                  >
                    <path
                      d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"
                    ></path>
                  </svg>
                  Edit
                </a>
              </li>
              <li>
                <a :href="`${$siteURL}/studio/product/analytics/${product.slug}`"
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
                    class="feather feather-bar-chart-2"
                  >
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                  </svg>
                  Analytics
                </a>
              </li>
              <li>
                <a :href="`${$siteURL}/studio/product/reviews/${product.slug}`"
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
                    class="feather feather-message-circle"
                  >
                    <path
                      d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"
                    ></path>
                  </svg>
                  Reviews
                </a>
              </li>
              <li>
                <a href="#" @click.prevent="showDeleteDialog(index, product.id)"
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
                    class="feather feather-trash-2"
                  >
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path
                      d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                    ></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                  </svg>
                  Delete</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div v-if="deleteDialog">
      <div class="vModel_overlay"></div>
      <div class="vModel_wrap">
        <div class="_vModel_card round_c_m">
          <div class="_vModel_del_msg">
            <h2>Permanently delete this product?</h2>
            <p>
              You won’t be able to find or edit your product list, and any future removed
              from search results.
            </p>
          </div>

          <div class="TCT_btns flex-box" style="padding: 25px">
            <button @click="cancle" class="btn-normalize btn-secondary">Cancle</button>
            <button @click="deleteItem" class="btn-third btn-normalize">
              Delete forever
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="manageBox">
      <div class="_SO_overlay"></div>
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <button @click="closeManage" class="_SO_d_bx">X</button>
            <h2 style="padding: 15px 0">Manage collections</h2>
          </div>
          <div class="_SO_d_b">
            <div>
              <span> Collections help shoppers browse your shop. </span>
            </div>
            <div>
              <div
                class="flex-box"
                style="justify-content: space-between; margin: 15px 0"
                v-for="(c, i) in studioSections"
                :key="i"
              >
                <div>
                  <strong>
                    {{ c.name }}
                  </strong>
                </div>
                <div class="flex-box" style="align-items: center">
                  <div>
                    <button>
                      <svg
                        width="24px"
                        height="24px"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M15.361 2.91158C16.5764 1.69614 18.547 1.69614 19.7625 2.91158L21.0884 4.23753C22.3039 5.45297 22.3039 7.4236 21.0884 8.63904L8.63904 21.0884C8.05536 21.6721 7.26373 22 6.43828 22H2.84882C2.38003 22 2 21.62 2 21.1512V17.5617C2 16.7363 2.32791 15.9446 2.91158 15.361L15.361 2.91158ZM18.5621 4.112C18.0096 3.55952 17.1138 3.55952 16.5614 4.112L14.2351 6.43828L17.5617 9.76491L19.888 7.43863C20.4405 6.88615 20.4405 5.99042 19.888 5.43794L18.5621 4.112ZM16.3613 10.9653L13.0347 7.6387L4.112 16.5614C3.84669 16.8267 3.69764 17.1865 3.69764 17.5617V20.3024H6.43828C6.81349 20.3024 7.17332 20.1533 7.43863 19.888L16.3613 10.9653Z"
                          fill="#030D45"
                        />
                      </svg>
                    </button>
                  </div>
                  <div>
                    <button @click="deleteCollection(c.id, i)">
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
                        class="feather feather-trash-2"
                      >
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path
                          d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                        ></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                      </svg>
                    </button>
                  </div>
                  <div>
                    <label class="switch">
                      <input
                        type="checkbox"
                        v-model="c.status"
                        @change="changeStatus(c.status, c.id)"
                      />
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div style="padding: 15px">
            <button
              @click="addNewBox"
              class="Create round_c_s _SO_create_BTN typography-headline5"
            >
              Add New Collection
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="newColBox">
      <div class="_SO_overlay"></div>
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <h2>Add new collection</h2>
          </div>
          <div class="_SO_d_b">
            <div>
              <label for="_secTitle">
                <span> Collection Name </span>
              </label>
              <input
                style="width: 100%"
                class="_inp_admn"
                type="text"
                id="_secTitle"
                v-model="collection"
              />
            </div>
          </div>
          <div class="flex-box TCT_btns" style="padding: 15px">
            <button @click="cancleCollection" class="btn-secondary btn-normalize">
              Cancle
            </button>
            <button @click="saveCollection" class="btn-primary btn-normalize">
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
export default {
  props: {
    products: Array,
    studioid: Number,
  },
  data() {
    return {
      deleteDialog: false,
      selectedItem: null,
      id: 0,
      items: this.products,
      studioSections: [],
      manageBox: false,
      collection: "",
      newColBox: false,
    };
  },
  methods: {
    openManage() {
      this.manageBox = true;
    },
    closeManage() {
      this.manageBox = false;
    },
    changeStatus(i, j) {
      let collData = new FormData();
      if (i) {
        collData.append("status", 1);
      } else {
        collData.append("status", 0);
      }
      axios
        .post(this.$siteURL + "/studio/collection/status/update/" + j, collData)
        .then((res) => {})
        .catch((err) => {
          console.log(err);
        });
    },
    deleteCollection(i, j) {
      axios
        .delete(this.$siteURL + "/studio/collection/delete/" + i)
        .then((res) => {
          this.studioSections.splice(j, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format();
    },
    humanizeTime(time) {
      var localTime = this.convertUTCToLocal(time);
      return moment(localTime).fromNow(true);
    },
    showDeleteDialog(index, id) {
      this.deleteDialog = true;
      this.selectedItem = index;
      this.id = id;
    },
    cancle() {
      this.deleteDialog = false;
    },
    deleteItem() {
      axios
        .delete(this.$siteURL + "/studio/product/delete/" + this.id + "/" + this.studioid)
        .then((res) => {
          console.log(res);
          this.deleteDialog = false;
          this.items.splice(this.selectedItem, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    addNewBox() {
      this.newColBox = true;
      this.manageBox = false;
    },
    saveCollection() {
      if (this.collection.length >= 3) {
        let collData = new FormData();
        collData.append("collection", this.collection);
        axios
          .post(this.$siteURL + "/studio/post/collection", collData)
          .then((res) => {
            this.collection = "";
            this.newColBox = false;

            this.studioSections.push(res.data);

            this.newCol = res.data.id;

            this.$toast.success("'" + res.data.name + "' added to your collection.", {
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
          })
          .catch((err) => {
            if (err.response.status == 429) {
              this.$toast.error("Collection already exists!", {
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
          });
      } else {
        this.$toast.error("Error! min length 3 character.", {
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
    },
    cancleCollection() {
      this.collection = "";
      this.newColBox = false;
      this.manageBox = true;
    },
  },
  mounted() {
    // get sections
    axios
      .get(this.$siteURL + "/studio/get/collection")
      .then((res) => {
        res.data.forEach((e) => {
          this.studioSections.push(e);
        });
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
<style>
.vModel_wrap {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1000;
  position: fixed;
  display: flex;
}
.vModel_overlay {
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1000;
  position: fixed;
  display: flex;
  -webkit-backdrop-filter: blur(2px);
  backdrop-filter: blur(2px);
}
._vModel_card {
  position: absolute;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  top: 50%;
  max-width: 400px;
  width: 400px;
  background: var(--gray-very-light);
  height: -webkit-min-content;
  height: -moz-min-content;
  height: min-content;
  max-height: 100%;
}
._vModel_del_msg {
  padding: 25px;
}
@media only screen and (max-width: 600px) {
  ._vModel_card {
    width: 95%;
  }
}
</style>
