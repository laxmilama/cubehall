export default {    
    convertedPrice(amount, from) {
        if (from == this.currency) {
          return amount;
        } else {
          return (
            (amount * this.exchangeRates[this.currency]) /
            this.exchangeRates[from]
          ).toFixed(2);
        }
      },
      getExchangeRates() {
        axios
          .get(this.$siteURL + "/api/v1/exchangerates")
          .then((res) => {
            this.exchangeRates = res.data;
          })
          .catch((error) => {
            colsole.log(error);
          });
      },
  }