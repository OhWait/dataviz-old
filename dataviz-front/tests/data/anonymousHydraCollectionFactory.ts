import type {
  AnonymousMember,
  HydraAnonymousCollection,
} from '@/@types/hydra/collectionResponse.js';
import { HYDRA_KEYS } from '@/@types/hydra/HydraConstants';
import { faker } from '@faker-js/faker';
import { makeFactory } from 'factory.ts/lib/async.js';

const memberFactory = makeFactory<AnonymousMember>({
  id: faker.lorem.slug(),
  name: faker.lorem.words(),
  createdAt: faker.date.anytime(),
});

const dataFactory = makeFactory<HydraAnonymousCollection>({
  [HYDRA_KEYS.MEMBER]: memberFactory.buildList(100),
  [HYDRA_KEYS.TOTAL_ITEMS]: Math.floor(Math.random() * 100),
});

export { dataFactory };
