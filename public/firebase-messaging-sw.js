importScripts(

'https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js'

);

importScripts(

'https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js'

);

firebase.initializeApp({

    apiKey:
    "AIzaSyCZiAT9MHsByPZXwiNN05bdQm3J_T6dLOY",

    authDomain:
    "food-app-67243.firebaseapp.com",

    projectId:
    "food-app-67243",

    storageBucket:
    "food-app-67243.firebasestorage.app",

    messagingSenderId:
    "27556705584",

    appId:
    "1:27556705584:web:c5a44d5b5b9e241b0a84f5",

    measurementId:
    "G-B191S3TCSD"
});

const messaging =
    firebase.messaging();

messaging.onBackgroundMessage(

function(payload) {

    self.registration.showNotification(

        payload.notification.title,

        {

            body:
            payload.notification.body
        }
    );
});