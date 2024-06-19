import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import {Log} from "@/models/log";
import {useToast} from "vue-toastification";

let echoInstance: any = null;
const toast = useToast();

export function initializeEcho() {
    // @ts-ignore
    window.Pusher = Pusher;
    echoInstance = new Echo({
        broadcaster: 'pusher',
        key: '4b2d26fe1937b9bf5743',
        cluster: 'eu',
        encrypted: true
    });
}

export function getEcho() {
    return echoInstance;
}

export function disconnectEcho() {
    echoInstance.leave('logs');
}

export function connectToLogs() {

    if (document.URL.slice(-5) !== "login") {

        echoInstance.private('logs')
            .listen('.NewLog', (e: Log) => {
                toast.success("New log from socket!");
            });


    }

}
