<template>
  <div>
    <template v-if="notification.type === 'App\\Notifications\\NewProductNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/list/${notification.data.slug}`"
          @click="window.location.href(`${$siteURL}/list/${notification.data.slug}`)"
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.studio.profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.studio.name }}</strong> listed new product:
                <strong>{{ notification.data.name }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/product/thumb/${notification.data.thumbnail}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template
      v-if="notification.type === 'App\\Notifications\\ProductApprovedNotification'"
    >
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/list/${notification.data.slug}`"
          @click="window.location.href(`${$siteURL}/list/${notification.data.slug}`)"
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.studio.profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                Your product <strong>{{ notification.data.name }}</strong> has been
                approved.
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/product/thumb/${notification.data.thumbnail}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\FollowNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/@${notification.data.user_slug}`"
          @click="window.location.href(`${$siteURL}/@${notification.data.user_slug}`)"
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> started following
                <strong>{{ notification.data.studio_name }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\FollowUserNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/@${notification.data.slug}`"
          @click="window.location.href(`${$siteURL}/@${notification.data.slug}`)"
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.name }}</strong> started following you
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\ShowOfReactNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/showoff/${notification.data.showoff_slug}`"
          @click="
            window.location.href(`${$siteURL}/showoff/${notification.data.showoff_slug}`)
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> reacted on your
                showoff:
                {{ notification.data.showoff_title }}
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/showoff/thumb/${notification.data.showoff_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\ParlorBookNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/parlor/${notification.data.parlor_slug}`"
          @click="
            window.location.href(`${$siteURL}/parlor/${notification.data.parlor_slug}`)
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> booked parlor:
                <strong>{{ notification.data.parlor_title }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/parlor/thumb/${notification.data.parlor_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\OrderNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/studio/order-details/${notification.data.order_id}`"
          @click="
            window.location.href(
              `${$siteURL}/studio/order-details/${notification.data.order_id}`
            )
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> ordered product:
                <strong>{{ notification.data.product_name }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/product/thumb/${notification.data.product_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\UserKycNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/account/settings/gov`"
          @click="window.location.href(`${$siteURL}/account/settings/gov`)"
        >
          <div class="flex-box">
            <svg
              version="1.1"
              id="Capa_1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px"
              y="0px"
              width="24px"
              height="24px"
              viewBox="0 0 317.855 317.855"
              xml:space="preserve"
              style="margin-right: 20px; width: 43px; height: 30px; margin-left: 10px"
              fill="var(--primary-color)"
            >
              <path
                d="M158.929,317.855c-1.029,0-2.059-0.159-3.051-0.477c-33.344-10.681-61.732-31.168-84.377-60.891
		c-17.828-23.401-32.103-52.526-42.426-86.566C11.661,112.506,11.461,61.358,11.461,59.209c0-5.15,3.912-9.459,9.039-9.954
		c0.772-0.075,78.438-8.048,132.553-47.347c3.504-2.546,8.249-2.543,11.753,0.001C218.906,41.207,296.582,49.18,297.36,49.256
		c5.123,0.5,9.034,4.807,9.034,9.953c0,2.149-0.2,53.297-17.613,110.713c-10.324,34.04-24.598,63.165-42.426,86.566
		c-22.644,29.723-51.032,50.21-84.376,60.891C160.987,317.696,159.958,317.855,158.929,317.855z M31.748,67.982
		c0.831,16.784,4.062,55.438,16.604,96.591c21.405,70.227,58.601,114.87,110.576,132.746
		c52.096-17.916,89.335-62.711,110.713-133.202c12.457-41.074,15.653-79.434,16.472-96.134
		c-22.404-3.269-80.438-14.332-127.186-45.785C112.175,53.648,54.153,64.713,31.748,67.982z"
              />
              <path
                d="M192.732,202.035c-2.56,0-5.118-0.977-7.071-2.929l-67.607-67.609c-3.905-3.905-3.905-10.237,0-14.143
			c3.907-3.904,10.237-3.903,14.143,0l67.607,67.609c3.905,3.905,3.905,10.237,0,14.143
			C197.851,201.059,195.291,202.035,192.732,202.035z"
              />
              <path
                d="M125.123,202.035c-2.56,0-5.118-0.977-7.071-2.929c-3.905-3.905-3.905-10.237,0-14.143l67.607-67.609
			c3.906-3.904,10.236-3.904,14.143,0c3.905,3.905,3.905,10.237,0,14.143l-67.607,67.609
			C130.241,201.059,127.683,202.035,125.123,202.035z"
              />
            </svg>
            <div>
              <div class="notify_detail">
                Failed to verify your identity:
                <strong>{{ notification.data.message }}</strong
                >. Please try again
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
        </a>
      </div>
    </template>
    <template
      v-if="notification.type === 'App\\Notifications\\UserKycApprovedNotification'"
    >
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
        >
          <div class="flex-box">
            <svg
              version="1.1"
              id="Capa_1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px"
              y="0px"
              width="24px"
              height="24px"
              viewBox="0 0 910.288 910.287"
              xml:space="preserve"
              style="margin-right: 10px; width: 45px"
              fill="#29994e"
            >
              <path
                d="M873.206,202.06l-1.212-28.51l-28.386-2.915c-109.036-11.198-202.773-51.887-262.21-84.049
			c-65.099-35.226-104.56-68.274-104.922-68.579L455.165,0L433.84,17.981c-0.392,0.33-39.853,33.379-104.951,68.604
			c-59.437,32.162-153.173,72.851-262.209,84.049l-28.387,2.915l-1.212,28.51c-0.217,5.104-4.777,126.698,42.059,273.937
			c27.637,86.887,67.549,164.736,118.627,231.396c64.139,83.701,145.948,149.68,243.155,196.102l14.221,6.793l14.221-6.793
			c97.207-46.422,179.017-112.398,243.155-196.102c51.079-66.658,90.991-144.51,118.628-231.395
			C877.982,328.759,873.423,207.165,873.206,202.06z M455.143,836.93c-81.095-41.209-149.731-97.887-204.194-168.646
			c-46.393-60.275-82.812-130.998-108.248-210.201c-31.088-96.808-38.06-183.144-39.471-225.538
			c43.735-6.494,87.949-17.421,131.833-32.597c42.9-14.836,85.598-33.752,126.907-56.221c41.915-22.798,73.81-44.573,93.172-58.812
			c19.362,14.238,51.258,36.014,93.173,58.812c41.309,22.47,84.007,41.385,126.907,56.221
			c43.896,15.181,88.123,26.108,131.87,32.602c-1.359,41.978-8.194,127.098-38.842,223.443
			c-25.317,79.594-61.694,150.672-108.12,211.258C605.537,738.494,536.632,795.52,455.143,836.93z"
              ></path>
              <polygon
                points="635.013,305.016 588.969,351.06 417.368,522.662 330.399,435.693 318.573,423.867 295.239,447.201 
			295.239,447.202 271.904,470.537 417.368,616 681.682,351.686 		"
              ></polygon>
            </svg>
            <div>
              <div class="notify_detail">
                <strong>Your identity has been verified successfully. </strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
        </a>
      </div>
    </template>
    <template
      v-if="notification.type === 'App\\Notifications\\ParlorApprovedNotification'"
    >
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/studio/parlors/${notification.data.parlor_slug}`"
          @click="
            window.location.href(
              `${$siteURL}/studio/parlors/${notification.data.parlor_slug}`
            )
          "
        >
          <div class="flex-box">
            <div class="notify_img_wrap" style="margin-right: 15px">
              <img
                class="notify_item_img"
                :src="`${$siteURL}/images/parlor/thumb/${notification.data.parlor_image}`"
                alt=""
              />
            </div>
            <div>
              <div class="notify_detail">
                Parlor approved:
                <strong>{{ notification.data.parlor_title }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\NewParlorNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/parlor/${notification.data.parlor_slug}`"
          @click="
            window.location.href(`${$siteURL}/parlor/${notification.data.parlor_slug}`)
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.studio_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.studio_name }}</strong> published new parlor:
                <strong>{{ notification.data.parlor_title }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/parlor/thumb/${notification.data.parlor_image}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template
      v-if="notification.type === 'App\\Notifications\\ProductReviewNotification'"
    >
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/list/${notification.data.product_slug}`"
          @click="
            window.location.href(`${$siteURL}/list/${notification.data.product_slug}`)
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> reviewed on product:
                <strong>{{ notification.data.product_name }}</strong>
                <span>"{{ notification.data.review }}"</span>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/product/thumb/${notification.data.product_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\ParlorReviewNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/parlor/${notification.data.parlor_slug}`"
          @click="
            window.location.href(`${$siteURL}/parlor/${notification.data.parlor_slug}`)
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> reviewed on parlor:
                <strong>{{ notification.data.parlor_title }}</strong>
                <span>"{{ notification.data.review }}"</span>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/parlor/thumb/${notification.data.parlor_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template v-if="notification.type === 'App\\Notifications\\OrderStatusNotification'">
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/orders/`"
          @click="window.location.href(`${$siteURL}/orders/`)"
        >
          <div class="flex-box">
            <div class="notify_img_wrap" style="margin-right: 15px">
              <img
                class="notify_item_img"
                :src="`${$siteURL}/images/product/thumb/${notification.data.product_thumb}`"
                alt=""
              />
            </div>
            <div>
              <div class="notify_detail">
                <span>Your order: </span>
                <strong>{{ notification.data.product_name }}</strong>
                <span v-if="notification.data.status == 'Processing'"> is now </span>
                <span v-if="notification.data.status == 'Cancelled'"> has been </span>
                <span v-if="notification.data.status == 'Shipping'"> is now </span>
                <span v-if="notification.data.status == 'Delivered'"> has been </span>
                <strong>{{ notification.data.status }}</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>
        </a>
      </div>
    </template>
    <template
      v-if="notification.type === 'App\\Notifications\\ShowoffCommentReplyNotification'"
    >
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/showoff/${notification.data.showoff_slug}?comment_tab=true`"
          @click="
            window.location.href(
              `${$siteURL}/showoff/${notification.data.showoff_slug}?comment_tab=true`
            )
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> replied to your
                comment:
                <strong>"{{ notification.data.comment }}"</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/showoff/thumb/${notification.data.showoff_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
    <template
      v-if="notification.type === 'App\\Notifications\\ShowoffCommentNotification'"
    >
      <div>
        <a
          class="notify notify_card"
          :class="{ unseen: !notification.read_at }"
          style="width: 100%"
          :href="`${$siteURL}/showoff/${notification.data.showoff_slug}?comment_tab=true`"
          @click="
            window.location.href(
              `${$siteURL}/showoff/${notification.data.showoff_slug}?comment_tab=true`
            )
          "
        >
          <div class="flex-box">
            <img
              class="notify_img"
              :src="`${$siteURL}/images/profile/thumb/${notification.data.user_profile}`"
              alt=""
            />
            <div>
              <div class="notify_detail">
                <strong>{{ notification.data.user_name }}</strong> commented on your
                showoff:
                <strong>"{{ notification.data.comment }}"</strong>
              </div>
              <div class="typography-caption notify_time">{{ humanizeTime }} ago</div>
            </div>
          </div>

          <div class="notify_img_wrap">
            <img
              class="notify_item_img"
              :src="`${$siteURL}/images/showoff/thumb/${notification.data.showoff_thumb}`"
              alt=""
            />
          </div>
        </a>
      </div>
    </template>
  </div>
</template>
<script>
import moment from "moment";
import momenttimezone from "moment-timezone";
export default {
  props: {
    notification: Object,
  },
  methods: {
    convertUTCToLocal(utcDt, utcDtFormat) {
      var toDt = moment.utc(utcDt, utcDtFormat).toDate();
      return moment(toDt).format();
    },
  },
  computed: {
    humanizeTime: function () {
      var localTime = this.convertUTCToLocal(this.notification.created_at);
      return moment(localTime).fromNow(true);
    },
  },
};
</script>
<style>
.notify {
  height: max-content !important;
  padding: 10px;
  border-radius: 8px !important;
  box-sizing: border-box;
}
.notify_img {
  margin-right: 10px;
}
.notify_time {
  font-size: 14px;
  color: var(--gray-medium-dark);
  margin-top: 6px;
}
.unseen {
  background: var(--gray-light);
}

.notify_img_wrap {
  height: 64px;
  width: 64px;
  margin-left: 10px;
  flex-shrink: 0;
}
.notify_item_img {
  height: 100% !important;
  width: 100% !important;
  object-fit: cover;
  border-radius: 8px !important;
}
.notify_detail {
  font-size: 14px;
  color: var(--gray-very-dark);
}
</style>
