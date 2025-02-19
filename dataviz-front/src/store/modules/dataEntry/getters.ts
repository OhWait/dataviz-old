import { IGetters, IState, DataEntryGetterType } from '@/@types/dataEntry';
import { AnonymousMember } from '@/@types/hydra/collectionResponse.js';
import { HYDRA_KEYS } from '@/api/hydraKeys';
import { RootState } from '@/@types/store.js';
import { GetterTree } from 'vuex';

export const getters: GetterTree<IState, RootState> & IGetters = {
  [DataEntryGetterType.GET_TABLE_MEMBERS](state: IState): AnonymousMember[] {
    return state.collection ? state.collection[HYDRA_KEYS.MEMBER] : [];
  },

  [DataEntryGetterType.GET_TABLE_TOTAL_ITEMS](state: IState): number {
    return state.collection ? state.collection[HYDRA_KEYS.TOTAL_ITEMS] : 0;
  },

  [DataEntryGetterType.GET_TABLE_LOADING](state: IState): boolean {
    return state.collectionLoading;
  },

  [DataEntryGetterType.GET_TABLE_ERROR](state: IState): Error | null {
    return state.collectionError;
  },
};
