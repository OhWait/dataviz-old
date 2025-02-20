import { IValues } from '@/@types/dataviz/values/model';
import { DataType } from '@/@types/dataviz/column/enum/DataTypeEnum';

export interface IMetaColumn {
  columnName: string;
  isNullable: boolean;
  dataType: DataType;
  characterMaximumLength?: number;
  label: string;
  values: IValues[];
}
