import { mount, shallowMount } from '@vue/test-utils';
import DatasetCard from '@/features/dataset/DatasetCard.vue';
import { DatasetRoutes } from '@/@types/dataset';
import { datasetFactory } from '@test/data/datasetFactory';

const mockDataset = datasetFactory.build();

describe('DatasetCard.vue', () => {
  it('should display dataset details when isLoading is false and item is provided', () => {
    const wrapper = mount(DatasetCard, {
      props: {
        isLoading: false,
        item: mockDataset,
      },
    });

    const card = wrapper.findComponent({ name: 'v-card' });
    expect(card.exists()).toBe(true);
    expect(card.text()).toContain(mockDataset.title);
    expect(card.text()).toContain(mockDataset.shortTitle);
    expect(card.text()).toContain(mockDataset.perimeter);
    expect(card.text()).toContain(mockDataset.granularity);
    expect(card.text()).toContain(mockDataset.updateFrequency);
    expect(card.text()).toContain(mockDataset.language);
    expect(card.text()).toContain(mockDataset.dataCreatedAt!.toDateString());
    expect(card.text()).toContain(mockDataset.dataUpdatedAt.toDateString());
  });

  it('should link to the dataset detail page if link is true', async () => {
    const wrapper = shallowMount(DatasetCard, {
      props: {
        isLoading: false,
        item: mockDataset,
        link: true,
      },
    });

    const card = wrapper.findComponent({ name: 'v-card' });
    expect(card.exists()).toBe(true);
    expect(card.props().to).toEqual({
      name: DatasetRoutes.Item,
      params: { slug: mockDataset.slug },
    });
  });

  it('should not have a link when link is false or undefined', async () => {
    const wrapper = shallowMount(DatasetCard, {
      props: {
        isLoading: false,
        item: mockDataset,
        link: false,
      },
    });

    const card = wrapper.findComponent({ name: 'v-card' });
    expect(card.exists()).toBe(true);
    expect(card.props().to).toBeUndefined();

    const wrapperDefaultLink = shallowMount(DatasetCard, {
      props: {
        isLoading: false,
        item: mockDataset,
      },
    });

    const cardDefaultLink = wrapperDefaultLink.findComponent({
      name: 'v-card',
    });
    expect(cardDefaultLink.exists()).toBe(true);
    expect(cardDefaultLink.props().to).toBeUndefined();
  });
});
