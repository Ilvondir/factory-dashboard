import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '4b2d26fe1937b9bf5743',
    cluster: 'eu',
    encrypted: true
});

Echo.private('chat')
    .listen('message', (e) => {
        console.log(e);
    })
