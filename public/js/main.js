/* Service Worker */
if('serviceWorker' in navigator){
    window.addEventListener('load', ()=>{
        navigator.serviceWorker.register(window.location.protocol+'//' + window.location.hostname + '/serviceworker.js').then(reg=>{
            console.log('serviceworker: registered');
            // initPush();        
        })
        .catch(err =>{
            console.log(`service worker: error: ${err}`)
        })
    })
}

function initPush() {
  console.log('initializing push');
  if (!navigator.serviceWorker.ready) {
      return;
    }

  new Promise(function (resolve, reject) {
      const permissionResult = Notification.requestPermission(function (result) {
          resolve(result);
      });

      if (permissionResult) {
          permissionResult.then(resolve, reject);
      }
  })
      .then((permissionResult) => {
          if (permissionResult !== 'granted') {
              throw new Error('We weren\'t granted permission.');
          }
          subscribeUser();
      });
}


function subscribeUser() {
  navigator.serviceWorker.ready
      .then((registration) => {
          const subscribeOptions = {
              userVisibleOnly: true,
              applicationServerKey: urlBase64ToUint8Array(
                  'BHW_QS39vf-7bzpLz_T_THHt-pqLHkfoLwoGwJ4Pr4BEraZjZ65RGN3qy1jlw-c4mHP4oDS98mwLRBaq1XE_45A'
              )
          };

          return registration.pushManager.subscribe(subscribeOptions);
      })
      .then((pushSubscription) => {
          console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
          storePushSubscription(pushSubscription);
      });
}

function urlBase64ToUint8Array(base64String) {
  var padding = '='.repeat((4 - base64String.length % 4) % 4);
  var base64 = (base64String + padding)
      .replace(/\-/g, '+')
      .replace(/_/g, '/');

  var rawData = window.atob(base64);
  var outputArray = new Uint8Array(rawData.length);

  for (var i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

function storePushSubscription(pushSubscription) {
  const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

  fetch('/push', {
      method: 'POST',
      body: JSON.stringify(pushSubscription),
      headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-Token': token
      }
  })
      .then((res) => {
          return res.json();
      })
      .catch((err) => {
          console.log(err)
      });
}