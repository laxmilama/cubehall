<template>
  <div>
    <div>
      <div>
        <button @click.prevent="showBoards">
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
            class="feather feather-bookmark"
          >
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
          </svg>
          <span>save</span>
        </button>
      </div>
    </div>
    <div v-show="saveDiag" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button @click.prevent="closeSave()" class="_SO_d_bx">X</button>
              <h3>Save to Moodboard</h3>
            </div>
            <div class="_SO_d_b">
              <div class="SO_list _SO_b_create round_c_s">
                <div class="_SO_b_l" @click.prevent="createBoard()">
                  <div style="display: flex">
                    <div class="_SO_img_wrap round_c_s _SO_crt_n_MB">
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
                        class="_SO_plus"
                      >
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                      </svg>
                    </div>
                    <div>
                      <h2 class="typography-headline4">Create New MoodBoard</h2>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="SO_list round_c_s"
                v-for="(board, index) in boards"
                v-bind:key="board.id"
              >
                <div @click="save(index)" class="_SO_b_l">
                  <div style="display: flex">
                    <div v-if="board.thumb" class="_SO_img_wrap round_c_s">
                      <img
                        v-if="board.thumb.type === 'ProductList'"
                        :src="`${$siteURL}/images/product/thumb/${board.thumb.image}`"
                        class="_SO_img"
                      />
                      <img
                        v-if="board.thumb.type === 'ShowOff'"
                        :src="`${$siteURL}/images/showoff/thumb/${board.thumb.media}`"
                        class="_SO_img"
                      />
                    </div>
                    <div v-else class="_SO_img_wrap round_c_s">
                      <img :src="`${$siteURL}/assets/lightBulb.png`" class="_SO_img" />
                    </div>
                    <div>
                      <h2 class="typography-headline4">{{ board.name }}</h2>
                    </div>
                  </div>

                  <div class="_SO_private" v-if="board.private === 'true'">
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
                      class="feather feather-lock"
                    >
                      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                      <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-show="newBoard" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button class="_SO_d_bx" @click.prevent="closeNewBoard()">X</button>
              <h3>Create New ModeBoard</h3>
            </div>
            <div class="_SO_d_b">
              <div>
                <input
                  class="_SO_input round_c_s"
                  v-model="name"
                  type="text"
                  placeholder="Board Name"
                />
              </div>
              <div>
                <label class="_SO_t_lbl" for="visibility">Private MoodBoard</label>
                <input type="checkbox" id="visibility" v-model="visibility" />
              </div>
              <div class="_SO_cbtn_div">
                <button
                  class="Create round_c_s _SO_create_BTN typography-headline5"
                  @click.prevent="saveBoard()"
                >
                  Create
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
._SO_crt_n_MB {
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--gray-very-dark);
}
._SO_plus {
  height: 35px;
  width: 35px;
  stroke: var(--bg-color);
}
._SO_input {
  width: 100%;
  box-sizing: border-box;
  height: 51px;
  font-size: 20px;
  padding: 15px;
}
._SO_t_lbl {
  font-size: 20px;
  margin-top: 20px;
  margin-bottom: 20px;
  display: inline-block;
  cursor: pointer;
}
._SO_img_wrap {
  height: 80px;
  width: 80px;
  position: relative;
  margin-right: 15px;
}
._SO_img {
  position: absolute;
  object-fit: cover;
  height: 100%;
  width: 100%;
}
._SO_private {
  padding-right: 10px;
}
._SVsf {
  position: fixed;
  z-index: 2000 !important;
}
._SO_overlay {
  z-index: 2000 !important;
  position: fixed !important;
  inset: 0px !important;
  overflow-y: auto !important;
  background: rgba(34, 34, 34, 0.5) !important;
  align-items: center;
}
._SO_card {
  -webkit-box-pack: center !important;
  -webkit-box-align: end !important;
  -webkit-box-direction: normal !important;
  -webkit-box-orient: horizontal !important;
  z-index: 2000 !important;
  position: fixed !important;
  inset: 0px !important;
  max-height: calc(var(--vh, 1vh) * 100) !important;
  padding-top: 12px !important;
  display: flex !important;
  flex-direction: row !important;
  align-items: center !important;
  justify-content: center !important;
  padding: 20px;
}
._SO_dialog {
  max-width: 568px !important;
  -webkit-box-direction: normal !important;
  -webkit-box-orient: vertical !important;
  background: var(--gray-very-light) !important;
  position: relative !important;
  width: 100vw !important;
  max-height: 100% !important;
  display: flex !important;
  flex-direction: column !important;
  box-shadow: rgb(0 0 0 / 28%) 0px 8px 28px !important;
}
._SO_d_t {
  display: flex;
  justify-content: center;
}
._SO_d_bx {
  position: absolute;
  left: 25px;
  top: 20px;
}
._SO_d_b {
  padding: 20px;
  overflow: auto;
}
._SO_b_l {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.SO_list {
  padding: 5px;
  cursor: pointer;
}
.SO_list:hover {
  background: var(--gray-light);
}
._SO_create_BTN {
  width: 100%;
  height: 50px;
  margin-top: 25px;
  background-color: var(--gray-very-dark);
  color: var(--bg-color);
}
._SO_cbtn_div {
  border-top: solid 1px var(--gray-light);
}
@media only screen and (max-width: 600px) {
  ._SO_img_wrap {
    height: 60px;
    width: 60px;
  }
  ._SO_dialog {
    max-width: 100vw !important;
  }
  ._SO_card {
    padding: 0px;
    padding-top: 0px !important;
  }
  ._SO_d_b {
    padding: 10px;
  }
}
</style>

<script>
export default {
  name: "Save",
  props: {
    item: Object,
  },
  data() {
    return {
      isSaved: this.item.is_saved,
      boardId: 0,
      visibility: false,
      name: "",
      boards: null,
      saveDiag: false,
      newBoard: false,
    };
  },
  methods: {
    save(i) {
      let saveData = new FormData();
      saveData.append("itemId", this.item.id);
      saveData.append("boardId", this.boards[i].id);
      saveData.append("type", this.item.type);
      axios
        .post(this.$siteURL + "/showoff/save/board", saveData)
        .then((res) => {
          this.saveDiag = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    createBoard() {
      this.newBoard = true;
    },
    closeNewBoard() {
      this.newBoard = false;
    },
    showBoards() {
      this.saveDiag = true;
      this.boards = this.listBoards();
    },
    closeSave() {
      this.saveDiag = false;
    },
    saveBoard() {
      let boardData = new FormData();
      boardData.append("name", this.name);
      boardData.append("visibility", this.visibility);
      axios
        .post(this.$siteURL + "/board/save", boardData)
        .then((res) => {
          this.boards.unshift(res.data);
          this.newBoard = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    listBoards() {
      axios.get(this.$siteURL + "/user/get/board").then((result) => {
        this.boards = result.data;
      });
    },
  },
};
</script>
