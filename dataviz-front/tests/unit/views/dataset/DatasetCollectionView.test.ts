import { mount } from '@vue/test-utils';
import { createTestingPinia } from '@pinia/testing';
import { useDatasetStore } from '@/store/datasetStore';
import DatasetCollectionView from '@/views/dataset/DatasetCollectionView.vue';
import DatasetCard from '@/features/dataset/DatasetCard.vue';
import SkeletonCard from '@/components/SkeletonCard.vue';
import { datasetCollectionFactory } from '@test/data/datasetFactory';
import { HYDRA_KEYS } from '@/@types/hydra/hydraKeys';

describe('DatasetCollectionView.vue', () => {
  let store: any;
  let pinia: any;

  beforeEach(() => {
    pinia = createTestingPinia();
    store = useDatasetStore(pinia);
  });

  it('should display SkeletonCard when loading', async () => {
    store.collectionLoading = true;

    const wrapper = mount(DatasetCollectionView, {
      global: {
        plugins: [pinia],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(true);
    expect(wrapper.findComponent(DatasetCard).exists()).toBe(false);
  });

  it('should display DatasetCard when not loading and items are provided', async () => {
    const mockCollection = datasetCollectionFactory.build();
    store.collection = mockCollection;
    store.collectionLoading = false;

    const wrapper = mount(DatasetCollectionView, {
      global: {
        plugins: [pinia],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(false);
    expect(wrapper.findAllComponents(DatasetCard).length).toBe(
      mockCollection[HYDRA_KEYS.MEMBER].length
    );
  });

  it('should fetch collection on mount', () => {
    const dispatchSpy = vi.spyOn(store, 'fetchCollection');

    mount(DatasetCollectionView, {
      global: {
        plugins: [pinia],
      },
    });

    expect(dispatchSpy).toHaveBeenCalled();
  });
});
