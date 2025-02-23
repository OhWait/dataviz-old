import {
  DateOperation,
  ICartesianResponse,
  IPolarResponse,
  Operation,
  View,
} from '@/@types/dataviz/chart';
import { IDataEntry } from '@/@types/dataviz/dataEntry';
import { IDataset } from '@/@types/dataviz/dataset';
import { defineStore } from 'pinia';

interface IChart<TPayload, TResponse> {
  uuid: string;
  active: boolean;
  isLoading: boolean;
  payload?: TPayload;
  response?: TResponse | null;
  error?: Error | null;
  view?: View | null;
  dataset: IDataset;
}

export interface IPolarForm {
  values: {
    column: string | null;
    operation: Operation | null;
    dataEntry: string | null;
  };

  serie: {
    column: string | null;
    dataEntry: string | null;
  };

  filters: IFilter[];
}

export interface ICartesianForm {
  distribution: {
    column: string | null;
    dateOperation: DateOperation | null;
    dataEntry: string | null;
  };

  operation: {
    column: string | null;
    operation: Operation | null;
    dataEntry: string | null;
  };

  serie: {
    column: string | null;
    dataEntry: string;
  };

  filters: IFilter[];
}

export interface IFilter {
  entry: IDataEntry;
  dataEntry: string;
  column: string | null;
  values: string[];
  valueOptions: {
    text: string;
    value: string;
  }[];
}

export interface IPolar extends IChart<IPolarForm, IPolarResponse> {}

export interface ICartesian
  extends IChart<ICartesianForm, ICartesianResponse> {}

export type Chart = IPolar | ICartesian;

interface IDrawer {
  theme: {
    currentTheme: string | null;
  };
  dataset: {
    drawer: boolean;
    rail: boolean;
    currentDataset: string | null;
  };
  visualization: {
    drawer: boolean;
    rail: boolean;
    view: View | null;
  };
  filter: {
    drawer: boolean;
    rail: boolean;
  };
}

interface GraphState {
  drawers: IDrawer;
  charts: Chart[];
}

export const useGraphStore = defineStore('graph', {
  state: (): GraphState => ({
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
    setActiveTheme(theme: string) {
      this.drawers.theme.currentTheme = theme;
      this.drawers.dataset.drawer = true;
      this.drawers.dataset.rail = false;

      return this;
    },

    toggleDrawer(type: 'dataset' | 'visualization' | 'filter', open: boolean) {
      this.drawers[type].drawer = true;
      this.drawers[type].rail = open ? false : true;

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

    transformToPolar(chart: Chart) {
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
      (uuid: string): Chart | null =>
        state.charts.find(c => c.uuid === uuid) ?? null,
  },
});
