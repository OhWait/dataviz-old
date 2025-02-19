import { api } from '@/api/dataviz/datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { IDataset, IDatasetCollection } from '@/@types/dataviz/dataset';

const BASE_URL = 'dataset';

export const getCollection = async (
  themes?: string[],
  dataProvider?: boolean
): Promise<HydraCollection<IDatasetCollection>> => {
  const params = new URLSearchParams();

  if (themes && themes.length > 0) {
    params.append('themes[]', themes.join(','));
  }
  if (dataProvider !== undefined) {
    params.append('dataProvider', dataProvider.toString());
  }

  const queryString = params.toString();
  const url = queryString ? `${BASE_URL}?${queryString}` : BASE_URL;

  return api.get<HydraCollection<IDatasetCollection>>(url);
};

export const getItem = async (slug: string): Promise<IDataset> => {
  return api.get<IDataset>(`${BASE_URL}/${slug}`);
};
