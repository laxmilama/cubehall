<template>
  <div v-if="creators.length > 0" style="display: flex; flex-direction: column">
    <div class="DC_studio_card" v-for="(creator, i) in creators" :key="i">
      <div class="DC_studio_head">
        <div class="flex-box">
          <div>
            <div class="DC_studio-profile round_full">
              <img
                :src="`${$siteURL}/images/profile/thumb/` + creator.profile_image"
                class="DC_studio-profile-img"
              />
            </div>
          </div>
          <div>
            <div>
              <span>{{ truncateName(creator.name) }}</span>
            </div>
            <div>{{ creator.followers }} followers</div>
          </div>
        </div>
        <div>
          <follow-studio-basic
            :sid="creator.id"
            :is_following="creator.is_followed"
          ></follow-studio-basic>
        </div>
      </div>
      <div class="DC_studio_body">
        <div class="DC_studio-box" v-for="(thumb, j) in creator.products" :key="j">
          <img
            :src="`${$siteURL}/images/product/thumb/` + thumb.thumbnail"
            class="DC_studio-profile-img"
          />
        </div>
        <template>
          <div class="DC_studio-box" v-for="(thumb, k) in creator.parlors" :key="k">
            <img
              :src="`${$siteURL}/images/parlor/thumb/` + thumb.thumbnail"
              class="DC_studio-profile-img"
            />
          </div>
        </template>
      </div>
    </div>
    <div class="loadmore" v-if="canLoadMore">
      <button
        :disabled="isLoading"
        class="btn btn-third btn-normalize loading"
        @click.prevent="getResults"
      >
        <span v-if="isLoading">Loading...</span>
        <span v-else>Load More</span>
      </button>
    </div>
  </div>
</template>

<script>
import FollowStudioBasic from "./FollowStudioBasic.vue";
export default {
  components: { FollowStudioBasic },
  data() {
    return {
      creators: [],
      data: null,
      page: 0,
      isLoading: false,
      canLoadMore: true,
    };
  },
  methods: {
    truncateName(string) {
      var n = string;
      if (string.length > 20) {
        n = string.substring(0, 20) + "..";
      }
      return n;
    },
    getResults() {
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
        .get(this.$siteURL + "/get/creators/discover?page=" + this.page)
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          Object.values(res.data.data).forEach((e) => {
            this.creators.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getResults();
  },
};
</script>
