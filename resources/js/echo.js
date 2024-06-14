import Echo from "laravel-echo";
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '4b2d26fe1937b9bf5743',
    cluster: 'eu',
    encrypted: true
});

window.Echo
    .channel('logs')
    .listen('.TestEvent', (e) => {
        console.log("Event otrzymany");
        console.log(e);
    });
