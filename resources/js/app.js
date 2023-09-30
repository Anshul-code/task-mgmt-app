import './bootstrap';
import './config/api'
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import store from './store';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp(App);
app.use(router);
app.use(store);
app.use(Toast, {
    timeout: 4000,
});
app.mount('#app');