import { messages } from '@/plugins/i18n/index.js';
import { createI18n } from 'vue-i18n';

export const i18n = createI18n({
  legacy: false,
  locale: 'fr',
  fallbackFormat: 'en',
  messages,
});
