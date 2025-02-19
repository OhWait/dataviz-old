import {
  IAxisOperationPayload,
  IPolarForm,
  IPolarPayload,
  ISeriePayload,
} from '@/@types/dataviz/chart';

export const polarDataTransformer = (polar: IPolarForm): IPolarPayload => {
  if (!polar.values.column || !polar.values.operation) {
    console.error(polar);
    throw new Error(
      "Invalid polar form: 'values.column' and 'values.operation' are required."
    );
  }

  if (!polar.serie.column) {
    console.error(polar);
    throw new Error("Invalid polar form: 'serie.column' is required.");
  }

  const values: IAxisOperationPayload = {
    column: polar.values.column,
    operation: polar.values.operation,
    ...(polar.values.dataEntry && { dataEntry: polar.values.dataEntry }),
  };

  const serie: ISeriePayload = {
    column: polar.serie.column,
    ...(polar.serie.dataEntry && { dataEntry: polar.serie.dataEntry }),
  };

  const filters = polar.filters
    .filter(filter => filter.column)
    .map(({ column, dataEntry, values }) => ({
      column: column as string,
      ...(dataEntry && { dataEntry }),
      values,
    }));

  return {
    values,
    serie,
    ...(filters.length > 0 && { filters }),
  };
};
