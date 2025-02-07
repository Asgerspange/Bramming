import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import primevue from 'primevue/config';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import InputText from 'primevue/inputtext';
import Paginator from 'primevue/paginator';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

import 'primevue/resources/themes/aura-light-blue/theme.css';
import '../css/app.css';

const store = createPinia();

store.use(piniaPluginPersistedstate);

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
            .use(store)
            .component('Toast', Toast)
            .component('DataTable', DataTable)
            .component('Column', Column)
            .component('InputText', InputText)
            .component('Paginator', Paginator);

        app.mount(el);
    },
}).then(
    cleanApp()
);
