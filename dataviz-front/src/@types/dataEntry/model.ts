import { IMetaColumn } from '@/@types/column/model';

export interface IDataEntry {
  slug: string;
  title: string;
  columns: IMetaColumn[];
  createdAt: Date;
  updatedAt: Date;
}
