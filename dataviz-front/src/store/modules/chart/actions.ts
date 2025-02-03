import { RootState } from '@/@types/store';
import {
  ChartActionType,
  ChartMutationType,
  IActions,
  IPolarForm,
  IState,
} from '@/@types/chart/store';
import { ActionTree } from 'vuex';
import { chartRepository } from '@/api/dataviz/chartRepository';
import { IPolarPayload } from '@/@types/chart/index.js';
import {
  IAxisOperationPayload,
  IFilterPayload,
  ISeriePayload,
} from '@/@types/chart/model/payload.js';

export const actions: ActionTree<IState, RootState> & IActions = {
  async [ChartActionType.POST_POLAR]({ commit }, { uuid, slug, polar }) {
    commit(ChartMutationType.POST_POLAR, uuid);
    try {
      const response = await chartRepository.postPolar(
        slug,
        polarDataTransformer(polar)
      );
      commit(ChartMutationType.POST_POLAR_SUCCESS, { uuid, response });
      return response;
    } catch (e) {
      commit(ChartMutationType.POST_POLAR_ERROR, { uuid, error: e as Error });
      throw e;
    }
  },
};

const polarDataTransformer = (polar: IPolarForm): IPolarPayload => {
  const values: IAxisOperationPayload = {
    column: polar.values.column!,
    operation: polar.values.operation!,
    dataEntry: polar.values.dataEntry,
  };

  const serie: ISeriePayload = {
    column: polar.serie.column!,
    dataEntry: polar.serie.dataEntry,
  };

  const filters: IFilterPayload[] = polar.filters.map(filter => ({
    column: filter.column!,
    dataEntry: filter.dataEntry,
    values: filter.values,
  }));

  return {
    values,
    serie,
    filters,
  };
};
