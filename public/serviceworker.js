// nama cache
var staticCacheName = "pwa-v" + new Date().getTime();

// file yang ingin di cache (terutama css agar saat offline css masih terbaca)
var filesToCache = [
    ".",
    "/posts/",
    "/css/sb-admin-2.min.css",
    "/js/sb-admin-2.min.js",
    "/offline",
    "/css/app.css",
    "/js/app.js",
    "/images/icons/icon-72x72.png",
    "/images/icons/icon-96x96.png",
    "/images/icons/icon-128x128.png",
    "/images/icons/icon-144x144.png",
    "/images/icons/icon-152x152.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-384x384.png",
    "/images/icons/icon-512x512.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    // menghindari konflik antar service worker
    this.skipWaiting();

    // memastikan bahwa semua filesToCache di cache statis saat service worker diinstal
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

/**
 * Cache page yang sedang dibuka dan update cache dengan respons terbaru dari network.
 * Fungsi ini akan mengambil respons dari netwoek dan menyimpannya dalam cache statis.
 */
const update = (request) =>
    caches
        .open(staticCacheName)
        .then((cache) =>
            fetch(request).then((response) => cache.put(request, response))
        );

/**
 * Fetch data dari network. Mengembalikan promise yang mengambil response dari network
 * Jika berhasil maka jalankan fungsi update untuk memperbarui cache dengan response teserbut
 **/
const fromNetwork = (request, timeout) =>
    new Promise((fulfill, reject) => {
        const timeoutId = setTimeout(reject, timeout);
        fetch(request).then((response) => {
            clearTimeout(timeoutId);
            fulfill(response);
            update(request);
        }, reject);
    });

/**
 * Cari response dari cache statis (using match).
 * Jika request dan response yang diterima cocok, maka ambil data dari cache
 * Jika tidak maka tampilkan halaman offline
 */
const fromCache = (request) =>
    caches
        .open(staticCacheName)
        .then((cache) =>
            cache
                .match(request)
                .then((matching) => matching || cache.match("offline"))
        );

/**
 * Untuk menangani pengambilan data dari aplikasi.
 */
self.addEventListener("fetch", (evt) => {
    /**
     * Jika cache sudah ada dan online, maka ganti response dari cache tersebut dengan response yang diberikan oleh network
     * Jika cache sudah ada dan offline, maka tetap ambil response dari cache
     */
    evt.respondWith(
        fromNetwork(evt.request, 10000).catch(() => fromCache(evt.request))
    );
    
    // memastikan bahwa cache selalu diperbarui dengan respons terbaru dari network
    evt.waitUntil(update(evt.request));
});
