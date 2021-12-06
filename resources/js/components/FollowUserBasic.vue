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
  name: "Follow",
  props: ["pid", "is_following"],
  data() {
    return {
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
  },
};
</script>
