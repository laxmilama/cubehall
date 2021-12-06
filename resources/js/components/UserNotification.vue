<template>
  <li class="navbar-items-round" @click="togle()">
    <a
      ref="c"
      class="dropdown-toggle"
      data-toggle="dropdown"
      role="button"
      aria-expanded="false"
    >
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
        class="feather feather-bell"
      >
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
      </svg>
      <div v-if="unreads > 0" class="notify_counter">
        <template v-if="unreads > 2"> 9+ </template>
        <template v-else>
          {{ unreads }}
        </template>
      </div>
    </a>
    <div
      v-show="isOpen"
      v-closable="{
        exclude: ['c'],
        handler: 'closeMenu',
      }"
      class="user-dropdown _fix_dd_mbl notification notify_drop round_c_s"
    >
      <notification-item
        v-for="(notification, index) in notifications"
        :notification="notification"
        :key="index"
      ></notification-item>
      <div v-if="isLoading">
        <h2 style="text-align: center">Loading...</h2>
      </div>
    </div>
  </li>
</template>
<script>
import moment from "moment";
import momenttimezone from "moment-timezone";
import axios from "axios";
import NotificationItem from "./NotificationItem.vue";
const notificationInstance = axios.create({
  baseURL: window.location.protocol + "//" + window.location.hostname,
  timeout: 1000,
  headers: { "X-Custom-Header": "foobar" },
});
export default {
  props: ["unreads", "userid"],

  components: { NotificationItem },
  data() {
    return {
      notifications: [],
      isOpen: false,
      product_details: "",
      data: null,
      page: 0,
      isLoading: false,
      canLoadMore: true,
    };
  },
  methods: {
    togle() {
      this.markNotificationAsRead();
      this.isOpen = !this.isOpen;
    },
    closeMenu() {
      if (this.isOpen == true) {
        this.unreads = 0;
        this.isOpen = false;
      }
    },
    markNotificationAsRead() {
      if (this.notifications.length) {
        notificationInstance.get("/markAsRead");
      }
    },
    loadNotifications() {
      notificationInstance
        .get(this.$siteURL + "/notifications/all")
        .then((res) => {
          this.data = res.data;
          this.notifications = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
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

      notificationInstance
        .get(this.$siteURL + "/notifications/all?page=" + this.page)
        .then((res) => {
          if (res.data.current_page == res.data.last_page) {
            this.canLoadMore = false;
          }
          this.data = res.data;

          Object.values(res.data.data).forEach((e) => {
            this.notifications.push(e);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    // Detect when scrolled to bottom.
    const listElm = document.querySelector(".notification");
    listElm.addEventListener("scroll", (e) => {
      if (listElm.scrollTop + listElm.clientHeight >= listElm.scrollHeight) {
        if (this.canLoadMore) {
          this.loadMore();
        }
      }
    });

    this.loadNotifications();
    let that = this;

    let interceptor = notificationInstance.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    notificationInstance.interceptors.response.use(
      function (response) {
        that.isLoading = false;
        return response;
      },
      function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        return Promise.reject(error);
      }
    );
    notificationInstance.interceptors.request.eject(interceptor);

    Echo.private("App.Models.User." + this.userid).notification((notification) => {
      // console.log(notification);

      if (notification.type == "App\\Notifications\\NewProductNotification") {
        let newUnreadNotifications = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            name: notification.name,
            slug: notification.slug,
            thumbnail: notification.thumbnail,
            studio: notification.studio,
          },
        };
        this.notifications.unshift(newUnreadNotifications);
        this.unreads++;
        this.$toast.success(
          newUnreadNotifications.data.studio.name +
            "listed a new product: " +
            newUnreadNotifications.data.name,
          {
            position: "top-center",
            timeout: 5000,
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
          }
        );
      } else if (notification.type == "App\\Notifications\\ProductApprovedNotification") {
        let productapprovedNotifications = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            name: notification.name,
            slug: notification.slug,
            thumbnail: notification.thumbnail,
            studio: notification.studio,
          },
        };
        this.notifications.unshift(productapprovedNotifications);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\FollowNotification") {
        let followNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            user_name: notification.user_name,
            user_slug: notification.user_slug,
            user_profile: notification.user_profile,
            studio_name: notification.studio_name,
          },
        };

        this.notifications.unshift(followNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\FollowUserNotification") {
        let followNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            name: notification.name,
            slug: notification.slug,
            profile: notification.profile,
          },
        };

        this.notifications.unshift(followNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\ShowOfReactNotification") {
        let ShowOfReactNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            showoff_slug: notification.showoff_slug,
            showoff_thumb: notification.showoff_thumb,
          },
        };

        this.notifications.unshift(ShowOfReactNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\ParlorBookNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            parlor_slug: notification.parlor_slug,
            parlor_title: notification.parlor_title,
            parlor_thumb: notification.parlor_thumb,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\OrderNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            order_id: notification.order_id,
            product_name: notification.product_name,
            product_thumb: notification.product_thumb,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\UserKycNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            message: notification.message,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\ParlorApprovedNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            parlor_slug: notification.order_id,
            parlor_title: notification.parlor_title,
            parlor_image: notification.parlor_image,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\ProductReviewNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            product_name: notification.product_name,
            product_slug: notification.product_slug,
            product_thumb: notification.product_thumb,
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            review: notification.review,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\ParlorReviewNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            parlor_title: notification.parlor_title,
            parlor_slug: notification.parlor_slug,
            parlor_thumb: notification.parlor_thumb,
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            review: notification.review,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (notification.type == "App\\Notifications\\ShowoffCommentNotification") {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            showoff_slug: notification.showoff_slug,
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            showoff_thumb: notification.showoff_thumb,
            comment: notification.comment,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else if (
        notification.type == "App\\Notifications\\ShowoffCommentReplyNotification"
      ) {
        let ParlorBookNotification = {
          type: notification.type,

          created_at: moment().format(),
          data: {
            showoff_slug: notification.showoff_slug,
            user_name: notification.user_name,
            user_profile: notification.user_profile,
            showoff_thumb: notification.showoff_thumb,
            comment: notification.comment,
          },
        };

        this.notifications.unshift(ParlorBookNotification);
        this.unreads++;
      } else {
        // let newUnreadNotifications = {
        //   data: {
        //     parlorid: notification.parlorid,
        //     title: notification.title,
        //     studioparlor: notification.studioparlor,
        //     parlorslug: notification.parlorslug,
        //     suscribeduser: notification.suscribeduser,
        //   },
        // };
        // this.notifications.push(newUnreadNotifications);
      }
    });
  },
};
</script>
<style>
.notification {
  min-width: 400px;
  max-height: 500px;
  overflow: auto;
  padding: 0px !important;
}
.notify_counter {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background-color: var(--primary-color);
  position: absolute;
  transform: translate(10px, -10px);
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: 800;
  font-size: 12px !important;
}
._notification_header_bar {
  width: 100%;
  background: var(--gray-very-light);
  border-bottom: solid 1px var(--gray-mediunm);
}
@media only screen and (max-width: 920px) {
  .notification {
    min-width: 300px;
    max-height: 100vh;
    overflow: auto;
    padding: 0px !important;
  }
  ._fix_dd_mbl {
    top: 60px !important;
  }
}
</style>
