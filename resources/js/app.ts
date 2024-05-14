import {createApp, h, DefineComponent} from 'vue';
import {createInertiaApp, Head, Link} from '@inertiajs/vue3';
import 'bootstrap-icons/font/bootstrap-icons.css';

createInertiaApp({
    resolve: name => {
        // @ts-ignore
        const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', {eager: true})
        return pages[`./pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .component('inertia-head', Head)
            .component('inertia-link', Link)
            .mount(el);
    },
    progress: {
        color: '#0d6efd',
        showSpinner: true,
    }
});
