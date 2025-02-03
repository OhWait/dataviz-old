import { IState as DatasetState, DatasetStore } from './dataset';
import { IState as DataEntryState, DataEntryStore } from './dataEntry';
import { IState as ThemeState, ThemeStore } from './theme';
import { IState as ChartState, ChartStore } from './chart';

export type RootState = {
  [DatasetStore.NAMESPACE]: DatasetState;
  [DataEntryStore.NAMESPACE]: DataEntryState;
  [ThemeStore.NAMESPACE]: ThemeState;
  [ChartStore.NAMESPACE]: ChartState;
};
