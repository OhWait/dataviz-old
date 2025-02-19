import { makeFactory } from 'factory.ts';
import { faker } from '@faker-js/faker';
import { DataType, IMetaColumn } from '@/@types/dataviz/column/model';
import { IValues } from '@/@types/values/model';

const valuesFactory = makeFactory<IValues>({
  value: faker.lorem.word(),
  label: faker.lorem.words(),
});

const metaColumnFactory = makeFactory<IMetaColumn>({
  columnName: faker.database.column(),
  isNullable: faker.datatype.boolean(),
  dataType: faker.helpers.enumValue(DataType),
  characterMaximumLength: faker.number.int({
    min: 1,
    max: 255,
  }),
  label: faker.lorem.words(2),
  values: valuesFactory.buildList(3),
});

export { metaColumnFactory };
