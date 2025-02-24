import { DateOperation } from '@/@types/dataviz/chart/enum/DateOperationEnum';
import { Operation } from '@/@types/dataviz/chart/enum/OperationEnum';

export interface IAxisDistributionPayload {
  column: string;
  dataEntry?: string | null;
  dateOperation?: DateOperation;
}

export interface IAxisOperationPayload {
  column: string;
  operation: Operation;
  dataEntry?: string | null;
}

export interface IFilterPayload {
  column: string;
  dataEntry?: string | null;
  values: string[];
}

export interface ISeriePayload {
  column: string;
  dataEntry?: string | null;
}

export interface ICartesianPayload {
  distribution: IAxisDistributionPayload;
  operation: IAxisOperationPayload;
  serie?: ISeriePayload;
  filters?: IFilterPayload[];
}

export interface IPolarPayload {
  values: IAxisOperationPayload;
  serie: ISeriePayload;
  filters?: IFilterPayload[];
}
