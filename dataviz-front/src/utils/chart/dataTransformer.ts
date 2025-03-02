import {
  IAxisDistributionPayload,
  IAxisOperationPayload,
  ICartesianForm,
  ICartesianPayload,
  IPolarForm,
  IPolarPayload,
  ISeriePayload,
} from '@/@types/dataviz/chart';

export const polarDataTransformer = (form: IPolarForm): IPolarPayload => {
  if (!form.values.column || !form.values.operation) {
    console.error(form);
    throw new Error(
      "Invalid polar form: 'values.column' and 'values.operation' are required."
    );
  }

  if (!form.serie.column) {
    console.error(form);
    throw new Error("Invalid polar form: 'serie.column' is required.");
  }

  const values: IAxisOperationPayload = {
    column: form.values.column,
    operation: form.values.operation,
    ...(form.values.dataEntry && { dataEntry: form.values.dataEntry }),
  };

  const serie: ISeriePayload = {
    column: form.serie.column,
    ...(form.serie.dataEntry && { dataEntry: form.serie.dataEntry }),
  };

  const filters = form.filters
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

export const cartesianDataTransformer = (form: ICartesianForm): ICartesianPayload => {
  if (!form.distribution.column) {
    console.error(form);
    throw new Error("Invalid cartesian form: 'distribution.column' is required.");
  }

  if (!form.operation.column || !form.operation.operation) {
    console.error(form);
    throw new Error("Invalid cartesian form: 'operation.column' and 'operation.operation' are required.");
  }

  const distribution: IAxisDistributionPayload = {
    column: form.distribution.column,
    ...(form.distribution.dateOperation && { dateOperation: form.distribution.dateOperation }),
    ...(form.distribution.dataEntry && { dataEntry: form.distribution.dataEntry }),
  };

  const operation: IAxisOperationPayload = {
    column: form.operation.column,
    operation: form.operation.operation,
    ...(form.operation.dataEntry && { dataEntry: form.operation.dataEntry }),
  };

  const serie: ISeriePayload | undefined = form.serie.column
    ? {
        column: form.serie.column,
        ...(form.serie.dataEntry && { dataEntry: form.serie.dataEntry }),
      }
    : undefined;

  const filters = form.filters
    .filter(filter => filter.column)
    .map(({ column, dataEntry, values }) => ({
      column: column as string,
      ...(dataEntry && { dataEntry }),
      values,
    }));

  return {
    distribution,
    operation,
    ...(serie && { serie }),
    ...(filters.length > 0 && { filters }),
  };
};
