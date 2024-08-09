import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import App from './App.vue';
import primevue from 'primevue/config';

import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import InputText from 'primevue/inputtext';

import 'primevue/resources/themes/aura-light-blue/theme.css';

const laravelDataScript = document.getElementById('oi234j234n1');
if (laravelDataScript) {
    const laravelData = JSON.parse(laravelDataScript.textContent);
    window.laravel = laravelData;
}


const app = createApp(App)
app.use(router)
app.use(primevue)
app.use(ToastService)
app.component('Toast', Toast)
app.component('InputText', InputText)

app.mount('#app');