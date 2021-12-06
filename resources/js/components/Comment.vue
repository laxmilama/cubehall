<template>
  <div class="">
    <button class="act-btn-stry story-btn-rct" @click="expandComments">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="25"
        height="25"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        :class="{ haveComment: story.have_commented }"
      >
        <path
          d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"
        ></path>
      </svg>
      <label for="" class="act-lbl">{{ story.comments_count }}</label>
    </button>
    <div v-if="showComments" class="sty-cmnt">
      <div class="stcmnt-wrap">
        <div class="stry-cmt-top">
          <button class="stryCross" @click="closeComment">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="var(--gray-very-dark)"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="white-stroke"
            >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
          <h3>Comments</h3>
        </div>
        <div class="scroll-cmnt">
          <div>
            <div class="comment-post-story">
              <div class="cmnt-flx-wrap">
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
                    <div class="flx cnt-margin">
                      <div class="cmt-wrap">
                        <div>
                          <strong>{{ comment.owner.name }}</strong>
                        </div>
                        <div>
                          {{ comment.comment }}
                        </div>
                      </div>

                      <div v-if="comment.owner.id == viewer.id">
                        <comment-remove :id="comment.id" :index="index"></comment-remove>
                      </div>
                    </div>
                    <div>
                      <comment-react :comment="comment"></comment-react>
                      <comment-reply
                        :comment="comment"
                        :story="story"
                        :viewer="viewer"
                      ></comment-reply>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="isLoading">Loading.....</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _, { slice } from "lodash";
import EventBus from "../eventBus";
import AutoTextarea from "./AutoTextArea";
import CommentReply from "./CommentReply";
import CommentReact from "./CommentReact";
import CommentRemove from "./CommentRemove";
export default {
  props: {
    story: Object,
    viewer: Object,
  },
  data() {
    return {
      showComments: false,
      isLoading: false,
      comments: null,
      comment: "",
      enablePost: false,
      showRemove: false,
    };
  },
  components: {
    AutoTextarea,
    CommentReply,
    CommentReact,
    CommentRemove,
  },
  methods: {
    expandComments() {
      this.showComments = true;
      // this.$emit("emitPause", true);
      EventBus.$emit("COMMENT", true);

      this.getComments();
    },
    closeComment() {
      EventBus.$emit("COMMENT", false);
      this.showComments = false;
    },
    getComments() {
      if (this.comments == null) {
        axios
          .get(this.$siteURL + "/get/comments/" + this.story.id)
          .then((res) => {
            this.comments = res.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    postComment() {
      let commentData = new FormData();
      commentData.append("comment", this.comment);
      commentData.append("item_id", this.story.id);
      axios.interceptors.request.eject(this.interceptor);
      axios
        .post(this.$siteURL + "/post/comment/", commentData)
        .then((res) => {
          this.comments.unshift(res.data);
          this.story.comments_count++;
          this.story.haveComment = true;
          this.story.have_commented = true;
          this.comment = "";
          EventBus.$emit("emptyComment", true);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    removeDialog() {
      this.showRemove = true;
    },
    remove(index) {
      this.story.comments_count--;
      this.story.comments_count =
        this.story.comments_count - this.comments[index].replies_count;
      this.comments.splice(index, 1);
    },
    updateCommented(value) {
      this.story.have_commented = value;
      this.story.comments_count++;
    },
    validateComment: _.debounce(function (e) {
      if (this.comment.length > 0) {
        this.enablePost = true;
      } else {
        this.enablePost = false;
      }
    }, 200),
  },
  mounted() {
    let that = this;
    let interceptor = axios.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    axios.interceptors.response.use(
      function (response) {
        that.isLoading = false;
        return response;
      },
      function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        return Promise.reject(error);
      }
    );
    // axios.interceptors.request.eject(interceptor);
  },
};
</script>
<style>
.scroll-cmnt {
  overflow-y: auto;
  overflow-wrap: break-word;
  height: calc(100% - 150px);
  padding: 0 15px;
}
.story-cmnt-profile {
  height: 50px;
  width: 50px;
  flex-shrink: 0;
}
.stry-profile-img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}

.stryCross {
  background: transparent;
  height: 40px;
  width: 40px;
  border: none;
  outline-style: none;
  position: absolute;
  left: 5px;
  top: 10px;
}
.sty-cmnt {
  display: block;
  background: rgba(0, 0, 0, 0.219);
  position: fixed;
  left: 0;
  bottom: 0;
  height: 100%;
  width: 100%;
  z-index: 1000;
}
.stcmnt-wrap {
  height: 80%;
  width: 100%;
  bottom: 0;
  background: var(--bg-color);
  position: absolute;
  border-top-left-radius: 30px;
  border-top-right-radius: 30px;
  box-shadow: 0 0 10px rgba(0, 0, 0);
}
.stry-cmt-top {
  display: flex;
  justify-content: center;
}
.haveComment {
  fill: var(--gray-very-light);
}
.comment-post-story {
  position: relative;
  height: auto;
  width: 100%;
  z-index: 1200;
}
.saCbTn {
  width: 100%;
  position: absolute;
  bottom: 20px;
  background: transparent;
  border: none;
  color: var(--gray-very-dark);
}
.btndivcmnt {
  width: 22%;
  position: relative;
}
.cmnt-flx-wrap {
  display: flex;
  width: 100%;
  position: relative;
}
.mb-25 {
  margin-bottom: 25px;
}

.cmt-wrap {
  width: 100%;
}

.cmts-whole {
  width: 100%;
  margin-left: 15px;
}
@media only screen and (max-width: 600px) {
  .story-cmnt-profile {
    height: 35px;
    width: 35px;
    flex-shrink: 0;
  }
}
</style>
