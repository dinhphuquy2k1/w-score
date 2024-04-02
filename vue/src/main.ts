import {createApp} from 'vue'
import App from './App.vue'
import PrimeVue from 'primevue/config';
import Tooltip from 'primevue/tooltip';
import ToastService from 'primevue/toastservice';
import {FORM_MODE} from '@/common/enums';
import Toast from 'primevue/toast';
import './registerServiceWorker'
import router from './router'
import store from './store'

const app = createApp(App);
app.directive('tooltip', Tooltip);
app.component('Toast', Toast);
app.config.globalProperties.FormMode = FORM_MODE;
app.use(store)
    .use(PrimeVue)
    .use(router)
    .use(ToastService)
    .mount('#app')

