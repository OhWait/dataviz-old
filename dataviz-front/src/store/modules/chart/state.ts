import { IState } from '@/@types/dataviz/chart/store';

export const state: IState = {
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
};
