import { createApp } from 'vue';

import App from './App.vue';
import { store, key } from '@/store';
import { vuetify } from '@/plugins/vuetify';
import { i18n } from '@/plugins/i18n';
import { router } from '@/router';

createApp(App).use(vuetify).use(store, key).use(router).use(i18n).mount('#app');
