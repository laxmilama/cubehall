<template>
  <div class="rating">
    <div v-if="reviewDialog" class="_bag_address_overlay">
      <div class="_bag_address_wrap">
        <div class="_bag_address_card round_c_m">
          <div class="_bag_address_cont">
            <button @click="close" class="x_close round_full">
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
            </button>
            <div>
              <h3 class="very_dark" style="margin-top: 0px">How was your experience?</h3>
              <div class="black_text">
                <span>Write an honest review about 's parlor to help future guests </span>
              </div>
            </div>
            <div class="flex-box ratting_card">
              <ul class="list">
                <li
                  @click="rate(star)"
                  v-for="star in maxStars"
                  :class="{ active: star <= stars }"
                  :key="star.stars"
                  class="star"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="35"
                    height="35"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-star"
                  >
                    <polygon
                      points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
                    ></polygon>
                  </svg>
                </li>
              </ul>
              <div v-if="hasCounter" class="info counter">
                <span class="score-rating">{{ stars }}</span>
                <span class="divider">/</span>
                <span class="score-max">{{ maxStars }}</span>
              </div>
            </div>
            <div>
              <textarea
                placeholder="Say something about hosts parlor."
                v-model="review"
                class="rating_text"
                name=""
                id=""
                @input="validateReview"
              >
              </textarea>
            </div>

            <div class="flex-box submit_Bar">
              <button
                :disabled="!isValidReview"
                class="btn-normalize"
                @click="saveReview"
              >
                Review
              </button>

              <strong>
                <a class="black_text s_L" href="#" @click.prevent="showGuideline = true"
                  >Check out review tips</a
                >
              </strong>
            </div>
          </div>
        </div>
      </div>
      <div v-if="showGuideline">
        <div class="_bag_address_wrap">
          <div class="_bag_address_card round_c_m">
            <div class="_bag_address_cont how_to_review">
              <button @click="showGuideline = false" class="x_close round_full">
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
              </button>
              <h2>How to write review?</h2>
              <span
                >The best reviews are helpful ones. Think about what you’d like to know
                before reserving a parlor.</span
              >
              <div>
                <h4>Be honest and clear</h4>
                <p>
                  Write an unbiased review without being influenced by your hosts asking.
                </p>
              </div>
              <div>
                <h4>Mention host</h4>
                <p>
                  Mention your parlor host's name or write few lines about your host.
                  Mention if they were friendly, respectful, skilled etc. It makes the
                  review more real, and more personal.
                </p>
              </div>
              <div>
                <h4>Suggest improvements</h4>
                <p>
                  Suggest what could be better and more pleasant for future guests.
                  Remember to leave constructive feedback.
                </p>
              </div>
              <div>
                <h4>Say what you loved.</h4>
                <p>Anything that made the activity special.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="how_to_review">
      <h3 style="margin: 0; padding: 0">How did you like this product?</h3>
    </div>
    <ul class="list">
      <li
        @click="rate(star)"
        v-for="star in maxStars"
        :class="{ active: star <= stars }"
        :key="star.stars"
        class="star"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="35"
          height="35"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="feather feather-star"
        >
          <polygon
            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
          ></polygon>
        </svg>
      </li>
    </ul>
  </div>
</template>
<script>
import axios from "axios";
import _ from "lodash";
export default {
  name: "Rating",
  props: ["grade", "maxStars", "hasCounter", "product", "order", "op"],
  data() {
    return {
      stars: this.grade,
      reviewDialog: false,
      review: "",
      showGuideline: false,
      isValidReview: false,
    };
  },
  methods: {
    rate(star) {
      if (typeof star === "number" && star <= this.maxStars && star >= 0) {
        this.stars = this.stars === star ? star - 1 : star;
        this.reviewDialog = true;
      }
    },
    saveReview() {
      let review = new FormData();
      review.append("rating", this.stars);
      review.append("content", this.review);
      review.append("order", this.order);
      review.append("opid", this.op);
      review.append("product", this.product);
      axios
        .post(this.$siteURL + "/product/rating", review)
        .then((res) => {
          this.reviewDialog = false;
        })
        .catch((err) => {
          if (err.response.status == 429) {
            this.$toast.error("Already reviewed!", {
              position: "top-center",
              timeout: 2000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          } else {
            this.$toast.error("Review Failed", {
              position: "top-center",
              timeout: 2000,
              closeOnClick: true,
              pauseOnFocusLoss: true,
              pauseOnHover: true,
              draggable: true,
              draggablePercent: 0.6,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              closeButton: "button",
              icon: true,
              rtl: false,
            });
          }
        });
    },
    close() {
      this.reviewDialog = false;
      this.stars = 0;
    },
    validateReview: _.debounce(function (e) {
      if (this.review.length > 6 && this.review.length < 1000) {
        this.isValidReview = true;
      } else {
        this.isValidReview = false;
      }
    }, 100),
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.how_to_review {
  color: var(--gray-very-dark);
}
.submit_Bar {
  justify-content: space-between;
  flex-direction: row-reverse;
  align-items: center;
  margin-top: 15px;
}
.x_close {
  position: absolute;
  top: 6px;
  left: 6px;
  border: none;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40px;
  width: 40px;
  background: none;
}
.ratting_card {
  justify-content: center;
  display: flex;
  margin: 18px 0;
}
.black_text {
  color: var(--gray-dark);
}
.very_dark {
  color: var(--gray-very-dark);
}
.rating_text {
  width: 100%;
  min-height: 100px;
  border: solid 2px var(--gray-medium-dark);
  color: var(--gray-dark);
  font-size: 18px;
}
.s_L:hover {
  text-decoration: underline;
}
.rating {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 15px;
  color: var(--gray-medium);
  background: var(--gray-very-light);
  border-radius: 8px;
  .list {
    padding: 0;
    margin: 0 20px 0 0;
    &:hover {
      .star {
        color: var(--primary-color);
      }
    }
    .star {
      display: inline-block;
      font-size: 42px;
      transition: all 0.2s ease-in-out;
      cursor: pointer;
      &:hover {
        ~ .star:not(.active) {
          color: inherit;
        }
      }
      &:first-child {
        margin-left: 0;
      }
      &.active {
        svg {
          fill: var(--primary-color);
        }
        color: var(--primary-color);
      }
    }
  }
  .info {
    font-size: 35px;
    text-align: center;
    display: table;
    .divider {
      margin: 0 3px;
      font-size: 30px;
    }
    .score-max {
      font-size: 27px;
      vertical-align: sub;
    }
  }
}
</style>
