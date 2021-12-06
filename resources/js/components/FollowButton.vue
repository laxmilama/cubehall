<template>
  <div>
    <span class="btn-primary btn-normalize" v-show="!isFollowing" @click="follow()"
      >Follow</span
    >
  </div>
</template>

<script>
export default {
  name: "Follow",
  props: {
    studio: Object,
  },
  data() {
    return {
      isFollowing: this.studio.is_followed,
    };
  },
  methods: {
    follow() {
      let followData = new FormData();
      followData.append("userId", this.studio.user_id);
      followData.append("pageId", this.studio.id);

      axios
        .post(this.$siteURL + "/follow/studio", followData)
        .then((res) => {
          this.isFollowing = true;
          Vue.$emit("updateFollow", this.studio.id);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
<style scoped>
.unfollow-model {
  display: flex;
  position: absolute;
  width: max-content;
  padding: 15px;
  transform: translateX(-50%) translateY(-50%);
  background: var(--gray-light);
  max-width: 200px;
}
</style>
