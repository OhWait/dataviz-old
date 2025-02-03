import { RootState } from '@/@types/store';
import { IActions, IState, ThemeMutationType } from '@/@types/theme/store';
import { ActionTree } from 'vuex';
import { ThemeActionType } from '@/@types/theme/store';
import { themeRepository } from '@/api/dataviz/themeRepository';

export const actions: ActionTree<IState, RootState> & IActions = {
  async [ThemeActionType.FETCH_COLLECTION]({ commit }) {
    commit(ThemeMutationType.SET_COLLECTION);
    try {
      const result = await themeRepository.getCollection();
      commit(ThemeMutationType.SET_COLLECTION_SUCCESS, result);
      return result;
    } catch (e) {
      commit(ThemeMutationType.SET_COLLECTION_ERROR, e as Error);
      throw e;
    }
  },
};
