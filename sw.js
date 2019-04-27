var CACHE_TITLE = "my-site-cache";
var CACHE_VERSION = "v1";
var CACHE_NAME = CACHE_TITLE + "-" + CACHE_VERSION;
// Add all features to include in Offline mode here
var urlsToCache = [
  "index.html",
  "pages/product.html",
  "pages/template.html",
  "assets/css/Style.css",
  "assets/images/bbt-72x72.png",
  "assets/images/bbt-96x96.png",
  "assets/images/bbt-128x128.png",
  "assets/images/bbt-144x144.png",
  "assets/images/bbt-152x152.png",
  "assets/images/bbt-192x192.png",
  "assets/images/bbt-384x384.png",
  "assets/images/bbt-512x512.png",
  "assets/images/bbt-icon.ico",
  "assets/images/bbt-logo.jpg",
  "assets/images/ICN_Registered.png",
  "assets/js/main.js",
  "assets/js/gestures.js",
  "assets/json/database.json"
];

// Install
self.addEventListener("install", function(event) {
	// Extend the lifetime of the event until all code inside is finished
	event.waitUntil(
		caches.open(CACHE_NAME).then(function(cache) {
			// Store (or install) our URLs we want to cache
			// console.log("[Service Worker] Install Successful");
			return cache.addAll(urlsToCache);
		})
	);
});

// Fetch
self.addEventListener("fetch", function(event) {
	// Prevent Browser's default handling method by calling respondWith()
	// ...allows us to change the behaviour of this fetch request
	event.respondWith(
		// If the cache is matching, then assign a function
		caches.match(event.request).then(function(response) {
				if (response) {
					// console.log("[Service Worker] Fetch Successful");
					return response;
				}
			return fetch(event.request);
			}
		)
	);
});

// Activate
self.addEventListener("activate", function(event) {
    event.waitUntil(
		caches.keys().then(function(cacheNames) {
			return Promise.all(
				cacheNames.map(function(cacheName) {
					if(cacheName !== CACHE_NAME && cacheName.indexOf(CACHE_TITLE) === 0) {
						return caches.delete(cacheName);
					}
				})
			);
		})
	);
});
