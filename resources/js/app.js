/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./beaconImpression');
window.Vue = require('vue').default;
Vue.prototype.$siteURL = window.location.protocol+'//' + window.location.hostname;


let handleOutsideClick;
Vue.directive('closable', {
  bind (el, binding, vnode) {
    handleOutsideClick = (e) => {
      e.stopPropagation()
      const { handler, exclude } = binding.value
      let clickedOnExcludedEl = false
      exclude.forEach(refName => {
        if (!clickedOnExcludedEl) {
          const excludedEl = vnode.context.$refs[refName]
          clickedOnExcludedEl = excludedEl.contains(e.target)
        }
      })
      if (!el.contains(e.target) && !clickedOnExcludedEl) {
        vnode.context[handler]()
      }
    }
    document.addEventListener('click', handleOutsideClick)
    document.addEventListener('touchstart', handleOutsideClick)
  },

  unbind () {
    document.removeEventListener('click', handleOutsideClick)
    document.removeEventListener('touchstart', handleOutsideClick)
  }
});

import MegaMenu from './components/MegaMenu.vue';
import UserDropdown from './components/UserDropdown.vue';
import GuestDropdown from './components/GuestDropdown.vue';
import Tabs from './components/Tabs.vue';
import Tab from './components/Tab.vue';
import Sliders from './components/Sliders.vue';
import Discover from './components/Discover.vue';
import MobileBottomTab from './components/MobileBottomTab.vue';
import FollowStudio from './components/FollowStudio.vue';

import ToolTip from './components/ToolTip.vue';

import FollowUser from './components/FollowUser.vue';

import CreateShowoff from './components/CreateShowoff.vue';

// showofff
import ShowOffSave from './components/ShowOffSave.vue';
import ShowOffReact from './components/ShowOffReact.vue';
import ShowOffShare from './components/ShowOffShare.vue';
import ShowOffComment from './components/ShowOffComment.vue';
// import HomeShowoff from './components/HomeShowoff.vue';

import ProductTag from './components/ProductTag.vue';
import ProductSideTag from './components/ProductSideTag.vue';

// share
import ShareButton from './components/ShareButton.vue';
import BoardShare from './components/BoardShare.vue';

// search
import Search from './components/Search.vue';
import SearchFilter from './components/SearchFilter.vue';

// Following Feed
import FollowingFeed from './components/FollowingFeed.vue';

// cart
import Bag from './components/Bag.vue';

// Home
import HomeFeed from './components/HomeFeed.vue';

// Government Card Verification
import Gov from './components/Gov.vue';

// Personal Settings
import PersonalSetting from './components/PersonalSetting.vue';
import ChangePassword from './components/ChangePassword.vue';

// Parlors
import AllParlor from './components/AllParlors.vue';
import ParlorBook from './components/ParlorBook.vue';
import ParlorExploreSection from './components/ParlorExploreSection.vue';

// bag
import ProductBag from './components/ProductBag.vue';
import Checkout from './components/Checkout.vue';
// Shops
import ShopIndex from './components/ShopIndex.vue';

import TrendingProduct from './components/TrendingProduct.vue';

import FollowUserBasic from './components/FollowUserBasic.vue';

import BackButton from './components/BackButton.vue';

import Products from './components/Products.vue';
import Parlors from './components/Parlors.vue';
import Reviews from './components/Reviews.vue';

// tickets
import TicketShow from './components/TicketShow.vue';

import BrowseCategory from './components/BrowseCategory.vue';
import UserNotification from './components/UserNotification.vue';
import NotificationItem from './components/NotificationItem.vue';

import PaymentDetailForm from './components/PaymentDetailForm.vue';

import "./Tocca.min";
import Vue from 'vue';
import axios from 'axios';
//chat message
import ChatApp from './components/ChatApp.vue';
// Utilities
import ReadMore from './components/ReadMore.vue';
import CopyLink from './components/CopyLink.vue';
import Toast from "vue-toastification";
import VueCookies from 'vue-cookies';
Vue.use(VueCookies);

import "vue-toastification/dist/index.css";
Vue.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
});

import Clipboard from "v-clipboard";
Vue.use(Clipboard);


window.tocca({
  swipeThreshold: 50,
  tapThreshold: 150,
  dbltapThreshold: 200,
  longtapThreshold: 350,
  tapPrecision: 60/2,
  justTouchEvents: false,
});
import TechnicalGuide from './components/TechnicalGuide.vue';

