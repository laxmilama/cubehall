<template>
  <div>
    <div class="flex-box" style="justify-content: space-between; align-items: center">
      <h1>Payment Methods</h1>
      <button class="btn-normalize btn-primary btn_add_payment" @click.prevent="showBox">
        + Add payment method
      </button>
    </div>
    <div>
      <div>You can add up to 20 payment methods.</div>
      <table v-if="items.length > 0" class="mt" style="width: 100%">
        <tr>
          <td>Method</td>
          <td>Created At</td>
          <td>Action</td>
        </tr>
        <tr v-for="(payment, i) in items" :key="i">
          <td>
            <div>
              <strong>{{ payment.type }}</strong>
            </div>
            <div>
              <span>Name: {{ payment.bank_name }}</span>
            </div>
            <div v-if="payment.type == 'Bank'">
              <span>Account Number: {{ payment.address }}</span>
            </div>
            <div v-else>
              <span>Address: {{ payment.address }}</span>
            </div>
          </td>
          <td>
            {{ payment.created_at }}
          </td>
          <td>
            <button class="btn_pay_del" @click.prevent="deleteAccount(payment.id, i)">
              <svg
                data-v-75b34476=""
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="feather feather-trash"
              >
                <polyline data-v-75b34476="" points="3 6 5 6 21 6"></polyline>
                <path
                  data-v-75b34476=""
                  d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                ></path>
              </svg>
            </button>
          </td>
        </tr>
      </table>
    </div>
    <div v-if="PBox" class="_SVsf">
      <div class="_SO_overlay"></div>
      <div>
        <div class="_SO_card">
          <div class="_SO_dialog round_c_b">
            <div class="_SO_d_t">
              <h3 class="mt-s mb-s">Payment Option</h3>
            </div>
            <div class="_SO_d_b">
              <div>
                <div v-for="(option, i) in options" :key="i">
                  <input
                    type="radio"
                    :id="`_opt_` + option"
                    :value="option"
                    v-model="selected"
                  />
                  <label :for="`_opt_` + option">{{ option }}</label>
                </div>
              </div>
              <div class="mt-s">
                <template v-if="selected == 'Bank'">
                  <div class="inp_g">
                    <label for="addressName" class="inp_l">Full Name</label>
                    <div class="inp_r">
                      <input
                        disabled
                        type="text"
                        id="addressName"
                        name="street"
                        :placeholder="name"
                        spellcheck="false"
                        class="inp_height inp_100 inp_dissabled"
                      />
                    </div>
                  </div>
                  <div class="inp_g">
                    <label for="addressName" class="inp_l">Bank Name</label>
                    <div class="inp_r">
                      <input
                        type="text"
                        id="addressName"
                        name="street"
                        placeholder="Bank Name"
                        spellcheck="false"
                        class="inp_height inp_100"
                        v-model="bank_name"
                      />
                    </div>
                  </div>
                  <div class="inp_g">
                    <label for="addressName" class="inp_l">Account Number</label>
                    <div class="inp_r">
                      <input
                        type="number"
                        id="addressName"
                        name="street"
                        placeholder="Bank Name"
                        spellcheck="false"
                        class="inp_height inp_100"
                        v-model="address"
                      />
                    </div>
                  </div>
                </template>
                <template v-if="selected == 'Khalti'">
                  <div class="inp_g">
                    <label for="mobileNumber" class="inp_l">Khalti Mobile Number</label>
                    <div class="inp_r">
                      <input
                        type="number"
                        id="mobileNumber"
                        name="mobile"
                        placeholder="Your Name"
                        spellcheck="false"
                        class="inp_height inp_100"
                        v-model="address"
                      />
                    </div>
                  </div>
                </template>
              </div>
            </div>
            <div class="add-btn-wrap">
              <button class="btn-normalize btn-secondary" @click.prevent="closeBox">
                Cancle
              </button>
              <button
                @click.prevent="save"
                :disabled="!isValidForm"
                class="btn-normalize btn-third"
              >
                Save
              </button>
            </div>
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
      PBox: false,
      options: ["Bank", "Khalti"],
      selected: "",
      bank_name: "",
      address: "",
      items: JSON.parse(this.payments),
    };
  },
  props: ["name", "payments"],
  computed: {
    isValidForm: function () {
      if (this.selected == "Bank") {
        if (this.address.length >= 10 && this.bank_name.length >= 6) {
          return true;
        } else {
          return false;
        }
      } else if (this.selected == "Khalti") {
        if (this.address.length >= 10) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    },
  },
  methods: {
    closeBox() {
      this.PBox = false;
    },
    showBox() {
      this.PBox = true;
    },
    save() {
      let paymentData = new FormData();
      paymentData.append("address", this.address);
      paymentData.append("type", this.selected);
      console.log(this.selected);
      if (this.selected == "Bank") {
        paymentData.append("bank_name", this.bank_name);
      } else if (this.selected == "Khalti") {
        paymentData.append("bank_name", this.selected);
      }
      axios
        .post(this.$siteURL + "/account/payment/save", paymentData)
        .then((res) => {
          this.items.push(res.data);
          this.PBox = false;
        })
        .catch((err) => {
          if (err.response.status == 429) {
            this.$toast.error("Payment method already exists.", {
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
          } else if (err.response.status == 417) {
            this.$toast.error("You've reach the payment accounts limit.", {
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
            this.$toast.error("Something went wrong. Please try again later.", {
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
    deleteAccount(x, y) {
      let paymentData = new FormData();
      paymentData.append("id", x);
      axios
        .delete(this.$siteURL + "/account/payment/delete/" + x)
        .then((res) => {
          this.items.splice(y, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style scoped>
.add-btn-wrap {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  bottom: 0;
  width: 100%;
  position: relative;
  left: 0;
  padding: 10px;
  box-sizing: border-box;
  background-color: var(--gray-very-light);
}
.inp_dissabled:disabled {
  border-color: var(--gray-light);
}
.btn_add_payment {
  height: 40px;
}
td {
  padding: 8px;
}
.btn_pay_del {
  background: transparent;
  border: none;
}
</style>
