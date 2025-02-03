import { createStore } from 'vuex';
import { DatasetActionType, DatasetStore } from '@/@types/dataset';
import store from '@/store/modules/dataset';
import { RootState } from '@/@types/store.js';

// Mocks des actions du module Dataset
const mockDatasetActions = {
  [DatasetActionType.FETCH_COLLECTION]: vi.fn(),
  [DatasetActionType.FETCH_ITEM]: vi.fn(),
};

// Créez le mock store
export function createMockStore() {
  return createStore<RootState>({
    modules: {
      [DatasetStore.NAMESPACE]: {
        ...store,
        actions: mockDatasetActions,
      },
    },
  });
}
