<template>
  <div>
    <div v-if="btn">
      <div>
        <button class="_SO_btn" v-if="!isSaved" @click.prevent="showBoards">
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
            class="_SO_unsaved"
          >
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
          </svg>
        </button>
        <button class="_SO_btn" v-else @click.prevent="unsave">
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
            class="_SO_saved"
          >
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
          </svg>
        </button>
      </div>
    </div>
    <div v-show="saveDiag" class="_SVsf">
      <div class="_SO_overlay" @click.prevent="closeSave()"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button @click.prevent="closeSave()" class="_SO_d_bx">X</button>
              <h3>Save to board</h3>
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
                      <h2 class="typography-headline4">Create new board</h2>
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
                      <img :src="$siteURL + board.thumb" class="_SO_img" />
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
              <h3>Create New MoodBoard</h3>
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

<script>
import EventBus from "../eventBus";
export default {
  name: "Save",
  props: {
    item: Object,
    btn: Boolean,
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
      saveData.append("type", this.item.item_type);
      axios
        .post(this.$siteURL + "/showoff/save/board", saveData)
        .then((res) => {
          this.saveDiag = false;
          this.isSaved = true;
          EventBus.$emit("SAVED", true);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    unsave() {
      let saveData = new FormData();
      saveData.append("itemId", this.item.id);
      saveData.append("type", this.item.item_type);

      axios
        .post(this.$siteURL + "/unsave/board/item", saveData)
        .then((res) => {
          this.isSaved = false;
          EventBus.$emit("SAVED", false);
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
      axios.get(this.$siteURL + "/get/boards").then((result) => {
        this.boards = result.data;
      });
    },
  },
};
</script>
<style>
._SO_saved {
  fill: var(--gray-very-dark);
  stroke: var(--gray-very-dark);
}
._SO_unsaved {
  stroke: var(--gray-very-dark);
}
</style>
