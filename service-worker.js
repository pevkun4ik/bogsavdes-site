const CACHE_NAME = 'bogsavdes-cache-v1';
const urlsToCache = [
  '/',
  '/index.html',
  '/window-contacts.html',
  '/window-portf.html',
  '/window-entry.php',
  '/css/style.css',
  '/img/logo.png',
  '/img/svg/logo.svg',
  '/img/PH1.jpg',
  '/img/PH2.png',
  '/img/PH3.jpg',
  '/img/PH4.jpg',
  '/img/PH5.jpg',
  '/img/q1.jpeg',
  '/img/q2.jpg',
  '/img/q3.jpg',
  '/img/q4.jpg',
  '/img/q5.jpg'
];

self.addEventListener('install', (event) => {
  console.log('[SW] Установка...');
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('[SW] Кэширование ресурсов...');
      return Promise.all(
        urlsToCache.map(url =>
          cache.add(url).catch(err => {
            console.warn(`[SW] Не удалось кэшировать ${url}`, err);
          })
        )
      );
    })
  );
  self.skipWaiting(); // мгновенная активация
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((name) => {
          if (name !== CACHE_NAME) {
            return caches.delete(name);
          }
        })
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    fetch(event.request)
      .then((response) => {
        return response;
      })
      .catch(() => {
        return caches.match(event.request);
      })
  );
});