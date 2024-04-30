// service-worker.js
const CACHE_NAME = 'tespack';
const urlsToCache = [
  '/'
//   '/styles.css',
//   '/app.js',
//   '/logo.png',
  // Add more assets to cache here
];

// Install the service worker and cache assets
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(urlsToCache);
      })
  );
});

// Activate the service worker and clean up old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheName !== CACHE_NAME) {
              return caches.delete(cacheName);
            }
          })
        );
      })
  );
});

// Fetch assets from the cache or the network
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then((response) => {
        return response || fetch(event.request);
      })
  );
});

// Handle push notifications
// self.addEventListener('push', (event) => {
//   const payload = event.data ? event.data.text() : 'New notification';
//   event.waitUntil(
//     self.registration.showNotification('My PWA', {
//       body: payload,
//       icon: '/notification-icon.png'
//     })
//   );
// });
