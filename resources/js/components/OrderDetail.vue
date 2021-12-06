<template>
  <div>
    <div class="row">
      <div class="ct12 box-bound margin10px content_border">
        <h2>Product Detail</h2>
        <table width="100%">
          <tr class="table_header">
            <td>Product Image</td>
            <td>Product Name</td>
            <td>SKU</td>
            <td>Quantity</td>
            <td>Product Price</td>
            <td>Total</td>
          </tr>
          <tr class="table_container">
            <td v-if="order.thumbnail">
              <img
                img
                class="list-img"
                :src="'http://192.168.1.85/images/product/thumb/' + order.thumbnail"
              />
            </td>
            <td>
              {{ order.product.productmeta.name }}
            </td>
            <td>
              {{ order.product.sku }}
            </td>
            <td>{{ order.quantity }}</td>
            <td>{{ order.price }}</td>
            <td>{{ order.price * order.quantity }}</td>
            <td></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="ct12 box-bound margin10px content_border padding10px">
        <h2>Delivery Address</h2>
        <table width="100%">
          <tr class="table_container">
            <td>
              <div>
                <span>{{ delivery.street }}</span>
              </div>
              <div>
                <span>{{ delivery.city }}</span>
              </div>
              <div>
                <span>{{ delivery.apt }}</span>
              </div>
              <div>
                {{ delivery.country }}
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div v-if="order.status != 'New'">
      <div class="ct12 box-bound margin10px content_border padding10px">
        <h2>Cutomer Details</h2>
        <table width="100%">
          <tr class="table_container">
            <td>
              <div>
                <span>{{ delivery.name }}</span>
              </div>
              <div>
                <span>{{ delivery.contact }}</span>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="ct12 box-bound margin10px content_border padding10px">
        <h2>Order Status</h2>
        <table style="width: 100%">
          <tr>
            <td>
              <select
                name="order_status"
                id="order_status"
                class="form-control _inp_admn"
                v-model="currentStatus"
              >
                <option v-for="(s, i) in status" :key="i" :value="s">{{ s }}</option>
              </select>
            </td>
            <td>
              <button
                :disabled="canUpdate"
                type="submit"
                class="btn-normalize btn-third"
                @click.prevent="updateStatus"
              >
                <span v-if="!isLoading"> Update Status </span>
                <span v-else> Please wait... </span>
              </button>
            </td>
          </tr>
          <tr v-if="currentStatus == 'Ready'">
            <td>
              <template v-if="order.pickup_at == null">
                <div>
                  <div>
                    <label for="pickupdate">
                      <span> Pickup Date </span>
                    </label>
                  </div>
                  <input
                    type="datetime-local"
                    name=""
                    id="pickupdate"
                    v-model="pickupAt"
                  />
                </div>
                <div>
                  <div>
                    <label for="message"> Any note to delivery person? </label>
                  </div>
                  <div>
                    <textarea
                      name=""
                      id=""
                      cols="30"
                      rows="10"
                      v-model="message"
                    ></textarea>
                  </div>
                </div>
              </template>
              <template v-else>
                <div>
                  <div>
                    <span>Pickup At: {{ order.pickup_at }}</span>
                  </div>
                </div>
                <div v-if="order.pickup_note">
                  <div>Message to delivery person</div>
                  <div>
                    {{ order.pickup_note }}
                  </div>
                </div>
              </template>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div>
      <div class="ct12 box-bound margin10px content_border padding10px">
        <h2>Delivery Status</h2>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["order"],
  data() {
    return {
      pickupAt: null,
      message: null,
      currentStatus: this.order.status,
      isLoading: false,
      delivery: JSON.parse(this.order.orderproduct.delivery),
      status: ["New", "Processing", "Ready", "Cancelled"],
    };
  },
  mounted() {
    let that = this;
    let interceptor = axios.interceptors.request.use(
      function (config) {
        that.isLoading = true;
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );
    axios.interceptors.response.use(
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
  },
  computed: {
    canUpdate: function () {
      if (this.order.status != this.currentStatus) {
        return false;
      } else {
        if (this.currentStatus == "Ready") {
          if (this.pickupAt == null) {
            return false;
          } else {
            return true;
          }
        } else if (this.order.status == "Ready" && this.currentStatus == "Cancled") {
          return false;
        } else if (this.order.status == "Ready") {
          if (this.currentStatus == "New" || this.currentStatus == "Processing") {
            return false;
          }
        } else if ((this.order.stauts == "Processing") & (this.currentStatus == "New")) {
          return false;
        } else {
          return true;
        }
      }
    },
  },
  methods: {
    updateStatus() {
      let statusData = new FormData();
      statusData.append("id", this.order.id);
      statusData.append("order_id", this.order.orderproduct.id);
      statusData.append("order_status", this.currentStatus);
      if (this.currentStatus == "Ready") {
        statusData.append("message", this.message);
        statusData.append("pickup_date", this.pickupAt);
      }
      axios
        .post(this.$siteURL + "/studio/order-status-update", statusData)
        .then((res) => {
          this.$toast.success(
            "Updated status to " + this.order.status + " successfully!",
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
        })
        .catch((err) => {
          this.$toast.error("Action failed!", {
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
        });
    },
  },
};
</script>
