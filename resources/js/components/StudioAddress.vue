<template>
  <div>
    <div>
      <div class="mt-m mb">
        <h2>Businesss Address</h2>
        <span style="color: var(--gray-medium-dark)">
          Your business address is used as a pick-up location for delivery service. Only
          country and city will be visible to users in your studio description.
        </span>
        <div class="mt-m">
          <strong v-for="(a, i) in items" :key="i">
            <template>
              <div>
                <template v-if="a.apt"> {{ a.apt }}, </template>
                {{ a.street }}
              </div>
            </template>
            <template>
              <div>
                {{ a.city }}, {{ a.state }}
                <template v-if="a.postal">
                  {{ a.postal }}
                </template>
                <div>
                  {{ a.country }}
                </div>
              </div>
            </template>
          </strong>
          <div class="mt-m">
            <button @click="editAddress" class="btn-normalize btn-third">
              Edit your address
            </button>
          </div>
        </div>
        <div class="mt mb-m">
          <div>
            <h2>Contact</h2>
            <span>
              Add a payment method using our secure payment system, then start planning
              your next trip.
            </span>
            <div class="mt-m">
              <div class="flex-box stn-ctnr">
                <h3>Mobile Number</h3>
                <button v-if="!openEdit" @click="editMobile" class="btn-edt">Edit</button>
                <button v-else @click="cancleEdit" class="btn-edt">Cancle</button>
              </div>
              <template>
                <div v-if="openEdit">
                  <input type="text" v-model="mobile" />
                  <div>
                    <button
                      :disabled="!validMobile"
                      @click="saveNumber"
                      class="btn-normalize save-btn"
                    >
                      Save
                    </button>
                  </div>
                </div>
                <div v-else>
                  <span>{{ mobile }}</span>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="addBox" class="_SO_overlay">
      <div class="_SO_card">
        <div class="_SO_dialog round_c_b">
          <div class="_SO_d_t">
            <h1>Business Address</h1>
          </div>
          <div class="_SO_d_b">
            <div>
              <label for="addresscountry">Country</label>
              <div>
                <select name="country" id="addresscountry" v-model="address.country">
                  <option v-for="(c, k) in countries" :value="c.code" :key="k">
                    {{ c.name }}
                  </option>
                </select>
              </div>
            </div>
            <div>
              <label for="addresscity">City</label>
              <div>
                <input type="text" name="city" id="addresscity" v-model="address.city" />
              </div>
            </div>
            <div>
              <label for="addressstate">State</label>
              <div>
                <input
                  type="text"
                  name="state"
                  id="addressstate"
                  v-model="address.state"
                />
              </div>
            </div>
            <div>
              <label for="addressstreet">Street</label>
              <div>
                <input
                  type="text"
                  name="street"
                  id="addressstreet"
                  v-model="address.street"
                />
              </div>
            </div>
            <div>
              <label for="addressapt">Apt, suite, etc...</label>
              <div>
                <input type="text" name="apt" id="addressapt" v-model="address.apt" />
              </div>
            </div>
            <div>
              <label for="_postal">Postal Code</label>
              <div>
                <input
                  type="number"
                  name="postal"
                  id="_postal"
                  v-model="address.postal"
                />
              </div>
            </div>
          </div>
          <div style="padding: 15px" class="add-btn-wrap">
            <button @click="cancle" class="btn-normalize btn-secondary">Cancle</button>
            <button @click="save" class="btn-normalize btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      items: [],
      data: null,
      page: 0,
      exchangeRates: [],
      isLoading: false,
      canLoadMore: true,
      isFresh: false,
      addBox: false,
      countries: null,
      address: {
        city: "",
        state: "",
        country: "",
        street: "",
        postal: null,
        apt: "",
      },
      mobile: null,
      openEdit: false,
    };
  },
  computed: {
    validMobile: function () {
      if (
        this.data != null &&
        this.mobile.length >= 10 &&
        this.mobile != this.data.data[0].contact
      ) {
        return true;
      }
      return false;
    },
  },
  methods: {
    editAddress() {
      this.addBox = true;
    },
    cancle() {
      this.addBox = false;
    },
    save() {
      this.addBox = false;
      let addrData = new FormData();
      addrData.append("country", this.address.country);
      addrData.append("city", this.address.city);
      addrData.append("state", this.address.state);
      addrData.append("street", this.address.street);
      addrData.append("postal", this.address.postal);
      if (this.address.apt.length > 0) {
        addrData.append("apt", this.address.apt);
      }
      if (this.address.postal.length > 0) {
        addrData.append("postal", this.address.postal);
      }

      axios
        .post(this.$siteURL + "/studio/address/update/" + this.items[0].id, addrData)
        .then((res) => {
          this.items[0].apt = this.address.apt;
          this.items[0].city = this.address.city;
          this.items[0].state = this.address.state;
          this.items[0].street = this.address.street;
          this.items[0].country = this.address.country;
          this.items[0].postal = this.address.postal;

          this.$toast.success("Address Successfully Changed", {
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
        })
        .catch((err) => {
          this.$toast.error("Something went wrong.", {
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
    loadAddress() {
      axios
        .get(this.$siteURL + "/studio/addresses")
        .then((res) => {
          this.data = res.data;

          Object.values(res.data.data).forEach((e) => {
            this.items.push(e);
          });
          this.address.city = Object.values(res.data.data)[0].city;
          this.address.country = Object.values(res.data.data)[0].country;
          this.address.postal = Object.values(res.data.data)[0].postal;
          this.address.state = Object.values(res.data.data)[0].state;
          this.address.apt = Object.values(res.data.data)[0].apt;
          this.address.street = Object.values(res.data.data)[0].street;
          this.mobile = Object.values(res.data.data)[0].contact;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    editMobile() {
      this.openEdit = true;
    },
    cancleEdit() {
      this.openEdit = false;
      this.mobile = this.data.data[0].contact;
    },
    saveNumber() {
      let mobileData = new FormData();
      mobileData.append("number", this.mobile);

      axios
        .post(this.$siteURL + "/studio/mobile/update/" + this.items[0].id, mobileData)
        .then((res) => {
          this.openEdit = false;
          this.$toast.success("Contact number updated to " + this.mobile, {
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
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.loadAddress();
  },
  created() {
    axios.get(this.$siteURL + "/js/country/countries.json").then((result) => {
      this.countries = result.data;
    });
  },
};
</script>
