import {
  IActions,
  IState,
  DatasetActionType,
  DatasetMutationType,
} from '@/@types/dataset';
import { ActionTree } from 'vuex';
import { RootState } from '@/@types/store.js';
import { datasetRepository } from '@/api/dataviz/datasetRepository.js';

export const actions: ActionTree<IState, RootState> & IActions = {
  async [DatasetActionType.FETCH_COLLECTION]({ commit }, payload) {
    commit(DatasetMutationType.SET_COLLECTION);
    try {
      const result = await datasetRepository.getCollection(
        payload?.themes,
        payload?.dataProvider
      );
      commit(DatasetMutationType.SET_COLLECTION_SUCCESS, result);
      return result;
    } catch (e) {
      commit(DatasetMutationType.SET_COLLECTION_ERROR, e as Error);
      throw e;
    }
  },

  async [DatasetActionType.FETCH_ITEM]({ commit }, slug: string) {
    commit(DatasetMutationType.SET_ITEM);
    try {
      const result = await datasetRepository.getItem(slug);
      commit(DatasetMutationType.SET_ITEM_SUCCESS, result);
      return result;
    } catch (e) {
      commit(DatasetMutationType.SET_ITEM_ERROR, e as Error);
      throw e;
    }
  },
};
