import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse.js';
import { HYDRA_KEYS } from '@/api/hydraKeys';
import { api } from '@/api/dataviz/datavizClient';

class DataEntryRepository {
  static BASE_URL: string = 'data-entry';

  async getTable(
    slug: string,
    page: number,
    itemsPerPage: number
  ): Promise<HydraAnonymousCollection> {
    const params = new URLSearchParams({
      [HYDRA_KEYS.PAGE]: String(page),
      [HYDRA_KEYS.ITEMS_PER_PAGE]: String(itemsPerPage),
    });

    const url = `${
      DataEntryRepository.BASE_URL
    }/${slug}/table?${params.toString()}`;

    return api.get<HydraAnonymousCollection>(url);
  }
}

export const dataEntryRepository = new DataEntryRepository();
