import { View } from "../enum/ViewEnum";

interface IDataResponse {
  y: number;
  label?: string;
}

interface ICartesianDataResponse extends IDataResponse {
  x: number | string | null;
}

interface ISerieResponse<T extends IDataResponse> {
  data: T[];
  label?: string;
}

interface IQueryResponse {
  statement?: string;
  bindValues?: string[];
}

interface IChartResponse<T extends IDataResponse | ICartesianDataResponse> {
  series: ISerieResponse<T>[];
  query?: IQueryResponse;
  view?: View;
}

export interface ICartesianResponse
  extends IChartResponse<ICartesianDataResponse> {
  xAxis: string[] | number[];
}

export interface IPolarResponse extends IChartResponse<IDataResponse> {}
