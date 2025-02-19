import {
  IChartState,
  IDrawer,
  IFilter,
  IPolarForm,
  TChart,
  TChartForm,
  TDrawerKey,
  TResponse,
  View,
} from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';
import { postPolar } from '@/api/dataviz/chartRepository';
import { polarDataTransformer } from '@/utils/chart/dataTransformer';
import { defineStore } from 'pinia';

export const useChartStore = defineStore('chart', {
  state: (): IChartState => ({
    drawers: {
      theme: {
        currentTheme: null,
      },
      dataset: {
        drawer: false,
        rail: false,
        currentDataset: null,
      },
      visualization: {
        drawer: false,
        rail: false,
        view: null,
      },
      filter: {
        drawer: false,
        rail: false,
      },
    },
    charts: [],
  }),

  actions: {
    async postForm(slug: string, uuid: string, form: TChartForm) {
      if ('values' in form) {
        await this.postPolar(slug, uuid, form);
      }
    },

    async postPolar(slug: string, uuid: string, polar: IPolarForm) {
      const response = await postPolar(slug, polarDataTransformer(polar));
      const chart = this.getChart(uuid);

      if (chart) {
        chart.response = response;
      }
    },

    setActiveTheme(theme: string) {
      this.drawers.theme.currentTheme = theme;
      this.drawers.dataset.drawer = true;
      this.drawers.dataset.rail = false;

      return this;
    },

    toggleDrawer(key: TDrawerKey, open: boolean) {
      this.drawers[key].drawer = true;
      this.drawers[key].rail = open ? false : true;

      return this;
    },

    setDrawerDataset(dataset: IDataset) {
      this.drawers.dataset.currentDataset = dataset.slug;
      this.drawers.visualization.drawer = true;
      this.drawers.visualization.view = null;

      return this;
    },

    setDrawerView(view: View) {
      this.drawers.visualization.view = view;
      this.drawers.filter.drawer = true;
      this.drawers.filter.rail = false;

      return this;
    },

    initChart(uuid: string, dataset: IDataset) {
      const chartIndex = this.charts.findIndex(c => c.uuid === uuid);

      if (chartIndex !== -1) {
        this.charts.splice(chartIndex, 1);
      }

      this.charts.push({
        uuid,
        dataset,
        active: true,
        isLoading: false,
      });

      return this;
    },

    updateChart(uuid: string, view: View) {
      const chart = this.getChart(uuid);

      if (!chart) {
        throw new Error('Chart not found !');
      }

      switch (view) {
        case View.Pie:
          this.transformToPolar(chart);
          break;
        default:
          console.warn(`No handler for view type: ${view}`);
      }

      return this;
    },

    transformToPolar(chart: TChart) {
      chart.view = View.Pie;
      chart.payload = {
        values: { column: null, operation: null, dataEntry: null },
        serie: { column: null, dataEntry: null },
        filters: chart.payload?.filters ?? [],
      };

      return this;
    },

    updateFilters(uuid: string, filters: IFilter[]) {
      const payload = this.getChart(uuid)?.payload;

      if (payload) payload.filters = filters;

      return this;
    },
  },

  getters: {
    getDrawers: (state): IDrawer => state.drawers,
    getDataset:
      state =>
      (uuid: string): IDataset | null =>
        state.charts.find(c => c.uuid === uuid)?.dataset ?? null,
    getChart:
      state =>
      (uuid: string): TChart | null =>
        state.charts.find(c => c.uuid === uuid) ?? null,
    getResponse:
      state =>
      (uuid: string): TResponse | null | undefined =>
        state.charts.find(c => c.uuid === uuid)?.response,
  },
});
