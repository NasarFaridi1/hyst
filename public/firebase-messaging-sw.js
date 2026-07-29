importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js');

// Parse Firebase config from query parameters or fallback
const params = new URLSearchParams(self.location.search);

const firebaseConfig = {
    apiKey: params.get('apiKey') || "AIzaSyDummyKey",
    authDomain: params.get('authDomain') || "hyst-app.firebaseapp.com",
    projectId: params.get('projectId') || "hyst-app",
    storageBucket: params.get('storageBucket') || "hyst-app.appspot.com",
    messagingSenderId: params.get('messagingSenderId') || "100000000000",
    appId: params.get('appId') || "1:100000000000:web:dummy"
};

if (firebaseConfig.apiKey && firebaseConfig.apiKey !== 'AIzaSyDummyKey') {
    try {
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        messaging.onBackgroundMessage(function(payload) {
            console.log('[firebase-messaging-sw.js] Received background message ', payload);

            const notificationTitle = payload.notification ? payload.notification.title : (payload.data ? payload.data.title : 'HYST Order Update');
            const notificationOptions = {
                body: payload.notification ? payload.notification.body : (payload.data ? payload.data.body : 'You have a new order update.'),
                icon: '/images/icons/icon-192x192.png',
                badge: '/images/icons/icon-72x72.png',
                data: payload.data || {},
                actions: [
                    { action: 'open', title: 'View Order' }
                ]
            };

            self.registration.showNotification(notificationTitle, notificationOptions);
        });
    } catch (e) {
        console.error('Firebase SW Init Error:', e);
    }
}

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    const urlToOpen = event.notification.data && event.notification.data.click_action 
        ? event.notification.data.click_action 
        : '/my-orders';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(windowClients => {
            for (let i = 0; i < windowClients.length; i++) {
                const client = windowClients[i];
                if (client.url.includes(urlToOpen) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(urlToOpen);
            }
        })
    );
});