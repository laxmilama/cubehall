<template>
  <div class="container">
    <div class="flex-box">
      <div>
        <h1>Checkout</h1>
        <div>{{ paisa }}</div>
      </div>
      <div>
        <div>
          <address>Falano</address>
        </div>
        <button @click.prevent="payWithKhalti">Pay with Khalti</button>
      </div>
    </div>
  </div>
</template>

<script>
import KhaltiCheckout from "khalti-checkout-web";
import { forEach } from "lodash";
export default {
  props: { items: Array },
  data() {
    return {
      success: false,
      gateway: "",
      total: 0,
      config: {
        // replace this key with yours
        publicKey: "test_public_key_b4e6e360329b4c1685dcee51f8aa83ff",
        productIdentity: "product",
        productName: "product",
        productUrl: window.location.href,
        eventHandler: {
          onSuccess(payload) {
            // hit merchant api for initiating verfication
            console.log(payload);
            self.purchase(payload.token);
          },
          // onError handler is optional
          onError(error) {
            // handle errors
            console.log(error);
          },
          onClose() {
            console.log("widget is closing");
          },
        },
        paymentPreference: ["KHALTI", "MOBILE_BANKING", "CONNECT_IPS", "SCT"],
      },
    };
  },
  methods: {
    async payWithKhalti() {
      let checkout = new KhaltiCheckout(this.config);
      this.gateway = "Khalti";
      var temp = 0;
      this.items.forEach((e) => {
        temp = temp + e.bagmetaproduct.price;
      });
      var from = this.items[0].bagmetaproduct.currency;
      if (from == "NPR") {
        this.total = temp;
      } else {
        var requestURL =
          "https://api.exchangerate.host/convert?from=" + from + "&to=NPR&amount=" + temp;

        var instance = axios.create({
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        await instance
          .get(requestURL)
          .then((res) => {
            // console.log(res);
            this.total = res.data.result;
            // console.log(res.data.result);
          })
          .catch((error) => {
            console.log(error);
          });
      }
      checkout.show({
        amount: 100 * this.total,
      });
    },

    purchase(token) {
      let purchaseData = new FormData();
      purchaseData.append("userID", this.useid);
      purchaseData.append("method", this.gateway);
      purchaseData.append("token", token);
      purchaseData.append("totalAmount", 120);

      axios
        .post(this.$siteURL + "/payment/verification", purchaseData)
        .then((res) => {
          this.success = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
