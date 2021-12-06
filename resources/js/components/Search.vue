<template>
  <div v-bind:class="{ active_search: isActive }" class="navbar-search">
    <div class="navbar-search-icon">
      <label for="search_bar">
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
          class="feather feather-search"
        >
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </label>
    </div>

    <form v-on:submit.prevent="goToSearch" style="width: 100%">
      <input
        type="search"
        class="navbar-search-input"
        placeholder="What are you trying?"
        @click="searchHistory"
        ref="search"
        id="search_bar"
        v-model="keywords"
        autocomplete="off"
        v-on:input="validateKeyword"
      />
    </form>
    <div
      class="_SB_h"
      v-show="isActive"
      v-closable="{
        exclude: ['search'],
        handler: 'closeSearch',
      }"
    >
      <div v-if="isActive" class="navbar-close-icon" @click="clearSearch">
        <label for="search_bar" class="SB_x">
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
            class="feather feather-x"
          >
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </label>
      </div>
      <div v-if="history">
        <div>
          <div v-for="(search, s) in histories" :key="s">
            <a :href="`${$siteURL}/search?search_product=` + search.value">{{
              search.value
            }}</a>
          </div>
        </div>

        <div v-if="trends">
          <div>
            <h3>Trending Searches</h3>
            <div v-for="(keyword, k) in trends" :key="k">
              <a :href="`${$siteURL}/search?search_product=` + keyword.keyword">{{
                keyword.keyword
              }}</a>
            </div>
          </div>
        </div>
      </div>
      <div v-if="keywords.length > 0">
        <div>
          <div v-for="record in records" :key="record.id">
            <a :href="`${$siteURL}/search?search_product=` + record.value">{{
              record.value
            }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _, { slice } from "lodash";
export default {
  name: "searchbar",
  data() {
    return {
      keywords: "",
      history: false,
      isActive: false,
      histories: null,
      records: null,
      trends: null,
    };
  },
  mounted() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const i = urlParams.get("search_product");
    if (i) {
      this.keywords = i;
    }
  },
  methods: {
    searchHistory() {
      this.isActive = true;
      this.history = true;
      axios
        .get(this.$siteURL + "/search-history")
        .then((res) => {
          this.histories = res.data;
        })
        .catch((error) => {
          console.log(error);
        });

      axios
        .get(this.$siteURL + "/search-trend")
        .then((res) => {
          this.trends = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    search() {
      let keywordData = new FormData();
      keywordData.append("term", this.keywords);
      axios
        .get(this.$siteURL + "/search-autocomplete?term=" + this.keywords)
        .then((res) => {
          this.records = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    closeSearch() {
      this.isActive = false;
    },
    clearSearch() {
      this.keywords = "";
      this.isActive = false;
    },
    goToSearch() {
      if (this.keywords.length > 2) {
        window.location.href = this.$siteURL + "/search?search_product=" + this.keywords;
      }
    },
    validateKeyword: _.debounce(function (e) {
      if (this.keywords.length > 3) {
        this.history = false;
        this.search();
      } else {
        this.history = true;
      }
    }, 200),
  },
};
</script>
<style>
._SB_h {
  width: 100%;
  height: 500px;
  background: var(--gray-very-light);
  position: absolute;
  top: 40px;
  padding: 15px;
  box-shadow: rgb(0 0 0 / 20%) 0px 6px 20px;
  box-sizing: border-box;
}
.navbar-close-icon {
  position: absolute;
  right: 15px;
  top: -35px;
  display: flex;
  align-items: center;
}
.SB_x {
  cursor: pointer;
}

@media only screen and (max-width: 600px) {
  .active_search {
    position: absolute;
    z-index: 1;
    margin: 0 !important;
  }
}
</style>
