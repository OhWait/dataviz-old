import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse.js';
import { HYDRA_KEYS } from '@/@types/hydra/hydraKeys';
import { api } from '@/api/dataviz/datavizClient';

const BASE_URL = 'data-entry';

export const getTable = async (
  slug: string,
  page: number,
  itemsPerPage: number
): Promise<HydraAnonymousCollection> => {
  const params = new URLSearchParams({
    [HYDRA_KEYS.PAGE]: String(page),
    [HYDRA_KEYS.ITEMS_PER_PAGE]: String(itemsPerPage),
  });

  const url = `${BASE_URL}/${slug}/table?${params.toString()}`;

  return api.get<HydraAnonymousCollection>(url);
};
