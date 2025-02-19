export enum Operation {
  Sum = 'SUM',
  Count = 'COUNT',
  CountDistinct = 'COUNT_DISTINCT',
}

export enum DateOperation {
  ByHour = 'BY_HOUR',
  ByDay = 'BY_DAY',
  ByDayOfTheWeek = 'BY_DAY_OF_THE_WEEK',
  ByMonth = 'BY_MONTH',
  Daily = 'DAILY',
  Monthly = 'MONTHLY',
  Yearly = 'YEARLY',
}

export interface IAxisDistributionPayload {
  column: string;
  dataEntry?: string;
  dateOperation?: DateOperation;
}

export interface IAxisOperationPayload {
  column: string;
  operation: Operation;
  dataEntry?: string;
}

export interface IFilterPayload {
  column: string;
  dataEntry?: string;
  values: string[];
}

export interface ISeriePayload {
  column: string;
  dataEntry?: string;
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