// create studio
import StudioCreate from './components/StudioCreate.vue';

import ProfileShowoff from './components/ProfileShowoff.vue';

import TicketCompleted from './components/TicketCompleted.vue';

import TabsDyna from './components/TabsDyna.vue';

import BagNotification from './components/BagNotification.vue';

// User Orders
import OrderCompleted from './components/OrderCompleted.vue';
import OrderUpcoming from './components/OrderUpcoming.vue';

import ParlorNow from './components/ParlorNow.vue';
import History from './components/History.vue';
import LibraryHistory from './components/LibraryHistory.vue';
import AllProductReview from './components/AllProductReview.vue';

import ParlorExploreFilter from './components/ParlorExploreFilter.vue';
import ParlorCard from './components/ParlorCard.vue';
import ProductCard from './components/ProductCard.vue';
import BoardOption from './components/BoardOption.vue';
import ShowOffOption from './components/ShowOffOption.vue';
const app = new Vue({
    el: '#app',
    components: {
        Tabs, 
        Tab, 
        TabsDyna,
        FollowStudio, 
        ToolTip, 
        FollowUser, 
        ShowOffSave, 
        ShowOffReact, 
        ShowOffShare, 
        ShowOffComment,
        ShowOffOption,
        ProductTag,
        ProductSideTag,
        ShareButton, 
        FollowingFeed,
        BoardShare,
        AllParlor,
        ShopIndex,
        Products,
        Parlors,
        ReadMore,
        Reviews,
        HomeFeed,
        Checkout,
        StudioCreate,
        TicketShow,
        TicketCompleted,
        ProfileShowoff,
        OrderUpcoming,
        OrderCompleted,
        ParlorNow,
        ParlorExploreSection, 
        History,
        LibraryHistory,
        TechnicalGuide,
        ProductBag,
        AllProductReview,
        ParlorExploreFilter,
        ParlorCard,
        ProductCard,
        TrendingProduct,
        BoardOption,
      }
});
const chat = new Vue({
  el: '[data-init="chat"]',
  components: {
     ChatApp
    }
});
const copyLink = new Vue({
  el: '[data-init="copylink"]',
  components: {
      CopyLink
    }
});

const parlorBook = new Vue({
  el: '[data-init="parlorbook"]',
  components: {
      ParlorBook
    }
});


const bag = new Vue({
  el: '[data-init="product-bag"]',
  components: {
      Bag,
    }
});
import DiscoverCreators from './components/DiscoverCreators.vue';
const story = new Vue({
  el: '[data-init="story"]',
  components: {
      Discover, Sliders, DiscoverCreators,
    }
});

import UserBag from "./components/UserBag.vue";
const megamenu = new Vue({
  el: '[data-init="nav"]',
  components: {
      MegaMenu, UserDropdown,  Search, UserNotification,NotificationItem ,GuestDropdown, UserBag
    }
});


import CookieHandler from './components/CookieHandler.vue';
const mobiletab = new Vue({
  el: '[data-init="footer"]',
  components: {
    MobileBottomTab,
    CookieHandler,
    BagNotification
    }
});



const createShowoff = new Vue({
  el: '[data-init="showoff"]',
  components:{
    CreateShowoff, 
  }
})

const searchFilter = new Vue({
  el: '[data-init="searchFilter"]',
  components:{
    SearchFilter, BrowseCategory
  }
})

const json = new Vue({
  el: '[data-init="showoffhome"]',
  components:{
    json, 
  }
})



const gov = new Vue({
  el: '[data-init="gov"]',
  components:{
    Gov, 
  }
})

const personalSetting = new Vue({
  el: '[data-init="personal"]',
  components:{
    PersonalSetting, ChangePassword, PaymentDetailForm
  }
})

const followuserBasic = new Vue({
  el: '[data-init="follow-user-basic"]',
  components:{
    FollowUserBasic,
  }
})

const backButton = new Vue({
  el: '[data-init="back-button"]',
  components:{
    BackButton,
  }
})

// Install promoter
import InstallApp from './components/InstallApp.vue';
const initApp = new Vue({
  el: '[data-init="init-install"]',
  components:{
    InstallApp,
  }
})

