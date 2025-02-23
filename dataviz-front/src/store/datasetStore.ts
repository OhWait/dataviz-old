import { defineStore } from 'pinia';
import { getCollection, getItem } from '@/api/dataviz/datasetRepository';
import { IDataset, IDatasetCollection } from '@/@types/dataviz/dataset';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { HYDRA_KEYS } from '@/@types/hydra/hydraKeys';

interface DatasetState {
  collection: HydraCollection<IDatasetCollection> | null;
  collectionLoading: boolean;
  collectionError: Error | null;
  item: IDataset | null;
  itemLoading: boolean;
  itemError: Error | null;
}

interface FetchCollectionPayload {
  themes?: string[];
  dataProvider?: boolean;
}

export const useDatasetStore = defineStore('dataset', {
  state: (): DatasetState => ({
    collection: null,
    collectionLoading: false,
    collectionError: null,
    item: null,
    itemLoading: false,
    itemError: null,
  }),

  actions: {
    async fetchCollection(payload?: FetchCollectionPayload) {
      this.collectionLoading = true;
      this.collectionError = null;
      try {
        const result = await getCollection(
          payload?.themes,
          payload?.dataProvider
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

    async fetchItem(slug: string) {
      this.itemLoading = true;
      this.itemError = null;
      try {
        const result = await getItem(slug);
        this.item = result;
        return result;
      } catch (e) {
        this.itemError = e as Error;
        throw e;
      } finally {
        this.itemLoading = false;
      }
    },
  },

  getters: {
    getCollectionMembers: (state): IDatasetCollection[] =>
      state.collection?.[HYDRA_KEYS.MEMBER] || [],
    getCollectionLoading: (state): boolean => state.collectionLoading,
    getCollectionError: (state): Error | null => state.collectionError,
    getCollectionTotalItems: (state): number =>
      state.collection?.[HYDRA_KEYS.TOTAL_ITEMS] || 0,
    getItem: (state): IDataset | null => state.item,
    getItemLoading: (state): boolean => state.itemLoading,
    getItemError: (state): Error | null => state.itemError,
  },
});
