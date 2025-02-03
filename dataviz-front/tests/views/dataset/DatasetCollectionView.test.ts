import { mount } from '@vue/test-utils';
import DatasetCollectionView from '@/views/dataset/DatasetCollectionView.vue';
import DatasetCard from '@/features/dataset/DatasetCard.vue';
import SkeletonCard from '@/components/SkeletonCard.vue';
import { DatasetStore } from '@/@types/dataset';
import { createMockStore } from '@test/__mocks__/mockStore';
import { datasetCollectionFactory } from '@test/data/datasetFactory';
import { key } from '@/store';
import { Store } from 'vuex';
import { RootState } from '@/@types/store.js';

describe('DatasetCollectionView.vue', () => {
  let store: Store<RootState>;

  beforeEach(() => {
    store = createMockStore();
  });

  it('should display SkeletonCard when loading', async () => {
    store.commit(DatasetStore.SET_COLLECTION);

    const wrapper = mount(DatasetCollectionView, {
      global: {
        plugins: [[store, key]],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(true);
    expect(wrapper.findComponent(DatasetCard).exists()).toBe(false);
  });

  it('should display DatasetCard when not loading and items are provided', async () => {
    const mockCollection = datasetCollectionFactory.build();

    store.commit(DatasetStore.SET_COLLECTION_SUCCESS, mockCollection);

    const wrapper = mount(DatasetCollectionView, {
      global: {
        plugins: [[store, key]],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(SkeletonCard).exists()).toBe(false);
    expect(wrapper.findAllComponents(DatasetCard).length).toBe(
      mockCollection['hydra:member'].length
    );
  });

  it('should dispatch FETCH_COLLECTION action on mount', () => {
    const dispatchSpy = vi.spyOn(store, 'dispatch');

    mount(DatasetCollectionView, {
      global: {
        plugins: [store],
        provide: {
          [key as symbol]: store,
        },
      },
    });

    expect(dispatchSpy).toHaveBeenCalledWith(DatasetStore.FETCH_COLLECTION);
  });
});
