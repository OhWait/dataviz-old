import { IGetters, IState, DatasetGetterType } from '@/@types/dataset';
import { RootState } from '@/@types/store';
import { GetterTree } from 'vuex/types/index';

export const getters: GetterTree<IState, RootState> & IGetters = {
  [DatasetGetterType.GET_COLLECTION_MEMBERS]: (state: IState) =>
    state.collection?.['hydra:member'] || [],

  [DatasetGetterType.GET_COLLECTION_LOADING]: (state: IState) =>
    state.collectionLoading,

  [DatasetGetterType.GET_COLLECTION_ERROR]: (state: IState) =>
    state.collectionError,

  [DatasetGetterType.GET_COLLECTION_TOTAL_ITEMS]: (state: IState) =>
    state.collection?.['hydra:totalItems'] || 0,

  [DatasetGetterType.GET_ITEM]: (state: IState) => state.item,

  [DatasetGetterType.HAS_ITEM]: (state: IState) => state.item !== null,

  [DatasetGetterType.GET_ITEM_LOADING]: (state: IState) => state.itemLoading,

  [DatasetGetterType.GET_ITEM_ERROR]: (state: IState) => state.itemError,
};
