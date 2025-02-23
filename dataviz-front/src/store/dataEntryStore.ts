import { defineStore } from 'pinia';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse';
import { HYDRA_KEYS } from '@/@types/hydra/hydraKeys';
import { getTable } from '@/api/dataviz/dataEntryRepository';

interface DataEntryState {
  collection: HydraAnonymousCollection | null;
  collectionLoading: boolean;
  collectionError: Error | null;
}

interface FetchTablePayload {
  slug: string;
  page: number;
  itemsPerPage: number;
}

export const useDataEntryStore = defineStore('dataEntry', {
  state: (): DataEntryState => ({
    collection: null,
    collectionLoading: false,
    collectionError: null,
  }),

  actions: {
    async fetchTable(payload: FetchTablePayload) {
      this.collectionLoading = true;
      this.collectionError = null;
      try {
        const result = await getTable(
          payload.slug,
          payload.page,
          payload.itemsPerPage
        );
        this.collection = result;
        return result;
      } catch (e) {
        this.collectionError = e as Error;
        throw e;
      } finally {
        this.collectionLoading = false;
      }
    },
  },

  getters: {
    getTableMembers: state =>
      state.collection ? state.collection[HYDRA_KEYS.MEMBER] : [],
    getTableTotalItems: state =>
      state.collection ? state.collection[HYDRA_KEYS.TOTAL_ITEMS] : 0,
    getTableLoading: state => state.collectionLoading,
    getTableError: state => state.collectionError,
  },
});
