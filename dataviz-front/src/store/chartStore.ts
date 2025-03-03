import {
  ICartesianForm,
  IChartState,
  IDrawer,
  IFilter,
  IPolarForm,
  TChart,
  TChartForm,
  TChartResponse,
  TDrawerKey,
  View,
} from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';
import { postCartesian, postPolar } from '@/api/dataviz/chartRepository';
import {
  cartesianDataTransformer,
  polarDataTransformer,
} from '@/utils/chart/dataTransformer';
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
      } else {
        await this.postCartesian(slug, uuid, form);
      }
    },

    async postPolar(slug: string, uuid: string, form: IPolarForm) {
      try {
        const payload = polarDataTransformer(form);
        const response = await postPolar(slug, payload);
        this.setResponse(uuid, response);
      } catch (e) {
        throw e;
      }
    },

    async postCartesian(slug: string, uuid: string, form: ICartesianForm) {
      try {
        const payload = cartesianDataTransformer(form);
        const response = await postCartesian(slug, payload);
        this.setResponse(uuid, response);
      } catch (e) {
        throw e;
      }
    },

    setResponse(uuid: string, response: TChartResponse) {
      const chart = this.getChart(uuid);

      if (chart && chart.view) {
        chart.response = response;
        chart.response.view = chart.view;
      }

      return this;
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

      chart.view = view;

      if (View.PieChart === view || View.DonutChart === view) {
        this.transformToPolar(chart);
        return this;
      }

      this.transformToCartesian(chart);
      return this;
    },

    transformToPolar(chart: TChart) {
      chart.payload = {
        values: { column: null, operation: null, dataEntry: null },
        serie: { column: null, dataEntry: null },
        filters: chart.payload?.filters ?? [],
      };

      return this;
    },

    transformToCartesian(chart: TChart) {
      chart.payload = {
        distribution: { column: null, dataEntry: null, dateOperation: null },
        operation: { column: null, operation: null, dataEntry: null },
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
      (uuid: string): TChartResponse | null | undefined =>
        state.charts.find(c => c.uuid === uuid)?.response,
  },
});
