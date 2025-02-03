import { IMutations, IState, ChartMutationType } from '@/@types/chart/store';
import { MutationTree } from 'vuex';
import { v4 as uuidv4 } from 'uuid';
import { View } from '@/@types/chart/index.js';

export const mutations: MutationTree<IState> & IMutations = {
  [ChartMutationType.RESET](state) {
    state.drawers.theme.currentTheme = null;
    state.drawers.dataset.drawer = false;
    state.drawers.visualization.drawer = false;
  },

  // DRAWERS
  // Theme
  [ChartMutationType.SET_THEME](state, theme) {
    state.drawers.dataset.drawer = true;
    state.drawers.dataset.rail = false;
    state.drawers.theme.currentTheme = theme;
  },

  // Dataset
  [ChartMutationType.SHOW_DATASET_DRAWER](state) {
    state.drawers.dataset.drawer = true;
    state.drawers.dataset.rail = false;
  },

  [ChartMutationType.HIDE_DATASET_DRAWER](state) {
    state.drawers.dataset.rail = true;
  },

  [ChartMutationType.SET_CURRENT_DATASET](state, dataset) {
    state.drawers.dataset.model = dataset;
    state.drawers.visualization.drawer = true;
    state.drawers.visualization.view = null;
    state.drawers.filters.drawer = true;
  },

  // Visualization
  [ChartMutationType.SHOW_VISUALIZATION_DRAWER](state) {
    state.drawers.visualization.drawer = true;
    state.drawers.visualization.rail = false;
  },

  [ChartMutationType.HIDE_VISUALIZATION_DRAWER](state) {
    state.drawers.visualization.rail = true;
  },

  [ChartMutationType.SET_VIEW](state, view) {
    state.drawers.visualization.view = view;
  },

  // Filters
  [ChartMutationType.SHOW_FILTERS_DRAWER](state) {
    state.drawers.filters.drawer = true;
    state.drawers.filters.rail = false;
  },

  [ChartMutationType.HIDE_FILTERS_DRAWER](state) {
    state.drawers.filters.rail = true;
  },

  // CHART
  [ChartMutationType.INIT_SINGLE_CHART](state) {
    state.uuid = uuidv4();
  },

  [ChartMutationType.RESET_CHART](state) {
    const chartIndex = state.charts.findIndex(c => c.uuid === state.uuid);

    if (chartIndex !== -1) {
      state.charts.splice(chartIndex, 1);
    }

    state.drawers.visualization.drawer = false;
    state.drawers.filters.drawer = false;
  },

  [ChartMutationType.INIT_POLAR](state) {
    const dataEntry = state.drawers.dataset.model?.dataEntries.at(0)?.slug;
    const uuid = state.uuid;

    if (!dataEntry || !uuid) {
      throw new Error('Data entry or UUID is missing');
    }

    const chartIndex = state.charts.findIndex(c => c.uuid === uuid);

    if (chartIndex !== -1) {
      state.charts.splice(chartIndex, 1);
    }

    state.charts.push({
      uuid,
      view: View.Pie,
      active: true,
      isLoading: false,
      payload: {
        values: {
          column: null,
          operation: null,
          dataEntry,
        },
        serie: {
          column: null,
          dataEntry,
        },
        filters: [],
      },
    });
  },

  [ChartMutationType.POST_POLAR](state, uuid) {
    const chart = state.charts.find(c => c.uuid === uuid);

    if (!chart) {
      throw new Error(
        `Mutation ${ChartMutationType.POST_POLAR} failed, uuid: ${uuid} not found.`
      );
    }

    chart.isLoading = true;
    chart.error = null;
    chart.response = null;
  },

  [ChartMutationType.POST_POLAR_SUCCESS](state, payload) {
    const chart = state.charts.find(c => c.uuid === payload.uuid);

    if (!chart) {
      throw new Error(
        `Mutation ${ChartMutationType.POST_POLAR_SUCCESS} failed, uuid: ${payload.uuid} not found.`
      );
    }

    chart.isLoading = false;
    chart.error = null;
    chart.response = payload.response;
  },

  [ChartMutationType.POST_POLAR_ERROR](state, payload) {
    const chart = state.charts.find(c => c.uuid === payload.uuid);

    if (!chart) {
      throw new Error(
        `Mutation ${ChartMutationType.POST_POLAR_SUCCESS} failed, uuid: ${payload.uuid} not found.`
      );
    }

    chart.isLoading = false;
    chart.error = payload.error;
    chart.response = null;
  },
};
