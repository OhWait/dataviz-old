import { IMetaColumn } from '@/@types/dataviz/column/model';

export interface IDataEntry {
  slug: string;
  title: string;
  columns: IMetaColumn[];
  createdAt: Date;
  updatedAt: Date;
}

export default IDataEntry;