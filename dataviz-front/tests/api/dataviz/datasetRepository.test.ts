import { datasetRepository } from '@/api/dataviz/datasetRepository';
import { api } from '@/api/dataviz/datavizClient';
import { HydraCollection } from '@/@types/hydra/collectionResponse';
import { IDataset, IDatasetCollection } from '@/@types/dataset';
import { datasetFactory } from '@test/data/datasetFactory';

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
      'hydra:member': [],
      'hydra:totalItems': 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const response = await datasetRepository.getCollection();

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith('dataset');
  });

  it('should fetch dataset collection successfully with themes parameter', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      'hydra:member': [],
      'hydra:totalItems': 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const themes = ['theme1', 'theme2'];
    const response = await datasetRepository.getCollection(themes);

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith('dataset?themes=theme1%2Ctheme2');
  });

  it('should fetch dataset collection successfully with dataProvider parameter', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      'hydra:member': [],
      'hydra:totalItems': 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const dataProvider = true;
    const response = await datasetRepository.getCollection(
      undefined,
      dataProvider
    );

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith('dataset?dataProvider=true');
  });

  it('should fetch dataset collection successfully with both parameters', async () => {
    const mockResponse: HydraCollection<IDatasetCollection> = {
      'hydra:member': [],
      'hydra:totalItems': 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const themes = ['theme1', 'theme2'];
    const dataProvider = false;
    const response = await datasetRepository.getCollection(
      themes,
      dataProvider
    );

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith(
      'dataset?themes=theme1%2Ctheme2&dataProvider=false'
    );
  });

  it('should handle error when fetching dataset collection', async () => {
    const error = new Error('Fetch failed');
    (api.get as vi.Mock).mockRejectedValue(error);

    await expect(datasetRepository.getCollection()).rejects.toThrow(error);

    expect(api.get).toHaveBeenCalledWith('dataset');
  });

  it('should fetch dataset item successfully', async () => {
    const mockItem = datasetFactory.build();

    (api.get as vi.Mock).mockResolvedValue(mockItem);

    const slug = 'test-slug';
    const response = await datasetRepository.getItem(slug);

    expect(response).toEqual(mockItem);
    expect(api.get).toHaveBeenCalledWith(`dataset/${slug}`);
  });

  it('should handle error when fetching dataset item', async () => {
    const error = new Error('Fetch failed');
    (api.get as vi.Mock).mockRejectedValue(error);

    const slug = 'test-slug';

    await expect(datasetRepository.getItem(slug)).rejects.toThrow(error);

    expect(api.get).toHaveBeenCalledWith(`dataset/${slug}`);
  });
});
