import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import primevue from 'primevue/config';

import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import InputText from 'primevue/inputtext';

import 'primevue/resources/themes/aura-light-blue/theme.css';

const cleanApp = () => {
    document.getElementById('app').removeAttribute('data-page');
};
createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ToastService)
            .use(primevue)
            .component('Toast', Toast)
            .component('InputText', InputText)

        app.mount(el);
    },
}).then(
    cleanApp()
);
