import { mount } from '@vue/test-utils';
import MetaDetail from '@/features/metaColumn/MetaTable.vue';
import PreviewDetail from '@/features/dataEntry/TablePreview.vue';
import { createI18n } from 'vue-i18n';
import DataEntryDetail from '@/features/dataset/detail/DataEntryDetail.vue';
import { dataEntryFactory } from '@test/data/dataEntryFactory';

const i18n = createI18n({
  locale: 'en',
  messages: {
    en: {
      dataset: { tab: { meta: 'Metadata', preview: 'Preview' } },
    },
  },
});

vi.mock('@/features/metaColumn/MetaTable.vue', () => ({
  default: { template: '<div>MockMetaDetail</div>' },
}));

vi.mock('@/features/dataEntry/TablePreview.vue', () => ({
  default: { template: '<div>MockPreviewDetail</div>' },
}));


const mockDataEntries = dataEntryFactory.buildList(3);

describe('DateEntryDetail.vue', () => {
  let wrapper: any;

  beforeEach(() => {
    wrapper = mount(DataEntryDetail, {
      global: { plugins: [i18n] },
      props: { dataEntries: mockDataEntries },
    });
  });

  it('renders correctly with multiple data entries', () => {
    expect(wrapper.find('#data-entry-tabs').exists()).toBe(true);
    expect(wrapper.findAll('#data-entry-tabs .v-tab')).toHaveLength(mockDataEntries.length);
  });

  it('switches between data entries when tabs are clicked', async () => {
    const tabs = wrapper.findAll('.v-tab');
    await tabs[1].trigger('click');
    expect(wrapper.vm.currentDataEntry).toEqual(mockDataEntries[1]);
  });

  it('renders metadata and preview tabs', () => {
    expect(wrapper.find('#meta-tabs').exists()).toBe(true);
    expect(wrapper.findAll('#meta-tabs .v-tab')).toHaveLength(2);
  });

  it('switches between metadata and preview components', async () => {
    const metaTab = wrapper.findAll('#meta-tabs .v-tab')[0];
    const previewTab = wrapper.findAll('#meta-tabs .v-tab')[1];
    
    await metaTab.trigger('click');
    expect(wrapper.findComponent(MetaDetail).exists()).toBe(true);
    
    await previewTab.trigger('click');
    expect(wrapper.findComponent(PreviewDetail).exists()).toBe(true);
  });
});
