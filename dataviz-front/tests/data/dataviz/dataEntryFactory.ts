import { makeFactory } from 'factory.ts';
import { faker } from '@faker-js/faker';
import { IDataEntry } from '@/@types/dataviz/dataEntry/model';
import { metaColumnFactory } from '@test/data/dataviz/metaRowFactory';

const dataEntryFactory = makeFactory<IDataEntry>({
  slug: faker.lorem.slug(),
  title: faker.lorem.words(3),
  columns: metaColumnFactory.buildList(5),
  createdAt: faker.date.past(),
  updatedAt: faker.date.recent(),
});

export { dataEntryFactory };
