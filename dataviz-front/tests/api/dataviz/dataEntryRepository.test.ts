import { dataEntryRepository } from '@/api/dataviz/dataEntryRepository';
import { api } from '@/api/dataviz/datavizClient';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse';

vi.mock('@/api/dataviz/datavizClient', () => ({
  api: {
    get: vi.fn(),
  },
}));

describe('DataEntryRepository', () => {
  it('should fetch data entry table successfully', async () => {
    const mockResponse: HydraAnonymousCollection = {
      'hydra:member': [],
      'hydra:totalItems': 0,
    };

    (api.get as vi.Mock).mockResolvedValue(mockResponse);

    const slug = 'test-slug';
    const page = 1;
    const itemsPerPage = 10;

    const response = await dataEntryRepository.getTable(
      slug,
      page,
      itemsPerPage
    );

    expect(response).toEqual(mockResponse);
    expect(api.get).toHaveBeenCalledWith(
      `data-entry/${slug}/table?page=${page}&itemsPerPage=${itemsPerPage}`
    );
  });
});
