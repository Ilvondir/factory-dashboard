import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import {Log} from "@/models/log";
import {useToast} from "vue-toastification";
import Toast from "@/components/toast/Toast.vue";

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
            .listen('.NewLog', (message: any) => {

                switch (message.log.action.id) {
                    case 1:

                        toast.success({
                            component: Toast,
                            props: {
                                operation: message.log.operation,
                                user: message.log.user
                            }
                        }, {icon: false});

                        break;
                    case 2:

                        toast.info({
                            component: Toast,
                            props: {
                                operation: message.log.operation,
                                user: message.log.user
                            }
                        }, {icon: false});

                        break;
                    case 3:

                        toast.error({
                            component: Toast,
                            props: {
                                operation: message.log.operation,
                                user: message.log.user
                            }
                        }, {icon: false});

                        break;
                    case 4:

                        toast.warning({
                            component: Toast,
                            props: {
                                operation: message.log.operation,
                                user: message.log.user
                            }
                        }, {icon: false});

                        break;
                }

            });


    }

}
