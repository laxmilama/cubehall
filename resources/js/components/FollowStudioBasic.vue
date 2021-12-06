<template>
  <div>
    <span class="btn-primary btn-normalize" v-show="!isFollowing" @click="follow()"
      >Follow</span
    >
  </div>
</template>
<style>
._basicFollowText {
  font-size: 14px;
  color: #047c8a;
  font-weight: 400;
  letter-spacing: 0.25px;
}
</style>

<script>
export default {
  name: "FollowStudio",

  props: ["sid", "is_following"],
  data() {
    return {
      unfollowDialogBox: false,
      isFollowing: this.is_following,
      color: null,
    };
  },
  methods: {
    follow() {
      let followData = new FormData();
      followData.append("pageId", this.sid);

      axios
        .post(this.$siteURL + "/follow/studio", followData)
        .then((res) => {
          this.isFollowing = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
