<template>
  <div>
    <span
      class="btn-secondary btn-normalize"
      v-if="isFollowing"
      @click="showUnfollow"
      ref="flg"
    >
      Following
    </span>
    <span class="btn-normalize follow-btn" v-show="!isFollowing" @click="follow()"
      >Follow</span
    >
    <div
      class="unfollow-model round_c_m"
      v-if="unfollowDialogBox"
      v-closable="{
        exclude: ['flg'],
        handler: 'cancle',
      }"
    >
      <div style="text-align: center">
        <section class="_unFlw_hd">Unfollow?</section>
        <section class="_unFlw_msg">
          Are you sure you want to unfollow @{{ slug }}?
        </section>
        <div class="_unFlw_action">
          <button class="btn-normalize btn-third _unFlw_yes" @click="unfollow()">
            Yes
          </button>
          <button class="_unFlw_cncl" @click="cancle()">Cancle</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FollowUserButton",
  props: ["pid", "is_following", "slug"],
  data() {
    return {
      unfollowDialogBox: false,
      isFollowing: this.is_following,
    };
  },
  methods: {
    follow() {
      let followData = new FormData();
      followData.append("userId", this.pid);

      axios
        .post(this.$siteURL + "/follow/user", followData)
        .then((res) => {
          this.isFollowing = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    unfollow() {
      axios
        .delete(this.$siteURL + "/unfollow/user/" + this.pid)
        .then((res) => {
          this.isFollowing = false;
          this.unfollowDialogBox = false;
        })
        .catch((error) => {
          console.log(error);
        });
      // unfollow
    },
    showUnfollow() {
      // Unfollow
      this.unfollowDialogBox = true;
    },
    cancle() {
      this.unfollowDialogBox = false;
    },
  },
};
</script>
<style scoped>
.unfollow-model {
  display: flex;
  position: fixed;
  width: max-content;
  padding: 20px;
  transform: translateX(-50%) translateY(-50%);
  background: var(--gray-very-light);
  max-width: 200px;
  top: 50%;
  left: 50%;
  box-shadow: 0 0 30px #00000082;
  color: var(--gray-very-dark);
  z-index: 1;
}
._unFlw_hd {
  font-weight: 800;
}
._unFlw_msg {
  margin-top: 15px;
  margin-bottom: 15px;
}
._unFlw_action {
  display: flex;
  flex-direction: column;
}
._unFlw_yes {
  width: 100%;
  font-size: 16px;
  font-weight: 600;
  display: flex;
  justify-content: center;
}
._unFlw_cncl {
  width: 100%;
  display: flex;
  justify-content: center;
  margin-top: 8px;
  background: none;
  border: none;
  font-weight: 600;
  padding: 10px;
  font-size: 16px;
}
._unFlw_overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  opacity: 0.25;
  background-color: black;
  z-index: -10;
  pointer-events: all;
}
.follow-btn {
  background: var(--primary-color);
  color: var(--gray-very-light);
}
</style>
