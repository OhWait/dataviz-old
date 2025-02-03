import { makeFactory } from 'factory.ts';
import { faker } from '@faker-js/faker';
import { IProvider } from '@/@types/provider/model.js';

const providerFactory = makeFactory<IProvider>({
  slug: faker.lorem.slug(),
  name: faker.company.name(),
  acronym: faker.lorem.word({ length: { min: 2, max: 5 } }),
  description: faker.lorem.paragraph(),
  image: faker.internet.url(),
});

export { providerFactory };
