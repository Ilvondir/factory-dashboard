import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', {eager: true})
        return pages[`./pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .component('inertia-head', Head)
            .component('inertia-link', Link)
            .mount(el);
    },
});
