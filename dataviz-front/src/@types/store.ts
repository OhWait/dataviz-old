import { IState as ThemeState, ThemeStore } from './dataviz/theme';
import { IState as ChartState, ChartStore } from './dataviz/chart';

export type RootState = {
  [ThemeStore.NAMESPACE]: ThemeState;
  [ChartStore.NAMESPACE]: ChartState;
};
