import { mount } from '@vue/test-utils';
import { nextTick } from 'vue';
import { createI18n } from 'vue-i18n';
import { vi } from 'vitest';
import { VForm } from 'vuetify/lib/components/index.mjs';
import CartesianForm from '@/components/dataviz/chart/form/CartesianForm.vue';
import { datasetFactory } from '@test/data/dataviz/datasetFactory';
import { cartesianFormFactory } from '@test/data/dataviz/chartPayloadFactory';
import { View } from '@/@types/dataviz/chart';

// Mocks des dépendances
vi.mock('@/utils/viewList', () => ({
  reversedCartesianAxe: [],
}));

const i18n = createI18n({
  locale: 'fr',
  messages: {
    fr: {
      'form.required': 'Ce champ est requis',
    },
  },
});

describe('CartesianForm.vue', () => {
  const dataset = datasetFactory.build();
  const payload = cartesianFormFactory.build();

  const payloadMock = {
    distribution: { dataEntry: 'entry1', column: 'col1' },
    operation: { dataEntry: 'entry1', column: 'col1', operation: 'sum' },
    serie: { dataEntry: 'entry1', column: null },
  };

  it('should mount correctly', async () => {
    const wrapper = mount(CartesianForm, {
      props: {
        currentView: View.BarChart,
        payload,
        dataset,
      },
      global: { plugins: [i18n] },
    });

    await nextTick();
    expect(wrapper.exists()).toBe(true);
  });
});
