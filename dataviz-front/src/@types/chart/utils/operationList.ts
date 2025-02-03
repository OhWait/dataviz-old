import { Operation } from '@/@types/chart/model/payload.js';
import { DataType } from '@/@types/column/model.js';
import { i18n } from '@/plugins/i18n.js';

const { t } = i18n.global;

type ItemOperation = {
  value: Operation;
  text: string;
  available: (dataType?: DataType) => boolean;
};

const summable = [DataType.Integer, DataType.Float, DataType.Numeric];

export const operationList: ItemOperation[] = [
  {
    value: Operation.Sum,
    text: t('chart.form.operation.sum'),
    available: (dataType?: DataType) =>
      dataType ? summable.includes(dataType) : false,
  },
  {
    value: Operation.Count,
    text: t('chart.form.operation.count'),
    available: () => true,
  },
  {
    value: Operation.CountDistinct,
    text: t('chart.form.operation.count_distinct'),
    available: () => true,
  },
];
