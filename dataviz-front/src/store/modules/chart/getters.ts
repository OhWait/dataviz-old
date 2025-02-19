import { RootState } from '@/@types/store';
import {
  IGetters,
  IState,
  ChartGetterType,
  IPolarForm,
} from '@/@types/dataviz/chart/store';
import { GetterTree } from 'vuex';
import { View } from '@/@types/dataviz/chart/index.js';

export const getters: GetterTree<IState, RootState> & IGetters = {
  // Drawers
  [ChartGetterType.GET_CURRENT_THEME]: (state: IState) =>
    state.drawers.theme.currentTheme,

  [ChartGetterType.GET_DATASET_DRAWER]: (state: IState) =>
    state.drawers.dataset.drawer,

  [ChartGetterType.GET_DATASET_RAIL]: (state: IState) =>
    state.drawers.dataset.rail,

  [ChartGetterType.GET_DATASET_MODEL]: (state: IState) =>
    state.drawers.dataset.model,

  [ChartGetterType.GET_CURRENT_DATASET]: (state: IState) =>
    state.drawers.dataset.model?.slug ?? null,

  [ChartGetterType.HAS_MULTIPLE_ENTRIES]: (state: IState) =>
    (state.drawers.dataset.model?.dataEntries.length ?? 0) > 1,

  [ChartGetterType.GET_DEFAULT_ENTRY]: (state: IState) =>
    state.drawers.dataset.model?.dataEntries.at(0) ?? null,

  [ChartGetterType.GET_VISUALIZATION_DRAWER]: (state: IState) =>
    state.drawers.visualization.drawer,

  [ChartGetterType.GET_VISUALIZATION_RAIL]: (state: IState) =>
    state.drawers.visualization.rail,

  [ChartGetterType.GET_VISUALIZATION_VIEW]: (state: IState) =>
    state.drawers.visualization.view,

  [ChartGetterType.GET_FILTERS_DRAWER]: (state: IState) =>
    state.drawers.filters.drawer,

  [ChartGetterType.GET_FILTERS_RAIL]: (state: IState) =>
    state.drawers.filters.rail,

  // Payload
  [ChartGetterType.GET_UUID]: (state: IState) => state.uuid,

  [ChartGetterType.GET_CURRENT_FILTERS]: (state: IState) =>
    state.charts.find(c => c.uuid === state.uuid)?.payload?.filters ?? [],

  [ChartGetterType.GET_CURRENT_PIE_FORM]: (state: IState) => {
    const chart = state.charts.find(
      c => c.uuid === state.uuid && c.view === View.Pie
    );

    if (chart) {
      return chart.payload as IPolarForm;
    }

    return null;
  },

  [ChartGetterType.GET_CHART]: (state: IState) => (uuid: string) =>
    state.charts.find(c => c.uuid === uuid && c.response) ?? null,
};
