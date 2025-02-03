import { MutationTree } from 'vuex';
import { IState, IMutations, DataEntryMutationType } from '@/@types/dataEntry';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse';

export const mutations: MutationTree<IState> & IMutations = {
  [DataEntryMutationType.SET_TABLE](state) {
    state.collection = null;
    state.collectionLoading = true;
    state.collectionError = null;
  },

  [DataEntryMutationType.SET_TABLE_SUCCESS](
    state,
    data: HydraAnonymousCollection
  ) {
    state.collection = data;
    state.collectionLoading = false;
    state.collectionError = null;
  },

  [DataEntryMutationType.SET_TABLE_ERROR](state, error: Error) {
    state.collection = null;
    state.collectionLoading = false;
    state.collectionError = error;
  },
};
