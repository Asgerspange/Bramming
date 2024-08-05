import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import App from './App.vue';

const laravelDataScript = document.getElementById('oi234j234n1');
if (laravelDataScript) {
    const laravelData = JSON.parse(laravelDataScript.textContent);
    window.laravel = laravelData;
}


const app = createApp(App)
app.use(router)

app.mount('#app');