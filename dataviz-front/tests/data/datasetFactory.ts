import { makeFactory } from 'factory.ts';
import { faker } from '@faker-js/faker';
import {
  Frequency,
  Granularity,
  IDataset,
  IDatasetCollection,
  Language,
} from '@/@types/dataset';
import HydraCollection from '@/@types/hydra/collectionResponse.js';
import { dataEntryFactory } from '@test/data/dataEntryFactory.js';
import { providerFactory } from '@test/data/providerFactory.js';
import { HYDRA_KEYS } from '@/@types/hydra/HydraConstants';

const datasetFactory = makeFactory<IDataset>({
  '@id': faker.string.uuid(),
  slug: faker.lorem.slug(),
  title: faker.lorem.word({ length: { min: 1, max: 5 } }),
  shortTitle: faker.lorem.word({ length: { min: 0, max: 2 } }),
  perimeter: faker.lorem.word({ length: { min: 1, max: 5 } }),
  description: faker.lorem.word({ length: { min: 0, max: 15 } }),
  granularity: faker.helpers.enumValue(Granularity),
  language: faker.helpers.enumValue(Language),
  updateFrequency: faker.helpers.enumValue(Frequency),
  updatePeriod: faker.lorem.word(),
  dataUpdatedAt: faker.date.anytime(),
  dataCreatedAt: faker.date.anytime(),
  updatedAt: faker.date.anytime(),
  createdAt: faker.date.anytime(),
  dataEntries: dataEntryFactory.buildList(3),
  provider: providerFactory.build(),
});

const datasetCollectionFactory = makeFactory<
  HydraCollection<IDatasetCollection>
>({
  [HYDRA_KEYS.MEMBER]: datasetFactory.buildList(10),
  [HYDRA_KEYS.TOTAL_ITEMS]: 10,
});

export { datasetFactory, datasetCollectionFactory };
