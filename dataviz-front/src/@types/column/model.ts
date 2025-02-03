import { IValues } from '@/@types/values/model';

export interface IMetaColumn {
  columnName: string;
  isNullable: boolean;
  dataType: DataType;
  characterMaximumLength?: number;
  label: string;
  values: IValues[];
}

export enum DataType {
  CharacterVarying = 'character varying',
  Integer = 'integer',
  Float = 'float',
  Numeric = 'numeric',
  Boolean = 'boolean',
  Date = 'date',
  DateTime = 'datetime',
  TimeWithoutTimeZone = 'time without time zone',
  TimeWithTimeZone = 'time with time zone',
}
