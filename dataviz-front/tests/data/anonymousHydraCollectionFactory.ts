import type {
  AnonymousMember,
  HydraAnonymousCollection,
} from '@/@types/hydra/collectionResponse.js';
import { faker } from '@faker-js/faker';
import { makeFactory } from 'factory.ts/lib/async.js';

const memberFactory = makeFactory<AnonymousMember>({
  id: faker.lorem.slug(),
  name: faker.lorem.words(),
  createdAt: faker.date.anytime(),
});

const dataFactory = makeFactory<HydraAnonymousCollection>({
  'hydra:member': memberFactory.buildList(100),
  'hydra:totalItems': Math.floor(Math.random() * 100),
});

export { dataFactory };
