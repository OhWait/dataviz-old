import { IDataEntry } from '@/@types/dataviz/dataEntry';
import { IDataset } from '@/@types/dataviz/dataset';
import { DateOperation } from './enum/DateOperationEnum';
import { Operation } from './enum/OperationEnum';
import { View } from './enum/ViewEnum';
import { ICartesianResponse, IPolarResponse } from './model/response';

export type TChartResponse = IPolarResponse | ICartesianResponse;

interface IChart<TChartPayload, TChartResponse> {
  uuid: string;
  active: boolean;
  isLoading: boolean;
  payload?: TChartPayload;
  response?: TChartResponse | null;
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

export type TChart = IPolar | ICartesian;
export type TChartForm = IPolarForm | ICartesianForm;

export type TDrawerKey = 'dataset' | 'visualization' | 'filter';

export interface IDrawer {
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

export interface IChartState {
  drawers: IDrawer;
  charts: TChart[];
}
