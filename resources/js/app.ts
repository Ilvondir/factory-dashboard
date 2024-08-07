import {createApp, h, DefineComponent} from 'vue';
import {createInertiaApp, Head, Link} from '@inertiajs/vue3';

import "ua-parser-js";

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import 'bootstrap-icons/font/bootstrap-icons.css';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';

import "./styles/app.css";

import {connectToLogs, initializeEcho} from "@/echo";

import "vue-multiselect/dist/vue-multiselect.css"

createInertiaApp({
    resolve: name => {
        // @ts-ignore
        const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', {eager: true})
        return pages[`./pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)})
            .use(plugin)
            .use(Toast)
            .component('inertia-head', Head)
            .component('inertia-link', Link);

        initializeEcho();
        connectToLogs();

        app.mount(el);
    },
    progress: {
        color: '#0d6efd',
        showSpinner: true,
    }
});
