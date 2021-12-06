<template>
  <div>
    <div class="_MBL-addPad">
      <h2>Browsing history</h2>
      <div class="_history_head">
        <a @click.prevent="showClear" class="_Clear_Btn" href="#">
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
            class="_Clear_ico"
          >
            <polyline points="3 6 5 6 21 6"></polyline>
            <path
              d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
            ></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
          </svg>
          <span>Clear all browse history</span></a
        >
      </div>
    </div>
    <div v-if="showClearBox" class="_bag_address_overlay">
      <div class="_bag_address_wrap">
        <div class="_bag_address_card round_c_m">
          <div class="_bag_address_cont">
            <div>
              <h3 class="very_dark" style="margin-top: 0px">Clear browse history?</h3>
              <div class="black_text">
                <span>This nonreversible action. </span>
              </div>
            </div>
            <div class="flex-box submit_Bar mt-m">
              <button @click.prevent="clearHistory" class="btn-normalize">
                Clear browse history
              </button>
              <button @click="cancleClear" class="btn-normalize _history_calcle">
                Cancle
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="_history_wrapper">
        <div class="_history_card" v-for="(history, i) in histories" :key="i">
          <div class="_history_holder">
            <div style="position: relative">
              <div class="showoff-show">
                <div class="showof-show-content">
                  <img
                    :src="$siteURL + history.data.thumb"
                    width="100%"
                    class="showoff-show-img"
                  />
                </div>
              </div>
              <div class="_history_name">
                <span>{{ truncateString(history.data.name) }}</span>
                <div>
                  <span>
                    {{ convertUTCToLocal(history.created_at) }}
                  </span>
                </div>
              </div>
              <template v-if="history.type == 'App\\Models\\ProductList'">
                <div class="feed-tag feed-tag-wrap round_c_b">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-shopping-bag"
                  >
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                  </svg>
                </div>
                <a class="_h_link" :href="'/list/' + history.data.slug"></a>
              </template>
              <template v-if="history.type == 'App\\Models\\ShowOff'">
                <div class="feed-tag feed-tag-wrap round_c_b">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-tag"
                  >
                    <path
                      d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"
                    ></path>
                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                  </svg>
                </div>
                <a class="_h_link" :href="'/showoff/' + history.data.slug"></a>
              </template>
              <template v-if="history.type == 'App\\Models\\Parlor'">
                <div class="feed-tag feed-tag-wrap round_c_b">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-coffee"
                  >
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                  </svg>
                </div>
                <a class="_h_link" :href="'/parlor/' + history.data.slug"></a>
              </template>
            </div>
          </div>
        </div>
      </div>
      <div class="loadmore" v-show="canLoadMore">
        <button
          :disabled="isLoading"
          class="btn btn-third btn-normalize loading"
          @click.prevent="loadMore"
        >
          <span v-show="isLoading">
            <span>Loading</span>
            <span class="loader" v-for="i in 3" :key="i">
              <span>.</span>
            </span>
          </span>
          <span v-show="!isLoading">Load More</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
export default {
  data() {
    return {
      histories: [],
      data: null,
      page: 0,
      canLoadMore: true,
      showClearBox: false,
      isLoading: false,
    };
  },
  methods: {
    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format("MMM DD, YYYY");
    },
    loadMore() {
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
        .get(this.$siteURL + "/feed/history?type=" + "&page=" + this.page)
        .then((res) => {
          let a = Object.values(res.data.data);
          this.data = res.data;
          if (this.data.current_page == this.data.last_page) {
            this.canLoadMore = false;
          }
          a.forEach((e) => {
            this.histories.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    showClear() {
      this.showClearBox = true;
    },
    cancleClear() {
      this.showClearBox = false;
    },
    clearHistory() {
      axios
        .post(this.$siteURL + "/feed/history/clear", true)
        .then((res) => {
          this.showClearBox = false;
          this.histories = null;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    truncateString(str) {
      var num = 20;
      if (str.length > num) {
        return str.slice(0, num) + "...";
      } else {
        return str;
      }
    },
  },
  mounted() {
    axios
      .get(this.$siteURL + "/feed/history")
      .then((res) => {
        let a = Object.values(res.data.data);
        this.data = res.data;
        if (this.data.current_page == this.data.last_page) {
          this.canLoadMore = false;
        }
        a.forEach((e) => {
          this.histories.push(e);
        });
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>
<style>
._Clear_Btn {
  display: flex;
  align-items: center;
  width: max-content;
  color: var(--gray-very-dark);
}
._Clear_Btn:hover {
  text-decoration: underline;
}
._Clear_ico {
  margin-right: 8px;
}
._history_calcle {
  font-weight: 600;
  border: none;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.5rem 0.75rem;
  box-sizing: border-box;
  color: black;
  margin-left: 10px;
  background: transparent;
}
._h_link {
  display: block;
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
}
</style>
