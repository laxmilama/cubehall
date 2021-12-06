<template>
  <div class="">
    <div class="header _MBL-addPad">
      <h2 class="txt-wt typography-headline5">Top Creators</h2>
    </div>
    <div class="explore-studio-wrapper _MBL-scroll">
      <template v-if="studios">
        <template v-for="i in studios.length">
          <div v-if="i % 3 == 0" :key="i" class="explore-studio-card _MBL-scroll">
            <template v-for="j in i + 3">
              <template v-if="j < studios.length">
                <div :key="j" class="flex-box explore-studio-box">
                  <div class="explore-studio-num">
                    <span>{{ j }}</span>
                  </div>
                  <div class="explore-studio-list">
                    <div class="explore-img round_c_s">
                      <a :href="studios[j].slug">
                        <img
                          :src="`${$siteURL}/images/profile/small/' + ${studios[j].profile_image}`"
                        />
                      </a>
                    </div>
                    <div class="explore-studio-n-wrap">
                      <a class="explore-studio-name" :href="studios[j].slug">
                        <span>{{ studios[j].name }}</span>
                      </a>
                      <div>
                        <span class="explore-studio-counter">
                          {{ studios[j].followers_count }} Followers</span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </template>
          </div>
        </template>
      </template>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      studios: [],
    };
  },
  async mounted() {
    await axios
      .get(this.$siteURL + "/api/top/creators")
      .then((res) => {
        let a = Object.values(res.data.data);
        this.studios = a;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
