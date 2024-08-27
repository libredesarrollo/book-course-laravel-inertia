import './bootstrap';
import '../css/app.css';

// ORUGA
import Oruga from '@oruga-ui/oruga-next'
import '@oruga-ui/theme-oruga/dist/oruga.min.css'

// Material Design
import '@mdi/font/css/materialdesignicons.min.css'

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// CKEDITOR
import { CkeditorPlugin  } from '@ckeditor/ckeditor5-vue';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Oruga)
            .use(ZiggyVue)
            .use(CkeditorPlugin )
            .mount(el);
    },
    progress: {

        color: '#29d',
    },

});
