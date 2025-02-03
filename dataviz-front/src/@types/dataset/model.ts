import { IDataEntry } from '@/@types/dataEntry/model.js';
import type { IProvider } from '../provider';
import Frequency from './enum/Frequency';
import Granularity from './enum/Granularity';
import Language from './enum/Language';

export interface IDatasetCollection {
  '@id': string;
  slug: string;
  title: string;
  shortTitle?: string;
  perimeter: string;
  description?: string;
  granularity: Granularity;
  dataUpdatedAt: Date;
  dataCreatedAt?: Date;
  language?: Language;
  updateFrequency?: Frequency;
  updatePeriod?: string;
  updatedAt: Date;
  createdAt: Date;
  provider: IProvider;
}

export interface IDataset extends IDatasetCollection {
  dataEntries: IDataEntry[];
}

export { Frequency, Granularity, Language };
