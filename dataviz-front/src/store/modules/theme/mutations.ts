import { IMutations, IState, ITheme, ThemeMutationType } from '@/@types/theme';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { MutationTree } from 'vuex';

export const mutations: MutationTree<IState> & IMutations = {
  [ThemeMutationType.SET_COLLECTION](state) {
    state.collectionLoading = true;
    state.collectionError = null;
    state.collection = null;
  },

  [ThemeMutationType.SET_COLLECTION_SUCCESS](
    state,
    data: HydraCollection<ITheme>
  ) {
    state.collection = data;
    state.collectionLoading = false;
    state.collectionError = null;
  },

  [ThemeMutationType.SET_COLLECTION_ERROR](state, error: Error) {
    state.collectionLoading = false;
    state.collectionError = error;
    state.collection = null;
  },
};
