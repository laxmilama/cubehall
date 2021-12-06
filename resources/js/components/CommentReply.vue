<template>
  <div class="reply-wrapper">
    <div class="st-btnRply">
      <button @click.prevent="expandReply" class="reply-btn">Reply</button>
    </div>
    <div>
      <div v-if="comment.replies_count > 0">
        <a
          class="view-reply-lnk"
          v-if="!replyExpanded"
          href=""
          @click.prevent="expandReply"
          >View {{ comment.replies_count }} reply
        </a>
        <a class="view-reply-lnk" v-else href="" @click.prevent="collapseReply"
          >Hide {{ comment.replies_count }} Reply
        </a>
      </div>
      <div v-show="replyExpanded">
        <div class="comment-post-">
          <div class="cmnt--wrap">
            <!-- <span class="textarea" role="textbox" contenteditable :comment="comment"></span> -->
            <auto-textarea v-on:input="validateReply" v-model="reply"></auto-textarea>
            <div class="">
              <button @click.prevent="postReply" :disabled="!enablePost" class="">
                Post
              </button>
            </div>
          </div>
        </div>
        <div>
          <div v-for="(reply, index) in replies" :key="reply.id">
            <div class="cmnt-flx-wrap mb-25">
              <div class="story-cmnt-profile round_full">
                <img
                  class="stry-profile-img"
                  :src="`${$siteURL}/images/profile/thumb/${reply.owner.profile_image}`"
                />
              </div>
              <div style="width: 100%">
                <div>
                  <div>
                    <strong>{{ reply.owner.name }}</strong>
                  </div>
                  <div>
                    {{ reply.comment }}
                  </div>
                </div>
                <div>
                  <comment-react :comment="reply"></comment-react>
                </div>
              </div>
              <div v-if="reply.owner.id == viewer.id">
                <comment-remove :id="reply.id" :index="index"></comment-remove>
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
import EventBus from "../eventBus";
import AutoTextarea from "./AutoTextArea";
import CommentReact from "./CommentReact";
import CommentRemove from "./CommentRemove";
export default {
  name: "CommentReply",
  props: {
    comment: Object,
    story: Object,
    viewer: Object,
  },
  components: {
    AutoTextarea,
    CommentReact,
    CommentRemove,
  },
  data() {
    return {
      replies: null,
      replyExpanded: false,
      enablePost: false,
      reply: "",
    };
  },
  methods: {
    expandReply() {
      this.replyExpanded = true;
      this.getReplies();
    },
    collapseReply() {
      this.replyExpanded = false;
    },
    getReplies() {
      if (this.replies == null) {
        axios
          .get(this.$siteURL + "/get/comments/reply/" + this.comment.id)
          .then((res) => {
            this.replies = res.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    remove(i) {
      this.replies.splice(i, 1);
    },
    postReply() {
      let replyData = new FormData();
      replyData.append("parentId", this.comment.id);
      replyData.append("comment", this.reply);
      replyData.append("storyId", this.story.id);

      axios
        .post(this.$siteURL + "/post/comment/reply", replyData)
        .then((res) => {
          this.replies.push(res.data);
          this.reply = "";
          this.comment.replies_count++;
          this.$parent.updateCommented(true);
          EventBus.$emit("emptyComment", true);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    validateReply: _.debounce(function (e) {
      if (this.reply.length > 0) {
        this.enablePost = true;
      } else {
        this.enablePost = false;
      }
    }, 200),
  },
};
</script>
<style>
.st-btnRply {
  position: absolute;
  top: -25px;
  left: 100px;
}
.reply-wrapper {
  position: relative;
}
.view-reply-lnk {
  text-decoration: none;
  color: rgb(25, 122, 187);
}
.reply-btn {
  background: transparent;
  font-weight: 800;
  border: none;
  outline-style: none;
  color: var(--gray-medium);
}
</style>
