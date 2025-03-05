import {
  ICartesianForm,
  IPolarForm,
  IFilter,
  Operation,
} from '@/@types/dataviz/chart';
import { makeFactory } from 'factory.ts';
import { dataEntryFactory } from './dataEntryFactory';

const entry = dataEntryFactory.build();

// Factory pour les filtres
export const filterFactory = makeFactory<IFilter>({
  entry,
  dataEntry: entry.slug,
  column: entry.columns[0].columnName || null,
  values: entry.columns[0].values.map(v => v.value),
  valueOptions: entry.columns[0].values.map(v => ({
    text: v.label,
    value: v.value,
  })),
});

// Factory pour IPolarForm
export const polarFormFactory = makeFactory<IPolarForm>({
  values: {
    column: entry.columns[0].columnName,
    operation: Operation.Count,
    dataEntry: entry.slug,
  },
  serie: {
    column: entry.columns[1].columnName,
    dataEntry: entry.slug,
  },
  filters: filterFactory.buildList(2),
});

// Factory pour ICartesianForm
export const cartesianFormFactory = makeFactory<ICartesianForm>({
  distribution: {
    column: entry.columns[0].columnName,
    dataEntry: entry.slug,
    dateOperation: null,
  },
  operation: {
    column: entry.columns[0].columnName,
    operation: Operation.Count,
    dataEntry: entry.slug,
  },
  serie: {
    column: entry.columns[1].columnName,
    dataEntry: entry.slug,
  },
  filters: filterFactory.buildList(2),
});
