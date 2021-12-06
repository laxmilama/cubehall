const version = 0.1;
let assets = `ch-assets-v${version}`;
let images = `ch-local-images-v${version}`;

let OFFLINE_VERSION = 5;
let CACHE_NAME = "offline";
// Customize this with a different URL if needed.
let OFFLINE_URL = "/offline-2021.html";


self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll([
        '/offline-2021.html'
      ]))
  );

  // Force the waiting service worker to become the active service worker.
  self.skipWaiting();
});


// self.addEventListener("install", (event) => {
//   event.waitUntil(
//     (async () => {
//       const cache = await caches.open(CACHE_NAME);
//       // Setting {cache: 'reload'} in the new request will ensure that the
//       // response isn't fulfilled from the HTTP cache; i.e., it will be from
//       // the network.
//       await cache.add(new Request(OFFLINE_URL, { cache: "reload" }));
//     })()
//   );
//   // Force the waiting service worker to become the active service worker.
//   self.skipWaiting();
// });


self.addEventListener('activate', ev => {
  ev.waitUntil(clients.claim());

  console.log('Service Worker: Activated');
  ev.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cache => {
          if (cache !== assets) {
            console.log('Removile old cache');
            return caches.delete(cache);
          }
          if (cache !== images) {
            console.log('Removile old cache');
            return caches.delete(cache);
          }
        })
      )
    })
  );
});


self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.open(assets).then(function (cache) {
      return cache.match(event.request).then(function (response) {
        return response || fetch(event.request).then(function (response) {
          let type = response.headers.get('content-type');
          // console.log(type);
          if ((type && type.match(/^application\/javascript/i)) ||

            (type && type.match(/^text\/css/i)) ||
            (type && type.match(/^image\//i))) {
            // css to save in dynamic cache
            // console.log(`save a image file ${ev.request.url}`);
            cache.put(event.request, response.clone());
            return response;
          }
          // cache.put(event.request, response.clone());
          return response;
        });
      });
    })
  );
});



self.addEventListener('notificationclick', function (event) {
  var messageId = event.notification.data;

  event.notification.close();

 if (event.action === 'Show Ticket') {
    clients.openWindow("/ticket?show=" + messageId);
  }
  else {
    clients.openWindow("/?action=" + messageId);
  }
},
  false);

self.addEventListener('push', function (e) {
  if (!(self.Notification && self.Notification.permission === 'granted')) {
    //notifications aren't supported or permission not granted!
    return;
  }

  if (e.data) {
    var msg = e.data.json();
    console.log(msg)
    e.waitUntil(self.registration.showNotification(msg.title, {
      body: msg.body,
      icon: msg.icon,
      actions: msg.actions
    }));
  }
});



