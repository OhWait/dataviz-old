import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { fr, en } from 'vuetify/locale';
import '@mdi/font/css/materialdesignicons.css';

import 'vuetify/styles';

export const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
  },
  locale: {
    locale: 'fr',
    messages: { fr, en },
  },
});
