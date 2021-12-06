<template>
  <div>
    <div>
      <div>
        <button @click.prevent="showBox" class="_SO_btn">
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
            :class="showoff.have_commented ? 'haveComment' : 'haveNoComment'"
          >
            <path
              d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"
            ></path>
          </svg>
        </button>
      </div>
    </div>
    <div v-show="commentDialog" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <button @click.prevent="closeBoard()" class="_SO_d_bx">X</button>
              <h3>Comments</h3>
            </div>

            <div class="_SO_d_b">
              <div v-if="viewer.kyc == 'verified'" class="comment-post-story">
                <div class="mb-m">
                  Remember to keep comments respectful and follows our
                  <a
                    href="https://cubehall.notion.site/Community-Guidelines-65526fd084a84aebaacfd1f7186ff62e"
                    class="_cg_link"
                    target="_blank"
                  >
                    community guidelines</a
                  >. Rethink your comment?
                </div>
                <div class="cmnt-flx-wrap">
                  <div class="story-cmnt-profile round_full" style="margin-right: 15px">
                    <img
                      class="stry-profile-img"
                      :src="$siteURL + '/images/profile/thumb/' + viewer.profile_image"
                      alt=""
                    />
                  </div>
                  <!-- <span class="textarea" role="textbox" contenteditable :comment="comment"></span> -->
                  <auto-textarea
                    v-on:input="validateComment"
                    v-model="comment"
                  ></auto-textarea>
                  <div class="btndivcmnt">
                    <button
                      @click.prevent="postComment"
                      :disabled="!enablePost"
                      class="saCbTn"
                    >
                      Post
                    </button>
                  </div>
                </div>
              </div>
              <div v-else class="comment-post-story">
                <div class="cmnt-flx-wrap">
                  <div class="mb-m">
                    <span>
                      Please verify your identity to be able to share your opinion.
                    </span>
                  </div>
                </div>
              </div>
              <div v-if="comments">
                <div v-for="(comment, index) in comments" v-bind:key="comment.id">
                  <div class="cmnt-flx-wrap mb-25">
                    <div class="story-cmnt-profile round_full">
                      <img
                        class="stry-profile-img"
                        :src="`${$siteURL}/images/profile/thumb/${comment.owner.profile_image}`"
                      />
                    </div>
                    <div class="cmts-whole">
                      <div class="flx">
                        <div class="cmt-wrap">
                          <div>
                            <strong>{{ comment.owner.name }}</strong>
                          </div>
                          <div>
                            {{ comment.comment }}
                          </div>
                        </div>

                        <div v-if="comment.owner.id == viewer.id">
                          <show-off-comment-remove
                            :id="comment.id"
                            :index="index"
                          ></show-off-comment-remove>
                        </div>
                      </div>
                      <div>
                        <comment-react :comment="comment"></comment-react>
                        <show-off-comment-reply
                          :comment="comment"
                          :item="showoff"
                          :viewer="viewer"
                        ></show-off-comment-reply>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="loadmore" v-show="canLoadMore">
                <button
                  :disabled="isLoading"
                  class="btn btn-third btn-normalize loading"
                  @click.prevent="loadMore"
                >
                  <span v-show="isLoading">
                    <span>Loading</span>
                    <span class="loader" v-for="i in 3" :key="i">
                      <span>.</span>
                    </span>
                  </span>
                  <span v-show="!isLoading">Load More</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style></style>

<script>
import _, { slice } from "lodash";
import EventBus from "../eventBus";
import AutoTextarea from "./AutoTextArea";
import ShowOffCommentReply from "./ShowoffCommentReply.vue";
import CommentReact from "./CommentReact";
import ShowOffCommentRemove from "./ShowOffCommentRemove.vue";
export default {
  name: "showoffComment",
  data() {
    return {
      commentDialog: false,
      comments: [],
      comment: "",
      enablePost: false,
      isLoading: false,
      canLoadMore: true,
      data: null,
    };
  },
  props: ["showoff", "viewer"],
  components: {
    AutoTextarea,
    ShowOffCommentReply,
    CommentReact,
    ShowOffCommentRemove,
  },
  mounted() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const i = urlParams.get("search_product");
    const p = urlParams.get("comment_tab");
    if (p) {
      this.showBox();
    }
  },
  methods: {
    showBox() {
      this.commentDialog = true;
      this.getComments();
    },
    closeBoard() {
      this.commentDialog = false;
    },
    getComments() {
      if (this.comments.length == 0) {
        axios
          .get(this.$siteURL + "/get/s/comments/" + this.showoff.id)
          .then((res) => {
            let a = Object.values(res.data.data);
            this.data = res.data;
            if (this.data.current_page == this.data.last_page) {
              this.canLoadMore = false;
            }
            a.forEach((e) => {
              this.comments.push(e);
            });
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    remove(i) {
      this.comments.splice(i, 1);
    },
    loadMore() {
      if (this.data) {
        if (this.data.current_page < this.data.last_page) {
          this.page = this.data.current_page + 1;
        } else {
          this.canLoadMore = false;
          return true;
        }
      } else {
        this.page = 1;
      }
      axios
        .get(
          this.$siteURL +
            "/get/s/comments/" +
            this.showoff.id +
            "?type=" +
            "&page=" +
            this.page
        )
        .then((res) => {
          let a = Object.values(res.data.data);
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          a.forEach((e) => {
            this.comments.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    validateComment: _.debounce(function (e) {
      if (this.comment.length > 0) {
        this.enablePost = true;
      } else {
        this.enablePost = false;
      }
    }, 200),
    postComment() {
      let commentData = new FormData();
      commentData.append("comment", this.comment);
      commentData.append("item_id", this.showoff.id);
      axios.interceptors.request.eject(this.interceptor);
      axios
        .post(this.$siteURL + "/post/s/comment/", commentData)
        .then((res) => {
          this.comment = "";
          this.comments.unshift(res.data);
          this.showoff.comments_count++;
          this.showoff.haveComment = true;
          this.showoff.have_commented = true;
          EventBus.$emit("emptyComment", true);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
<style scoped>
.haveComment {
  fill: var(--gray-very-dark);

  stroke: var(--gray-very-dark);
}
.haveNoComment {
  fill: none;
  stroke: var(--gray-very-dark);
}
._cg_link {
  color: var(--blue-dark);
  text-decoration: underline;
}
</style>
