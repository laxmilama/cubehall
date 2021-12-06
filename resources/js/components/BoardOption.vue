<template>
  <div>
    <div>
      <button @click="edit" class="_board_opt">
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
          class="feather feather-more-horizontal"
        >
          <circle cx="12" cy="12" r="1"></circle>
          <circle cx="19" cy="12" r="1"></circle>
          <circle cx="5" cy="12" r="1"></circle>
        </svg>
      </button>
    </div>
    <div v-if="editBox">
      <div class="_overlay">
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <h2>Edit</h2>
            </div>
            <div class="_SO_d_b">
              <div class="inp_g">
                <div>
                  <label for="_name"> Name </label>
                </div>
                <div>
                  <input
                    type="text"
                    class="inp_height inp_100"
                    v-model="board"
                    maxlength="50"
                  />
                  <div>
                    <span> 50 characters maximum </span>
                  </div>
                </div>
              </div>
              <div>
                <div class="divider-bar _op_sep"></div>
              </div>
              <div class="flex-box inp_g">
                <input type="checkbox" name="" id="_secret" v-model="is_private" />
                <label for="_secret">
                  <strong>Keep this board private</strong>
                  <div>
                    <span> Only you can see this board </span>
                  </div>
                </label>
              </div>
              <div>
                <div class="divider-bar _op_sep"></div>
              </div>
              <div class="inp_g">
                <button @click="enableDeleteBox" class="delete-btn">
                  Delete this board
                </button>
                <div>
                  <span> All saved items will be deleted forever.</span>
                </div>
              </div>
            </div>
            <div style="padding: 0 15px">
              <div class="st_btn_wrap">
                <button class="st_btn_back" @click.prevent="cancle">Cancle</button>
                <button class="btn-normalize btn-third" @click.prevent="save">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="deleteBox">
      <div class="_overlay">
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <h2>Delete this board</h2>
            </div>
            <div class="_SO_d_b">
              <div class="flex-box inp_g">
                <span> Are you sure you want to delete {{ name }}? </span>
              </div>
            </div>
            <div style="padding: 0 15px">
              <div class="st_btn_wrap">
                <button class="st_btn_back" @click.prevent="cancleDelete">Cancle</button>
                <button class="btn-normalize btn-third" @click.prevent="deleteBoard">
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["name", "slug", "privacy"],
  data() {
    return {
      editBox: false,
      deleteBox: false,
      board: this.name,
      is_private: this.privacy,
    };
  },
  methods: {
    save() {
      let bD = new FormData();
      bD.append("name", this.board);
      bD.append("privacy", this.is_private);
      axios
        .post(this.$siteURL + "/board/update/" + this.slug, bD)
        .then((res) => {
          this.editBox = false;
          this.$toast.success("Changes applied successfully.", {
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
          setTimeout(function () {
            location.reload();
          }, 2000);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    cancle() {
      this.editBox = false;
    },
    edit() {
      this.editBox = true;
    },
    enableDeleteBox() {
      this.deleteBox = true;
      this.editBox = false;
    },
    cancleDelete() {
      this.deleteBox = false;
      this.editBox = true;
    },
    deleteBoard() {
      axios
        .delete(this.$siteURL + "/board/delete/" + this.slug)
        .then((res) => {
          this.$toast.success("Board deleted successfully.", {
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
          setTimeout(function () {
            window.history.back();
          }, 2000);
        })
        .catch((err) => {
          this.$toast.success("Action failed", {
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
  },
};
</script>
<style>
._board_opt {
  height: 40px;
  width: 40px;
  border-radius: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--gray-light);
  border: none;
}
._op_sep {
  margin: 35px 10px !important;
}
.delete-btn {
  background: transparent;
  border: none;
  text-decoration: underline;
  padding: 0;
  color: var(--primary-color);
  font-weight: 800;
  font-size: 16px;
}
</style>
