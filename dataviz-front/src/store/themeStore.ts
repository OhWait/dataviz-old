import { defineStore } from 'pinia';
import { HYDRA_KEYS } from '@/@types/hydra/hydraKeys';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { ITheme } from '@/@types/dataviz/theme';
import { getCollection } from '@/api/dataviz/themeRepository';

interface ThemeState {
  collection: HydraCollection<ITheme> | null;
  collectionLoading: boolean;
  collectionError: Error | null;
}

export const useThemeStore = defineStore('theme', {
  state: (): ThemeState => ({
    collection: null,
    collectionLoading: false,
    collectionError: null,
  }),

  actions: {
    async fetchCollection() {
      this.collectionLoading = true;
      this.collectionError = null;
      this.collection = null;

      try {
        const result = await getCollection();
        this.collection = result;
        this.collectionLoading = false;
        return result;
      } catch (e) {
        this.collectionError = e as Error;
        this.collectionLoading = false;
        throw e;
      }
    },
  },

  getters: {
    getCollectionMembers: (state): ITheme[] => state.collection?.[HYDRA_KEYS.MEMBER] || [],
    getCollectionLoading: (state): boolean => state.collectionLoading,
    getCollectionError: (state): Error | null => state.collectionError,
    getCollectionTotalItems: (state): number => state.collection?.[HYDRA_KEYS.TOTAL_ITEMS] || 0,
  },
});
