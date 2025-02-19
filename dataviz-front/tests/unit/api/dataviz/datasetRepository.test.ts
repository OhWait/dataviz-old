import { getCollection, getItem } from '@/api/dataviz/datasetRepository';
import { api } from '@/api/dataviz/datavizClient';
import { HydraCollection } from '@/@types/hydra/collectionResponse';
import { IDatasetCollection } from '@/@types/dataviz/dataset';
import { datasetFactory } from '@test/data/dataviz/datasetFactory';
import { HYDRA_KEYS } from '@/@types/hydra/hydraKeys';

vi.mock('@/api/dataviz/datavizClient', () => ({
  api: {
    get: vi.fn(),
  },
}));

describe('DatasetRepository', () => {
  beforeEach(() => {
    vi.resetAllMocks();
  });

  it('should fetch dataset collection successfully without parameters', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      [HYDRA_KEYS.MEMBER]: [],
      [HYDRA_KEYS.TOTAL_ITEMS]: 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const response = await getCollection();

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith('dataset');
  });

  it('should fetch dataset collection successfully with themes parameter', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      [HYDRA_KEYS.MEMBER]: [],
      [HYDRA_KEYS.TOTAL_ITEMS]: 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const themes = ['theme1', 'theme2'];
    const response = await getCollection(themes);

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith('dataset?themes%5B%5D=theme1%2Ctheme2');
  });

  it('should fetch dataset collection successfully with dataProvider parameter', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      [HYDRA_KEYS.MEMBER]: [],
      [HYDRA_KEYS.TOTAL_ITEMS]: 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const dataProvider = true;
    const response = await getCollection(
      undefined,
      dataProvider
    );

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith('dataset?dataProvider=true');
  });

  it('should fetch dataset collection successfully with both parameters', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      [HYDRA_KEYS.MEMBER]: [],
      [HYDRA_KEYS.TOTAL_ITEMS]: 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const themes = ['theme1', 'theme2'];
    const dataProvider = false;
    const response = await getCollection(
      themes,
      dataProvider
    );

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith(
      'dataset?themes%5B%5D=theme1%2Ctheme2&dataProvider=false'
    );
  });

  it('should handle error when fetching dataset collection', async () => {
    const error = new Error('Fetch failed');
    (api.get as vi.Mock).mockRejectedValue(error);

    await expect(getCollection()).rejects.toThrow(error);

    expect(api.get).toHaveBeenCalledWith('dataset');
  });

  it('should fetch dataset item successfully', async () => {
    const mockItem = datasetFactory.build();

    (api.get as vi.Mock).mockResolvedValue(mockItem);

    const slug = 'test-slug';
    const response = await getItem(slug);

    expect(response).toEqual(mockItem);
    expect(api.get).toHaveBeenCalledWith(`dataset/${slug}`);
  });

  it('should handle error when fetching dataset item', async () => {
    const error = new Error('Fetch failed');
    (api.get as vi.Mock).mockRejectedValue(error);

    const slug = 'test-slug';

    await expect(getItem(slug)).rejects.toThrow(error);

    expect(api.get).toHaveBeenCalledWith(`dataset/${slug}`);
  });
});
