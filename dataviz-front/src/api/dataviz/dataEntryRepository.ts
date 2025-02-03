import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse.js';
import { api } from '@/api/dataviz/datavizClient';

class DataEntryRepository {
  static BASE_URL: string = 'data-entry';

  async getTable(
    slug: string,
    page: number,
    itemsPerPage: number
  ): Promise<HydraAnonymousCollection> {
    const params = new URLSearchParams({
      page: String(page),
      itemsPerPage: String(itemsPerPage),
    });

    const url = `${
      DataEntryRepository.BASE_URL
    }/${slug}/table?${params.toString()}`;

    return api.get<HydraAnonymousCollection>(url);
  }
}

export const dataEntryRepository = new DataEntryRepository();
