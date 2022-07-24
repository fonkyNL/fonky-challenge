import './bootstrap';
import '../scss/app.scss';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import GuestLayout from '@/Layouts/Guest.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const resolvedPage = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

        resolvedPage.then((page) => {
            if (page.default.layout !== undefined) {
                return;
            }

            if (name.startsWith('Auth/')) {
                page.default.layout = AuthenticatedLayout;
                return;
            }

            page.default.layout = GuestLayout;

        })

        return resolvedPage;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
