import { defineStore } from 'pinia';
import { v4 as uuidv4 } from 'uuid';
import { polarDataTransformer } from '@/utils/chart/dataTransformer';
import { ChartState, IPolarForm, View } from '@/@types/dataviz/chart';
import { postPolar } from '@/api/dataviz/chartRepository';

export const useChartStore = defineStore('chart', {
  state: (): ChartState => ({
    drawers: {
      theme: {
        currentTheme: null,
      },
      dataset: {
        drawer: false,
        rail: false,
        model: null,
      },
      visualization: {
        drawer: false,
        rail: false,
        view: null,
      },
      filters: {
        drawer: false,
        rail: false,
      },
    },
    uuid: null,
    charts: [],
  }),

  actions: {
    async postPolar(uuid: string, slug: string, polar: IPolarForm) {
      const chart = this.charts.find(c => c.uuid === uuid);
      if (!chart) {
        throw new Error(`Action postPolar failed, uuid: ${uuid} not found.`);
      }

      chart.isLoading = true;
      chart.error = null;
      chart.response = null;

      try {
        const response = await postPolar(slug, polarDataTransformer(polar));
        chart.isLoading = false;
        chart.response = response;
        return response;
      } catch (e) {
        chart.isLoading = false;
        chart.error = e as Error;
        throw e;
      }
    },

    setTheme(theme: string) {
      this.drawers.theme.currentTheme = theme;
      this.drawers.dataset.drawer = true;
      this.drawers.dataset.rail = false;
    },

    showDatasetDrawer() {
      this.drawers.dataset.drawer = true;
      this.drawers.dataset.rail = false;
    },

    hideDatasetDrawer() {
      this.drawers.dataset.rail = true;
    },

    setCurrentDataset(dataset: any) {
      this.drawers.dataset.model = dataset;
      this.drawers.visualization.drawer = true;
      this.drawers.visualization.view = null;
      this.drawers.filters.drawer = true;
    },

    showVisualizationDrawer() {
      this.drawers.visualization.drawer = true;
      this.drawers.visualization.rail = false;
    },

    hideVisualizationDrawer() {
      this.drawers.visualization.rail = true;
    },

    setView(view: View) {
      this.drawers.visualization.view = view;
    },

    showFiltersDrawer() {
      this.drawers.filters.drawer = true;
      this.drawers.filters.rail = false;
    },

    hideFiltersDrawer() {
      this.drawers.filters.rail = true;
    },

    initSingleChart() {
      this.uuid = uuidv4();
    },

    resetChart() {
      const chartIndex = this.charts.findIndex(c => c.uuid === this.uuid);
      if (chartIndex !== -1) {
        this.charts.splice(chartIndex, 1);
      }
      this.drawers.visualization.drawer = false;
      this.drawers.filters.drawer = false;
    },

    initPolar() {
      const dataEntry = this.drawers.dataset.model?.dataEntries.at(0)?.slug;
      const uuid = this.uuid;

      if (!dataEntry || !uuid) {
        throw new Error('Data entry or UUID is missing');
      }

      const chartIndex = this.charts.findIndex(c => c.uuid === uuid);
      if (chartIndex !== -1) {
        this.charts.splice(chartIndex, 1);
      }

      this.charts.push({
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
  },

  getters: {
    getCurrentTheme: (state) => state.drawers.theme.currentTheme,
    getDatasetDrawer: (state) => state.drawers.dataset.drawer,
    getDatasetRail: (state) => state.drawers.dataset.rail,
    getDatasetModel: (state) => state.drawers.dataset.model,
    getCurrentDataset: (state) => state.drawers.dataset.model?.slug ?? null,
    hasMultipleEntries: (state) => (state.drawers.dataset.model?.dataEntries.length ?? 0) > 1,
    getDefaultEntry: (state) => state.drawers.dataset.model?.dataEntries.at(0) ?? null,
    getVisualizationDrawer: (state) => state.drawers.visualization.drawer,
    getVisualizationRail: (state) => state.drawers.visualization.rail,
    getVisualizationView: (state) => state.drawers.visualization.view,
    getFiltersDrawer: (state) => state.drawers.filters.drawer,
    getFiltersRail: (state) => state.drawers.filters.rail,
    getUuid: (state) => state.uuid,
    getCurrentFilters: (state) => state.charts.find(c => c.uuid === state.uuid)?.payload?.filters ?? [],
    getCurrentPolarForm: (state) => state.charts.find(c => c.uuid === state.uuid && c.view === View.Pie)?.payload ?? null,
    getChart: (state) => (uuid: string) => state.charts.find(c => c.uuid === uuid && c.response) ?? null,
  },
});
