import { RootState } from '@/@types/store';
import { IGetters, IState, ThemeGetterType } from '@/@types/theme/store';
import { GetterTree } from 'vuex';

export const getters: GetterTree<IState, RootState> & IGetters = {
  [ThemeGetterType.GET_COLLECTION_MEMBERS]: (state: IState) =>
    state.collection?.['hydra:member'] || [],

  [ThemeGetterType.GET_COLLECTION_LOADING]: (state: IState) =>
    state.collectionLoading,

  [ThemeGetterType.GET_COLLECTION_ERROR]: (state: IState) =>
    state.collectionError,

  [ThemeGetterType.GET_COLLECTION_TOTAL_ITEMS]: (state: IState) =>
    state.collection?.['hydra:totalItems'] || 0,
};
