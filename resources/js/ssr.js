import {createInertiaApp, Link} from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import {renderToString} from '@vue/server-renderer';
import {createSSRApp, h} from 'vue';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import vuetify from '@/plugins/vuetify';

import AppLayout from "@/Layouts/App/Layout.vue";
createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
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
        setup({App, props, plugin}) {
            return createSSRApp({render: () => h(App, props)})
                .use(plugin)
                .use(vuetify)
                .component('inertia-link', Link)
        },
    }),
);
