import { mount, shallowMount } from '@vue/test-utils';
import DatasetDetailView from '@/views/dataset/DatasetDetailView.vue';
import HeaderDetail from '@/features/dataset/detail/HeaderDetail.vue';
import DescriptionDetail from '@/features/dataset/detail/DescriptionDetail.vue';
import DataEntryDetail from '@/features/dataset/detail/DataEntryDetail.vue';
import { DatasetStore } from '@/@types/dataset';
import { createMockStore } from '@test/__mocks__/mockStore';
import { key } from '@/store';
import SkeletonCard from '@/components/SkeletonCard.vue';

let routeParams = { slug: 'test-dataset' };

vi.mock('vue-router', () => ({
  useRoute: vi.fn(() => ({
    params: routeParams,
  })),
}));

const setRouteParams = (params: { slug: string }) => {
  routeParams = params;
};

const datasetFactory = {
  build: () => ({
    id: 1,
    title: 'Test Dataset',
    slug: 'test-dataset',
    description: 'Test Description',
    dataEntries: [{ id: 1, name: 'Entry 1' }],
  }),
};

describe('DatasetDetailView.vue', () => {
  const store = createMockStore();

  it('should display loading state when fetching item', async () => {
    store.commit(DatasetStore.SET_ITEM);

    const wrapper = mount(DatasetDetailView, {
      global: {
        plugins: [[store, key]],
      },
    });

    await wrapper.vm.$nextTick();

    const Skeleton = wrapper.findComponent(SkeletonCard);

    expect(Skeleton.exists()).toBeTruthy();
  });

  it('should display dataset details when item is loaded', async () => {
    const mockItem = datasetFactory.build();
    store.commit(DatasetStore.SET_ITEM_SUCCESS, mockItem);

    const wrapper = shallowMount(DatasetDetailView, {
      global: {
        plugins: [[store, key]],
      },
    });

    await wrapper.vm.$nextTick();

    expect(wrapper.findComponent(HeaderDetail).props('item')).toEqual(mockItem);
    expect(wrapper.findComponent(DescriptionDetail).props('item')).toEqual(
      mockItem
    );
    expect(wrapper.findComponent(DataEntryDetail).props('dataEntries')).toEqual(
      mockItem.dataEntries
    );
  });

  it('should dispatch FETCH_ITEM action on mount', async () => {
    const dispatchSpy = vi.spyOn(store, 'dispatch');

    shallowMount(DatasetDetailView, {
      global: {
        plugins: [[store, key]],
      },
    });

    expect(dispatchSpy).toHaveBeenCalledWith(
      DatasetStore.FETCH_ITEM,
      'test-dataset'
    );
  });

  it('should handle dynamic route parameters', async () => {
    setRouteParams({ slug: 'new-dataset2' });
    const dispatchSpy = vi.spyOn(store, 'dispatch');

    shallowMount(DatasetDetailView, {
      global: {
        plugins: [[store, key]],
      },
    });

    expect(dispatchSpy).toHaveBeenCalledWith(
      DatasetStore.FETCH_ITEM,
      'new-dataset2'
    );
  });
});
