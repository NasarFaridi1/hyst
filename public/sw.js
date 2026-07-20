self.addEventListener('install', () => {

console.log('PWA Installed');

self.skipWaiting();

});

self.addEventListener('activate', () => {

console.log('PWA Active');

});

self.addEventListener('fetch', (event) => {

event.respondWith(

fetch(event.request)

);

});