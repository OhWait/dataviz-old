import { api } from '@/api/dataviz/datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { IDataset, IDatasetCollection } from '@/@types/dataset';

class DatasetRepository {
  static BASE_URL: string = 'dataset';

  async getCollection(
    themes?: string[],
    dataProvider?: boolean
  ): Promise<HydraCollection<IDatasetCollection>> {
    const params = new URLSearchParams();

    if (themes && themes.length > 0) {
      params.append('themes[]', themes.join(','));
    }
    if (dataProvider !== undefined) {
      params.append('dataProvider', dataProvider.toString());
    }

    const queryString = params.toString();
    const url = queryString
      ? `${DatasetRepository.BASE_URL}?${queryString}`
      : DatasetRepository.BASE_URL;

    return api.get<HydraCollection<IDatasetCollection>>(url);
  }

  async getItem(slug: string): Promise<IDataset> {
    return api.get<IDataset>(`${DatasetRepository.BASE_URL}/${slug}`);
  }
}

export const datasetRepository = new DatasetRepository();
