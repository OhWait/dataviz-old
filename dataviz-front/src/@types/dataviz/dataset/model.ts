import IDataEntry from '@/@types/dataviz/dataEntry/model.js';
import Frequency from '@/@types/dataviz/dataset/enum/FrequencyEnum';
import Granularity from '@/@types/dataviz/dataset/enum/GranularityEnum';
import Language from '@/@types/dataviz/dataset/enum/LanguageEnum';
import IProvider from '@/@types/dataviz/provider/model';

export interface IDatasetCollection {
  '@id': string;
  slug: string;
  title: string;
  shortTitle?: string;
  perimeter: string;
  description?: string;
  granularity: Granularity;
  dataUpdatedAt?: Date;
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
