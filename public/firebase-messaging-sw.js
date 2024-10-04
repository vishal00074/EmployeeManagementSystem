importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyCXZkh0PnC5vmwA5Aq8muqThPfBSfdR-tw",
    projectId: "laravel-aa589",
    messagingSenderId: "250691320881",
    appId: "1:250691320881:web:cb451d506e847d53ace910"
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});