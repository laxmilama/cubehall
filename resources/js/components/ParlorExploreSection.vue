<template>
  <div class="flex-box _plr_btn_wrap">
    <div class="scrl_btn_wrap_left">
      <button class="scrl_btn" @click="scrollLeft">
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
          class="feather feather-chevron-left"
        >
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>
    </div>
    <div class="flex-box plr_flt_ovf">
      <div class="flex-box" v-for="(s, i) in sections" :key="i">
        <div class="flex-box" v-for="(c, j) in s.categories" :key="j">
          <template v-if="c.subcategories.length > 0">
            <div class="flex-box">
              <button
                class="btn-filter _plr_btn_filter"
                v-for="(sub, k) in c.subcategories"
                :key="k"
                @click="goto(sub.id)"
              >
                <span>{{ sub.name }}</span>
              </button>
            </div>
          </template>
          <template v-else>
            <button class="btn-filter _plr_btn_filter" @click="goto(c.id)">
              <span>{{ c.name }}</span>
            </button>
          </template>
        </div>
      </div>
    </div>
    <div class="scrl_btn_wrap_right">
      <button class="scrl_btn scrl_btn_right" @click="scrollRight">
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
          class="feather feather-chevron-right"
        >
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sections: [],
      secScroller: null,
      rightBtn: null,
      leftBtn: null,
    };
  },
  methods: {
    scrollLeft() {
      this.secScroller.scrollLeft -= 200;
      this.checkScroll();
    },

    goto(id) {
      window.location.href =
        "/explore/parlors/filter?tab_=explore_parlor&arrange=default&search_type=" + id;
    },

    checkScroll() {
      if (this.secScroller) {
        if (this.secScroller.scrollLeft == 0) {
          this.leftBtn.style.display = "none";
          this.rightBtn.style.display = "flex";
        } else {
          this.leftBtn.style.display = "flex";
          if (
            this.secScroller.scrollWidth -
              this.secScroller.clientWidth -
              this.secScroller.scrollLeft ==
            0
          ) {
            this.rightBtn.style.display = "none";
          }
        }
      }
    },
    scrollRight() {
      this.secScroller.scrollLeft += 200;
      this.checkScroll();
    },
  },
  mounted() {
    this.secScroller = document.querySelector(".plr_flt_ovf");
    this.leftBtn = document.querySelector(".scrl_btn_wrap_left");
    this.rightBtn = document.querySelector(".scrl_btn_wrap_right");

    if (this.leftBtn && this.secScroller.scrollLeft == 0) {
      this.leftBtn.style.display = "none";
    }
    axios
      .get(this.$siteURL + "/get/parlor/section/available")
      .then((res) => {
        this.sections = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
<style>
._plr_btn_filter {
  height: 40px;
}
._plr_btn_wrap {
  padding-top: 10px;
  position: relative;
  width: 100%;
}
.scrl_btn {
  height: 40px;
  width: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  border: solid 1px var(--gray-medium);
}
.scrl_btn_right {
  position: absolute;
  right: 0;
}
.plr_flt_ovf {
  overflow: auto;
}
.scrl_btn_wrap_left {
  position: absolute !important;
  left: 0px !important;
  z-index: 3 !important;
  width: 65px !important;
  background: var(--lg-crum-left);
}

.scrl_btn_wrap_right {
  position: absolute !important;
  right: 0px !important;
  z-index: 3 !important;
  width: 65px !important;
  height: 40px !important;
  background: var(--lg-crum-right);
}
</style>
