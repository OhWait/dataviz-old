import { DataType } from '@/@types/dataviz/column/enum/DataTypeEnum';

/**
 * Mapping between DataType enum values and Material Design Icons (MDI) names.
 */
export const dataTypeIconMapping: Record<DataType, string> = {
  [DataType.CharacterVarying]: 'mdi-format-letter-case',
  [DataType.Integer]: 'mdi-numeric',
  [DataType.Float]: 'mdi-decimal-comma',
  [DataType.Numeric]: 'mdi-decimal-comma',
  [DataType.Boolean]: 'mdi-checkbox-marked-outline',
  [DataType.Date]: 'mdi-calendar',
  [DataType.DateTime]: 'mdi-calendar-clock',
  [DataType.TimeWithoutTimeZone]: 'mdi-calendar-clock',
  [DataType.TimeWithTimeZone]: 'mdi-calendar-clock',
};