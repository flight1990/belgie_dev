import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Link  } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import vuetify from "@/plugins/vuetify.js";

import AppLayout from "@/Layouts/App/Layout.vue";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || import.meta.env.VITE_APP_NAME;

createInertiaApp({

    // progress: {
    //     color: '#4ea15d',
    // },

    progress: false,

    title: (title) => `${appName}` + (title ? ` - ${title} ` : ''),

    resolve: (name) => {
        let parts = name.split('::');

        const page = parts.length > 1
            ? resolvePageComponent(`../../Modules/${parts[0]}/Resources/js/Views/${parts[1]}.vue`, import.meta.glob(`../../Modules/**/*.vue`))
            : resolvePageComponent(`./Views/${name}.vue`, import.meta.glob('./Views/**/*.vue'));

        page.then((module) => {
            module.default.layout = module.default.layout || AppLayout;
        });

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .component('inertia-link', Link)
            .mount(el)
    },
});
