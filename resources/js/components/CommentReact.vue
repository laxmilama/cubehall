<template>
  <div>
    <button @click.prevent="toggleReact" class="cmtreact">
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
        :class="comment.have_reacted ? 'cmtReacted' : 'no_reaction'"
      >
        <path
          d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
        ></path>
      </svg>
      <span class="cmt-count" v-if="comment.reacts_count > 0">
        {{ comment.reacts_count }}
      </span>
    </button>
  </div>
</template>
<script>
export default {
  name: "CommentReact",
  props: {
    comment: Object,
  },
  methods: {
    toggleReact() {
      console.log(this.comment.id);
      if (!this.comment.have_reacted) {
        let reactData = new FormData();
        reactData.append("commentId", this.comment.id);
        axios
          .post(this.$siteURL + "/post/comment/react", reactData)
          .then((res) => {
            this.comment.have_reacted = true;

            // increase react count
            this.comment.reacts_count++;
          })
          .catch((error) => {
            console.log(eror);
          });
        //
      } else {
        axios
          .delete(this.$siteURL + "/delete/comment/react/" + this.comment.id)
          .then((res) => {
            //
            this.comment.have_reacted = false;

            // decrease react count
            this.comment.reacts_count--;
          })
          .catch((error) => {
            //
          });
      }
    },
  },
};
</script>
<style>
.cmtReacted {
  fill: var(--primary-color);
  stroke: var(--primary-color);
}
.cmtreact {
  display: flex;
  align-items: center;
  background: transparent;
  border: none;
  outline-style: none;
}
.cmt-count {
  margin: 5px;
  color: var(--gray-very-dark);
}
.no_reaction {
  stroke: var(--gray-very-dark);
}
</style>
