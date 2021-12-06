<template>
  <div>
    <div v-if="type === 'parlor'">
      <div id="installApp">
        <button class="btn-primary st_btn btn-normalize notifyBTN" id="butInstall">
          Notify me when parlor is ready.
        </button>
      </div>
    </div>
    <div v-if="type === 'product'">
      <div>
        <button id="installApp">
          Install app to get notice when your parlor is ready.
        </button>
      </div>
    </div>
    <div v-if="type === 'auth'">
      <div id="installApp" class="instwithBG">
        <div>
          <h3>Get easy access with our app.</h3>
          <p>It uses almost no storage and much more easier to use.</p>
        </div>
        <button class="btn-secondary instBTN_ btn-normalize notifyBTN" id="butInstall">
          Install
        </button>
      </div>
    </div>
    <div v-if="type === 'feed'">
      <div>haha</div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["type"],
  data() {
    return {};
  },
  mounted() {
    console.log("THis is nonsense");
    let deferredPrompt;
    var btnWrap = document.getElementById("installApp");
    btnWrap.classList.add("appInstallHidden");
    var btnAdd = document.getElementById("butInstall");

    btnAdd.addEventListener("click", (e) => {
      // hide our user interface that shows our A2HS button
      btnAdd.setAttribute("disabled", true);
      // btnWrap.style.display = "none";
      // Show the prompt
      deferredPrompt.prompt();
      // Wait for the user to respond to the prompt
      deferredPrompt.userChoice.then((resp) => {
        console.log(JSON.stringify(resp));
      });
    });
    window.addEventListener("beforeinstallprompt", (e) => {
      console.log("this is messed up");
      // Prevent the mini-info bar from appearing.
      e.preventDefault();
      // Stash the event so it can be triggered later.
      deferredPrompt = e;
      // Update UI notify the user they can add to home screen
      btnWrap.classList.remove("appInstallHidden");
      btnWrap.classList.add("appInstallVisible");
      btnAdd.removeAttribute("disabled");
    });

    window.addEventListener("appinstalled", () => {
      // Hide the app-provided install promotion
      hideInstallPromotion();
      // Clear the deferredPrompt so it can be garbage collected
      deferredPrompt = null;
      // Optionally, send analytics event to indicate successful install
      console.log("PWA was installed");
      btnWrap.classList.add("appInstallHidden");
    });

    // function initPush() {
    //   console.log("initializing push");
    //   if (!navigator.serviceWorker.ready) {
    //     return;
    //   }

    //   new Promise(function (resolve, reject) {
    //     const permissionResult = Notification.requestPermission(function (result) {
    //       resolve(result);
    //     });

    //     if (permissionResult) {
    //       permissionResult.then(resolve, reject);
    //     }
    //   }).then((permissionResult) => {
    //     if (permissionResult !== "granted") {
    //       throw new Error("We weren't granted permission.");
    //     }
    //     subscribeUser();
    //   });
    // }

    // function subscribeUser() {
    //   navigator.serviceWorker.ready
    //     .then((registration) => {
    //       const subscribeOptions = {
    //         userVisibleOnly: true,
    //         applicationServerKey: urlBase64ToUint8Array(
    //           "BHW_QS39vf-7bzpLz_T_THHt-pqLHkfoLwoGwJ4Pr4BEraZjZ65RGN3qy1jlw-c4mHP4oDS98mwLRBaq1XE_45A"
    //         ),
    //       };

    //       return registration.pushManager.subscribe(subscribeOptions);
    //     })
    //     .then((pushSubscription) => {
    //       console.log("Received PushSubscription: ", JSON.stringify(pushSubscription));
    //       storePushSubscription(pushSubscription);
    //     });
    // }

    // function urlBase64ToUint8Array(base64String) {
    //   var padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    //   var base64 = (base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");

    //   var rawData = window.atob(base64);
    //   var outputArray = new Uint8Array(rawData.length);

    //   for (var i = 0; i < rawData.length; ++i) {
    //     outputArray[i] = rawData.charCodeAt(i);
    //   }
    //   return outputArray;
    // }

    // function storePushSubscription(pushSubscription) {
    //   const token = document
    //     .querySelector("meta[name=csrf-token]")
    //     .getAttribute("content");

    //   fetch("/push", {
    //     method: "POST",
    //     body: JSON.stringify(pushSubscription),
    //     headers: {
    //       Accept: "application/json",
    //       "Content-Type": "application/json",
    //       "X-CSRF-Token": token,
    //     },
    //   })
    //     .then((res) => {
    //       return res.json();
    //     })
    //     .catch((err) => {
    //       console.log(err);
    //     });
    // }
  },
};
</script>
<style>
.appInstallVisible {
  display: block;
}
.appInstallHidden {
  display: none;
}
.notifyBTN {
  border-radius: 30px !important;
}
.instwithBG {
  background: var(--gradient);
  color: white;
  padding: 15px;
  box-sizing: content-box;
  text-align: center;
}
.instBTN_ {
  padding: 10px 45px;
  margin: 0 auto;
}
</style>
