import { IDataEntry } from "../dataEntry";
import { IDataset } from "../dataset";
import { DateOperation } from "./enum/DateOperationEnum";
import { Operation } from "./enum/OperationEnum";
import { View } from "./enum/ViewEnum";
import { ICartesianResponse, IPolarResponse } from "./model/response";

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

export interface ChartState {
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
