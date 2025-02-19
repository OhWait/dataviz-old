import { IState as DataEntryState, DataEntryStore } from './dataviz/dataEntry';
import { IState as ThemeState, ThemeStore } from './dataviz/theme';
import { IState as ChartState, ChartStore } from './dataviz/chart';

export type RootState = {
  [DataEntryStore.NAMESPACE]: DataEntryState;
  [ThemeStore.NAMESPACE]: ThemeState;
  [ChartStore.NAMESPACE]: ChartState;
};
