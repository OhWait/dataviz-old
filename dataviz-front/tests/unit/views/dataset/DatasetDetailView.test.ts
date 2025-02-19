import { mount } from '@vue/test-utils';
import { createTestingPinia } from '@pinia/testing';
import { useDatasetStore } from '@/store/datasetStore';
import DatasetDetailView from '@/views/dataset/DatasetDetailView.vue';
import HeaderDetail from '@/features/dataset/detail/HeaderDetail.vue';
import DescriptionDetail from '@/features/dataset/detail/DescriptionDetail.vue';
import DataEntryDetail from '@/features/dataset/detail/DataEntryDetail.vue';
import SkeletonCard from '@/components/SkeletonCard.vue';
import { datasetFactory } from '@test/data/dataviz/datasetFactory';

let routeParams = { slug: 'test-dataset' };

vi.mock('vue-router', () => ({
  useRoute: vi.fn(() => ({
    params: routeParams,
  })),
}));

describe('DatasetDetailView.vue', () => {
  let store: any;
  let pinia: any;

  beforeEach(() => {
    pinia = createTestingPinia();
    store = useDatasetStore(pinia);
  });

  it('should display SkeletonCard when loading', async () => {
    store.itemLoading = true;

    const wrapper = mount(DatasetDetailView, {
      global: {
        plugins: [pinia],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(true);
    expect(wrapper.findComponent(HeaderDetail).exists()).toBe(false);
  });

  it('should display item details when not loading and item is provided', async () => {
    const mockItem = datasetFactory.build();
    store.item = mockItem;
    store.itemLoading = false;

    const wrapper = mount(DatasetDetailView, {
      global: {
        plugins: [pinia],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(false);
    expect(wrapper.findComponent(HeaderDetail).exists()).toBe(true);
    expect(wrapper.findComponent(DescriptionDetail).exists()).toBe(true);
    expect(wrapper.findComponent(DataEntryDetail).exists()).toBe(true);
  });

  it('should display error message when item is not found', async () => {
    store.item = null;
    store.itemLoading = false;

    const wrapper = mount(DatasetDetailView, {
      global: {
        plugins: [pinia],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(false);
    expect(wrapper.findComponent(HeaderDetail).exists()).toBe(false);
    expect(wrapper.text()).toContain('An error occurred');
  });

  it('should handle dynamic route parameters', () => {
    const dispatchSpy = vi.spyOn(store, 'fetchItem');

    mount(DatasetDetailView, {
      global: {
        plugins: [pinia],
      },
    });

    expect(dispatchSpy).toHaveBeenCalledWith(routeParams.slug);
  });
});
