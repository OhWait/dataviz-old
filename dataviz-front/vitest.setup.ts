import { expect, it, describe, test, vi } from 'vitest';
import { config, RouterLinkStub } from '@vue/test-utils';
import { createI18n } from 'vue-i18n';
import { createVuetify } from 'vuetify';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import 'vuetify/styles';

// Mock ResizeObserver globally
global.ResizeObserver = class {
  observe() {}
  unobserve() {}
  disconnect() {}
};

// Configurer i18n avec des messages de mock
const i18n = createI18n({
  locale: 'en',
  legacy: false,
  messages: {
    en: { dataset: 'Dataset' },
    fr: { dataset: 'Ensemble de données' },
  },
});

// Configurer Vuetify
const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
});
const RouterLinkStb = { ...RouterLinkStub, useLink: vi.fn() };

// Ajouter Vuetify aux plugins globaux de Vue Test Utils
config.global.plugins = [vuetify, i18n];
config.global.mocks = {
  RouterLink: RouterLinkStb,
};

// Ajouter les globales pour Vitest
globalThis.expect = expect;
globalThis.it = it;
globalThis.describe = describe;
globalThis.test = test;
globalThis.vi = vi;
