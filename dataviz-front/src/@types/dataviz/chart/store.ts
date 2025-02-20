import { ActionContext } from 'vuex';
import type { RootState } from '@/@types/store';
import type { IDataset } from '@/@types/dataviz/dataset/model';
import { View } from '@/@types/dataviz/chart/enum/ViewEnum';
import { IDataEntry } from '@/@types/dataviz/dataEntry/model.js';
import {
  ICartesianResponse,
  IPolarResponse,
} from '@/@types/dataviz/chart/model/response.js';
import { Operation } from '@/@types/dataviz/chart/enum/OperationEnum';
import { DateOperation } from '@/@types/dataviz/chart/enum/DateOperationEnum';

interface IChart<TPayload, TResponse> {
  uuid?: string;
  active: boolean;
  isLoading: boolean;
  payload?: TPayload;
  response?: TResponse | null;
  error?: Error | null;
  view?: View | null;
}

export interface IPolarForm {
  values: {
    column: string | null;
    operation: Operation | null;
    dataEntry: string;
  };

  serie: {
    column: string | null;
    dataEntry: string;
  };

  filters: IFilter[];
}

export interface ICartesianForm {
  distribution: {
    column: string | null;
    dateOperation: DateOperation | null;
    dataEntry: string;
  };

  operation: {
    column: string | null;
    operation: Operation | null;
    dataEntry: string;
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

export interface IState {
  drawers: {
    theme: {
      currentTheme: string | null;
    };
    dataset: {
      drawer: boolean;
      rail: boolean;
      model: IDataset | null;
    };
    visualization: {
      drawer: boolean;
      rail: boolean;
      view: View | null;
    };
    filters: {
      drawer: boolean;
      rail: boolean;
    };
  };

  uuid: string | null;

  charts: Chart[];
}

export interface IGetters<S = IState> {
  [ChartGetterType.GET_CURRENT_THEME](state: S): string | null;
  [ChartGetterType.GET_DATASET_DRAWER](state: S): boolean;
  [ChartGetterType.GET_DATASET_RAIL](state: S): boolean;
  [ChartGetterType.GET_DATASET_MODEL](state: S): IDataset | null;
  [ChartGetterType.GET_CURRENT_DATASET](state: S): string | null;
  [ChartGetterType.HAS_MULTIPLE_ENTRIES](state: S): boolean;
  [ChartGetterType.GET_DEFAULT_ENTRY](state: S): IDataEntry | null;
  [ChartGetterType.GET_VISUALIZATION_DRAWER](state: S): boolean;
  [ChartGetterType.GET_VISUALIZATION_RAIL](state: S): boolean;
  [ChartGetterType.GET_VISUALIZATION_VIEW](state: S): View | null;
  [ChartGetterType.GET_FILTERS_DRAWER](state: S): boolean;
  [ChartGetterType.GET_FILTERS_RAIL](state: S): boolean;
  [ChartGetterType.GET_UUID](state: S): string | null;
  [ChartGetterType.GET_CHART](state: S): (uuid: string) => Chart | null;
  [ChartGetterType.GET_CURRENT_PIE_FORM](state: S): IPolarForm | null;
  [ChartGetterType.GET_CURRENT_FILTERS](state: S, uuid: string): IFilter[];
}

export interface IMutations<S = IState> {
  [ChartMutationType.RESET](state: S): void;
  [ChartMutationType.SET_THEME](state: S, theme: string): void;
  [ChartMutationType.HIDE_DATASET_DRAWER](state: S): void;
  [ChartMutationType.SHOW_DATASET_DRAWER](state: S): void;
  [ChartMutationType.SET_CURRENT_DATASET](state: S, dataset: IDataset): void;
  [ChartMutationType.HIDE_VISUALIZATION_DRAWER](state: S): void;
  [ChartMutationType.SHOW_VISUALIZATION_DRAWER](state: S): void;
  [ChartMutationType.SET_VIEW](state: S, view: View): void;
  [ChartMutationType.HIDE_FILTERS_DRAWER](state: S): void;
  [ChartMutationType.SHOW_FILTERS_DRAWER](state: S): void;

  [ChartMutationType.RESET_CHART](state: S): void;
  [ChartMutationType.INIT_SINGLE_CHART](state: S): void;
  [ChartMutationType.INIT_POLAR](state: S, uuid: string): void;

  [ChartMutationType.POST_POLAR](state: S, uuid: string): void;
  [ChartMutationType.POST_POLAR_SUCCESS](
    state: S,
    payload: { response: IPolarResponse; uuid: string }
  ): void;
  [ChartMutationType.POST_POLAR_ERROR](
    state: S,
    payload: { error: Error; uuid: string }
  ): void;
}

export type AugmentedActionContext = Omit<
  ActionContext<IState, RootState>,
  'commit'
> & {
  commit<K extends keyof IMutations>(
    key: K,
    payload?: Parameters<IMutations[K]>[1]
  ): ReturnType<IMutations[K]>;
};

export interface IActions {
  [ChartActionType.POST_POLAR](
    { commit }: AugmentedActionContext,
    payload: { slug: string; uuid: string; polar: IPolarForm }
  ): Promise<IPolarResponse>;
}

export enum ChartGetterType {
  GET_CURRENT_THEME = 'GET_CURRENT_THEME',
  GET_DATASET_DRAWER = 'GET_DATASET_DRAWER',
  GET_DATASET_RAIL = 'GET_DATASET_RAIL',
  GET_DATASET_MODEL = 'GET_DATASET_MODEL',
  GET_CURRENT_DATASET = 'GET_CURRENT_DATASET',
  HAS_MULTIPLE_ENTRIES = 'HAS_MULTIPLE_ENTRIES',
  GET_DEFAULT_ENTRY = 'GET_DEFAULT_ENTRY',
  GET_VISUALIZATION_DRAWER = 'GET_VISUALIZATION_DRAWER',
  GET_VISUALIZATION_RAIL = 'GET_VISUALIZATION_RAIL',
  GET_VISUALIZATION_VIEW = 'GET_VISUALIZATION_VIEW',
  GET_FILTERS_DRAWER = 'GET_FILTERS_DRAWER',
  GET_FILTERS_RAIL = 'GET_FILTERS_RAIL',
  GET_UUID = 'GET_UUID',
  GET_CHART = 'GET_CHART',
  GET_CURRENT_PIE_FORM = 'GET_CURRENT_PIE_FORM',
  GET_CURRENT_FILTERS = 'GET_CURRENT_FILTERS',
}

export enum ChartMutationType {
  RESET = 'RESET',
  SET_THEME = 'SET_THEME',
  HIDE_DATASET_DRAWER = 'HIDE_DATASET_DRAWER',
  SHOW_DATASET_DRAWER = 'SHOW_DATASET_DRAWER',
  SET_CURRENT_DATASET = 'SET_CURRENT_DATASET',
  SHOW_VISUALIZATION_DRAWER = 'SHOW_VISUALIZATION_DRAWER',
  HIDE_VISUALIZATION_DRAWER = 'HIDE_VISUALIZATION_DRAWER',
  SET_VIEW = 'SET_VIEW',
  SHOW_FILTERS_DRAWER = 'SHOW_FILTERS_DRAWER',
  HIDE_FILTERS_DRAWER = 'HIDE_FILTERS_DRAWER',

  RESET_CHART = 'RESET_CHART',
  INIT_SINGLE_CHART = 'INIT_SINGLE_CHART',
  INIT_POLAR = 'INIT_POLAR',

  POST_POLAR = 'POST_POLAR',
  POST_POLAR_SUCCESS = 'POST_POLAR_SUCCESS',
  POST_POLAR_ERROR = 'POST_POLAR_ERROR',
}

export enum ChartActionType {
  POST_POLAR = 'POST_POLAR',
}

export enum ChartStore {
  NAMESPACE = 'chart',

  // Getters
  GET_CURRENT_THEME = `${NAMESPACE}/${ChartGetterType.GET_CURRENT_THEME}`,
  GET_DATASET_DRAWER = `${NAMESPACE}/${ChartGetterType.GET_DATASET_DRAWER}`,
  GET_DATASET_RAIL = `${NAMESPACE}/${ChartGetterType.GET_DATASET_RAIL}`,
  GET_DATASET_MODEL = `${NAMESPACE}/${ChartGetterType.GET_DATASET_MODEL}`,
  GET_CURRENT_DATASET = `${NAMESPACE}/${ChartGetterType.GET_CURRENT_DATASET}`,
  HAS_MULTIPLE_ENTRIES = `${NAMESPACE}/${ChartGetterType.HAS_MULTIPLE_ENTRIES}`,
  GET_DEFAULT_ENTRY = `${NAMESPACE}/${ChartGetterType.GET_DEFAULT_ENTRY}`,
  GET_VISUALIZATION_DRAWER = `${NAMESPACE}/${ChartGetterType.GET_VISUALIZATION_DRAWER}`,
  GET_VISUALIZATION_RAIL = `${NAMESPACE}/${ChartGetterType.GET_VISUALIZATION_RAIL}`,
  GET_VISUALIZATION_VIEW = `${NAMESPACE}/${ChartGetterType.GET_VISUALIZATION_VIEW}`,
  GET_FILTERS_DRAWER = `${NAMESPACE}/${ChartGetterType.GET_FILTERS_DRAWER}`,
  GET_FILTERS_RAIL = `${NAMESPACE}/${ChartGetterType.GET_FILTERS_RAIL}`,
  GET_UUID = `${NAMESPACE}/${ChartGetterType.GET_UUID}`,
  GET_CHART = `${NAMESPACE}/${ChartGetterType.GET_CHART}`,
  GET_CURRENT_PIE_FORM = `${NAMESPACE}/${ChartGetterType.GET_CURRENT_PIE_FORM}`,
  GET_CURRENT_FILTERS = `${NAMESPACE}/${ChartGetterType.GET_CURRENT_FILTERS}`,

  // Mutations
  RESET = `${NAMESPACE}/${ChartMutationType.RESET}`,
  SET_THEME = `${NAMESPACE}/${ChartMutationType.SET_THEME}`,
  HIDE_DATASET_DRAWER = `${NAMESPACE}/${ChartMutationType.HIDE_DATASET_DRAWER}`,
  SHOW_DATASET_DRAWER = `${NAMESPACE}/${ChartMutationType.SHOW_DATASET_DRAWER}`,
  SET_CURRENT_DATASET = `${NAMESPACE}/${ChartMutationType.SET_CURRENT_DATASET}`,
  HIDE_VISUALIZATION_DRAWER = `${NAMESPACE}/${ChartMutationType.HIDE_VISUALIZATION_DRAWER}`,
  SHOW_VISUALIZATION_DRAWER = `${NAMESPACE}/${ChartMutationType.SHOW_VISUALIZATION_DRAWER}`,
  SET_VIEW = `${NAMESPACE}/${ChartMutationType.SET_VIEW}`,
  HIDE_FILTERS_DRAWER = `${NAMESPACE}/${ChartMutationType.HIDE_FILTERS_DRAWER}`,
  SHOW_FILTERS_DRAWER = `${NAMESPACE}/${ChartMutationType.SHOW_FILTERS_DRAWER}`,
  RESET_CHART = `${NAMESPACE}/${ChartMutationType.RESET_CHART}`,
  INIT_SINGLE_CHART = `${NAMESPACE}/${ChartMutationType.INIT_SINGLE_CHART}`,
  INIT_POLAR = `${NAMESPACE}/${ChartMutationType.INIT_POLAR}`,

  // Actions
  POST_POLAR = `${NAMESPACE}/${ChartActionType.POST_POLAR}`,
}
