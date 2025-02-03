import {
  DataEntryMutationType,
  DataEntryActionType,
  IActions,
  IState,
} from '@/@types/dataEntry';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse';
import { RootState } from '@/@types/store';
import { dataEntryRepository } from '@/api/dataviz/dataEntryRepository';
import { ActionTree } from 'vuex';

export const actions: ActionTree<IState, RootState> & IActions = {
  async [DataEntryActionType.FETCH_TABLE](
    { commit },
    payload: { slug: string; page: number; itemsPerPage: number }
  ): Promise<HydraAnonymousCollection> {
    commit(DataEntryMutationType.SET_TABLE);
    try {
      const result = await dataEntryRepository.getTable(
        payload.slug,
        payload.page,
        payload.itemsPerPage
      );
      commit(DataEntryMutationType.SET_TABLE_SUCCESS, result);
      return result;
    } catch (e) {
      commit(DataEntryMutationType.SET_TABLE_ERROR, e as Error);
      throw e;
    }
  },
};
