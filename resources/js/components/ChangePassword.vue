<template>
  <div style="margin-top: 40px; margin-bottom: 40px">
    <div class="row">
      <div class="">
        <div>
          <h1>Change Password</h1>
        </div>
        <div>
          <div v-if="error">
            {{ error.message }}
          </div>
          <form action="">
            <div class="_STn_password_card">
              <aside class="_STn_password">
                <label for="_old">Old Password</label>
              </aside>
              <div>
                <input
                  class="_STn_password_input"
                  type="password"
                  v-model="oldPassword"
                  autocomplete
                  id="_old"
                />
              </div>
            </div>
            <div class="_STn_password_card">
              <aside class="_STn_password">
                <label for="_new">New Password</label>
              </aside>
              <div>
                <input
                  class="_STn_password_input"
                  type="password"
                  v-model="newPassword"
                  id="_new"
                />
              </div>
            </div>
            <div class="_STn_password_card">
              <aside class="_STn_password">
                <label for="_confirm">Confirm New Password</label>
              </aside>
              <div>
                <input
                  class="_STn_password_input"
                  type="password"
                  v-model="confirmPassword"
                  id="_confirm"
                />
              </div>
            </div>
            <div>
              <button
                :disabled="!validatePasswordField"
                @click.prevent="changePassword"
                class="btn-normalize"
              >
                Change Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    person: Object,
  },
  data() {
    return {
      newPassword: "",
      oldPassword: "",
      confirmPassword: "",
      error: "",
    };
  },
  methods: {
    reset() {
      this.newPassword = "";
      this.oldPassword = "";
      this.confirmPassword = "";
    },
    changePassword() {
      let password = new FormData();
      password.append("newPassword", this.newPassword);
      password.append("oldPassword", this.oldPassword);
      password.append("confirmPassword", this.confirmPassword);
      password.append("userId", this.person.id);
      axios
        .post(this.$siteURL + "/account/security/changepassword", password)
        .then((res) => {
          this.reset();
          this.$toast.success("Your password has been changed.", {
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
        .catch((error) => {
          console.log(error);
          this.error = error.message;

          this.$toast.error("Failed to change password.", {
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
  mounted() {
    console.log("Component mounted.");
  },
  computed: {
    validatePasswordField: function () {
      if (this.newPassword.length > 6) {
        if (this.newPassword == this.confirmPassword) {
          if (this.oldPassword.length > 6) {
            return true;
          }
        }
      }
      return false;
    },
  },
};
</script>
