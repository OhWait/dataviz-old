import { IAxisOperationPayload, IFilterPayload, IPolarForm, IPolarPayload, ISeriePayload } from "@/@types/dataviz/chart";

export const polarDataTransformer = (polar: IPolarForm): IPolarPayload => {
    const values: IAxisOperationPayload = {
      column: polar.values.column!,
      operation: polar.values.operation!,
      dataEntry: polar.values.dataEntry,
    };
  
    const serie: ISeriePayload = {
      column: polar.serie.column!,
      dataEntry: polar.serie.dataEntry,
    };
  
    const filters: IFilterPayload[] = polar.filters.map(filter => ({
      column: filter.column!,
      dataEntry: filter.dataEntry,
      values: filter.values,
    }));
  
    return {
      values,
      serie,
      filters,
    };
  };
