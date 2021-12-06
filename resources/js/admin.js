/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');
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

import OrderDetail from './components/OrderDetail.vue';

import Toast from "vue-toastification";
import VueCookies from 'vue-cookies';
Vue.use(VueCookies);

import "vue-toastification/dist/index.css";
Vue.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
});

import Tabs from './components/Tabs.vue';
import Tab from './components/Tab.vue';
import ToolTip from './components/ToolTip.vue';
import Sliders from './components/Sliders.vue';

// product upload
import ProductSingle from './components/ProductSingle.vue';
import ProductVarient from './components/ProductVarient.vue';

// product Edit
import EditProduct from './components/EditProduct.vue';

import StudioSettings from './components/StudioSettings.vue';
import TabsDyna from './components/TabsDyna.vue';

import ProductUpload from './components/ProductUpload.vue';
import ParlorUpload from './components/ParlorUpload.vue';
import AddStory from './components/AddStory.vue';

import CreateDropdown from './components/CreateDropdown.vue';
import AdminDropdown from './components/AdminDropdown.vue';


// Analytics
import ProductMiniChart from './components/ProductMiniChart.vue';
import ChartImpression from './components/ChartImpression.vue';
import OrdersbyDate from './components/OrdersbyDate.vue';
import PlanetChart from './components/PlanetChart.vue';

// Reviews
import ProductReviews from './components/ProductReviews.vue';

import "./Tocca.min";
import Vue from 'vue';
import axios from 'axios';

import CopyLink from './components/CopyLink.vue';

import Clipboard from "v-clipboard";
Vue.use(Clipboard);

window.tocca({
  swipeThreshold: 50,
  tapThreshold: 150,
  dbltapThreshold: 200,
  longtapThreshold: 350,
  tapPrecision: 60/2,
  justTouchEvents: false,
})

import ParlorDetails from './components/ParlorDetails.vue';
import StudioProductList from './components/StudioProductList.vue';
import MonthlyProductChart from './components/MonthlyProductChart.vue';

import StudioReviews from './components/StudioReviews.vue';

import Coupon from './components/Coupon.vue';
const app = new Vue({
    el: '#app',
    components: {
        ProductUpload, 
        Tabs, 
        Tab,
        ToolTip, 
        ChartImpression,
        OrdersbyDate,
        ProductMiniChart,
        ProductReviews,
        ParlorDetails,
        StudioProductList,
        MonthlyProductChart,
        Coupon,
        OrderDetail,
        StudioReviews
      }
});

const story = new Vue({
    el: '[data-init="story"]',
    components: {
        AddStory, Sliders
      }
  });

  const megamenu = new Vue({
    el: '[data-init="nav"]',
    components: {
         AdminDropdown, CreateDropdown
      }
  });

const parlor = new Vue({
    el: '[data-init="parlor"]',
    components: {
        ParlorUpload
      }
});

const product = new Vue({
    el: '[data-init="product"]',
    components: {
      ProductSingle, 
      EditProduct,
      }
  });
  
  const varient = new Vue({
    el: '[data-init="varient"]',
    components: {
      ProductVarient
      }
  });
  const chartDashboard = new Vue({
    el: '[data-init="d-chart"]',
    components:{
      PlanetChart, 
    }
  })
  const studioSetting = new Vue({
    el: '[data-init="studio"]',
    components:{
      StudioSettings, TabsDyna,
    }
  })
