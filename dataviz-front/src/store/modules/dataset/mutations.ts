import {
  IMutations,
  IState,
  DatasetMutationType,
  IDataset,
  IDatasetCollection,
} from '@/@types/dataset';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { MutationTree } from 'vuex/types/index.js';

export const mutations: MutationTree<IState> & IMutations = {
  [DatasetMutationType.SET_COLLECTION](state) {
    state.collectionLoading = true;
    state.collectionError = null;
    state.collection = null;
  },

  [DatasetMutationType.SET_COLLECTION_SUCCESS](
    state,
    data: HydraCollection<IDatasetCollection>
  ) {
    state.collection = data;
    state.collectionLoading = false;
    state.collectionError = null;
  },

  [DatasetMutationType.SET_COLLECTION_ERROR](state, error: Error) {
    state.collectionLoading = false;
    state.collectionError = error;
    state.collection = null;
  },

  [DatasetMutationType.SET_ITEM](state) {
    state.itemLoading = true;
    state.itemError = null;
    state.item = null;
  },

  [DatasetMutationType.SET_ITEM_SUCCESS](state, item: IDataset) {
    state.item = item;
    state.itemLoading = false;
    state.itemError = null;
  },

  [DatasetMutationType.SET_ITEM_ERROR](state, error: Error) {
    state.itemLoading = false;
    state.itemError = error;
    state.item = null;
  },
};
