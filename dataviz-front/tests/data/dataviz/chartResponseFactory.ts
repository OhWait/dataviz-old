import {
  ICartesianResponse,
  IPolarResponse,
  View,
} from '@/@types/dataviz/chart';
import { makeFactory } from 'factory.ts';
import { faker } from '@faker-js/faker';

const dataFactory = makeFactory({
  y: faker.number.int({ min: 0, max: 100 }),
  label: faker.lorem.word(),
});

const seriePolarFactory = makeFactory({
  data: dataFactory.buildList(5),
  label: faker.commerce.productName(),
});

const cartesianDataFactory = makeFactory({
  x: faker.number.int({ min: 1, max: 10 }),
  y: faker.number.int({ min: 0, max: 100 }),
  label: faker.lorem.word(),
});

const serieCartesianFactory = makeFactory({
  data: cartesianDataFactory.buildList(5),
  label: faker.commerce.productName(),
});

const queryFactory = makeFactory({
  statement: faker.lorem.sentence(),
  bindValues: faker.lorem.words(3).split(' '),
});

export const cartesianResponseFactory = makeFactory<ICartesianResponse>({
  series: serieCartesianFactory.buildList(
    faker.number.int({ min: 1, max: 10 })
  ),
  query: queryFactory.build(),
  xAxis: faker.lorem.words(10).split(' '),
});

export const polarResponseFactory = makeFactory<IPolarResponse>({
  series: seriePolarFactory.buildList(1),
  query: queryFactory.build(),
});
