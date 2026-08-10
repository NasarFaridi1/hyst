importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js');

// Parse Firebase config from query parameters or fallback
const params = new URLSearchParams(self.location.search);

const firebaseConfig = {
    apiKey: params.get('apiKey') || "",
    authDomain: params.get('authDomain') || "",
    projectId: params.get('projectId') || "",
    storageBucket: params.get('storageBucket') || "",
    messagingSenderId: params.get('messagingSenderId') || "",
    appId: params.get('appId') || ""
};

if (firebaseConfig.apiKey && firebaseConfig.projectId) {
    try {
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        messaging.onBackgroundMessage(function(payload) {
            console.log('[firebase-messaging-sw.js] Received background message ', payload);

            // Ensure notification is displayed on devices (including iOS Safari & Android)
            const notificationTitle = payload.notification?.title || payload.data?.title || 'HYST Order Update';
            const notificationOptions = {
                body: payload.notification?.body || payload.data?.body || 'You have an order update.',
                icon: '/images/icons/icon-192x192.png',
                badge: '/images/icons/icon-72x72.png',
                sound: '/sounds/hyst_notification.mp3',
                vibrate: [200, 100, 200, 100, 200],
                data: payload.data || { click_action: payload.fcmOptions?.link || '/my-orders' },
                actions: [
                    { action: 'open', title: 'View Order' }
                ]
            };

            if (!payload.notification || (typeof Notification !== 'undefined' && Notification.permission === 'granted')) {
                self.registration.showNotification(notificationTitle, notificationOptions);
            }
        });
    } catch (e) {
        console.error('Firebase SW Init Error:', e);
    }
}

// Fallback push event handler for WebPush on iOS Safari
self.addEventListener('push', function(event) {
    if (!event.data) return;
    try {
        const payload = event.data.json();
        if (payload && (payload.notification || payload.data)) {
            const title = payload.notification?.title || payload.data?.title || 'HYST Order Update';
            const options = {
                body: payload.notification?.body || payload.data?.body || 'You have an order update.',
                icon: '/images/icons/icon-192x192.png',
                badge: '/images/icons/icon-72x72.png',
                data: payload.data || { click_action: payload.fcmOptions?.link || '/my-orders' }
            };
            event.waitUntil(self.registration.showNotification(title, options));
        }
    } catch (e) {
        // Silently ignore if already handled by FCM SDK
    }
});

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