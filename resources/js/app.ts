import './bootstrap';
import '../css/app.css';
import 'element-plus/dist/index.css'

import { createApp, h, DefineComponent } from 'vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createHead } from '@vueuse/head';
import ArrowsExpand from './Components/Icons/ArrowsExpand.vue';
import ArrowsCollapse from './Components/Icons/ArrowsCollapse.vue';

const head = createHead();

createInertiaApp({
    title: (title) => title ?? 'Haventwined',
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(head)
            .use(ZiggyVue);

        app.component('ArrowsExpand', ArrowsExpand);
        app.component('ArrowsCollapse', ArrowsCollapse);

        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});