importScripts('https://www.gstatic.com/firebasejs/8.8.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.8.1/firebase-messaging.js');

firebase.initializeApp({
    apiKey: 'AIzaSyAB0_MbU6bNbLFPadjD3UxgU7YZLr0PN-g',
    authDomain: 'websites-6011b.firebaseapp.com',
    databaseURL: 'https://websites-6011b.firebaseio.com',
    projectId: 'websites-6011b',
    //storageBucket: 'websites-6011b.appspot.com',
    messagingSenderId: '41512814441',
    appId: '1:41512814441:web:c7019665ac69b83f955ff8',
    //measurementId: 'G-measurement-id',
});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);

    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/images/logo.png",
    };

    return self.registration.showNotification(
        title,
        options,
    );
});
