import { mount } from '@vue/test-utils';
import { vi } from 'vitest';
import DataEntryDetail from '@/features/dataset/detail/DataEntryDetail.vue';
import MetaTable from '@/features/metaColumn/MetaTable.vue';
import TablePreview from '@/features/dataEntry/TablePreview.vue';
import { dataEntryFactory } from '@test/data/dataEntryFactory.js';

vi.mock('@/features/metaColumn/MetaTable.vue', async importOriginal => {
  const original = await importOriginal();
  return {
    ...original,
    default: {
      name: 'MetaTable',
      props: ['metaColumns'],
      template: '<div></div>',
    },
  };
});

vi.mock('@/features/dataEntry/TablePreview.vue', async importOriginal => {
  const original = await importOriginal();
  return {
    ...original,
    default: {
      name: 'TablePreview',
      props: ['slug'],
      template: '<div></div>',
    },
  };
});

describe('DataEntryDetail.vue', () => {
  it('renders tabs when there are multiple data entries', () => {
    const dataEntries = dataEntryFactory.buildList(2);

    const wrapper = mount(DataEntryDetail, {
      props: {
        dataEntries,
      },
    });

    expect(wrapper.find('#data-entry-tabs').exists()).toBe(true);
    expect(wrapper.findAll('#data-entry-tabs .v-tab').length).toBe(
      dataEntries.length
    );
  });

  it('does not render tabs when there is a single data entry', () => {
    const dataEntries = dataEntryFactory.buildList(1);

    const wrapper = mount(DataEntryDetail, {
      props: {
        dataEntries,
      },
    });

    expect(wrapper.find('#data-entry-tabs').exists()).toBe(false);
    expect(wrapper.find('#data-entry-tabs-window').exists()).toBe(true);
  });

  it('renders MetaTable component with correct props for Meta tab', async () => {
    const dataEntries = dataEntryFactory.buildList(2);

    const wrapper = mount(DataEntryDetail, {
      props: {
        dataEntries,
      },
    });

    await wrapper.find('#meta-tabs').findAll('.v-tab').at(0)?.trigger('click');

    await wrapper.vm.$nextTick();

    const metaTabComponent = wrapper
      .find('#meta-tabs-window')
      .findComponent(MetaTable);
    expect(metaTabComponent.exists()).toBe(true);

    const props = metaTabComponent.props();
    expect(props.metaColumns).toEqual(dataEntries[0].columns);
  });

  it('renders TablePreview component with correct props for Preview tab', async () => {
    const dataEntries = dataEntryFactory.buildList(2);

    const wrapper = mount(DataEntryDetail, {
      props: {
        dataEntries,
      },
    });

    await wrapper.find('#meta-tabs').findAll('.v-tab').at(1)?.trigger('click');

    await wrapper.vm.$nextTick();

    const previewTabComponent = wrapper
      .find('#meta-tabs-window')
      .findComponent(TablePreview);
    expect(previewTabComponent.exists()).toBe(true);

    const props = previewTabComponent.props();
    expect(props.slug).toEqual(dataEntries[0].slug);
  });

  it('getComponent returns the correct component based on the tab', () => {
    const wrapper = mount(DataEntryDetail, {
      props: {
        dataEntries: dataEntryFactory.buildList(2),
      },
    });

    expect(wrapper.vm.getComponent('meta')).toBe(MetaTable);
    expect(wrapper.vm.getComponent('preview')).toBe(TablePreview);
    expect(wrapper.vm.getComponent('unknown')).toBe(null);
  });

  it('getPropsForTab returns the correct props based on the tab', () => {
    const dataEntries = dataEntryFactory.buildList(2);

    const wrapper = mount(DataEntryDetail, {
      props: {
        dataEntries,
      },
    });

    wrapper.setData({ currentDataEntry: dataEntries[0] });

    expect(wrapper.vm.getPropsForTab('meta')).toEqual({
      metaColumns: dataEntries[0].columns,
    });
    expect(wrapper.vm.getPropsForTab('preview')).toEqual({
      slug: dataEntries[0].slug,
    });
  });
});
