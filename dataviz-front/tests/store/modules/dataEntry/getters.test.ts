import { describe, it, expect } from 'vitest';
import { getters } from '@/store/modules/dataEntry/getters';
import { IState, DataEntryGetterType } from '@/@types/dataEntry';
import { dataFactory } from '@test/data/anonymousHydraCollectionFactory.js';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse.js';
import { HYDRA_KEYS } from '@/api/hydraKeys';

describe('DataEntry Getters', () => {
  const collection = dataFactory.build() as unknown as HydraAnonymousCollection;

  const state: IState = {
    collection,
    collectionLoading: false,
    collectionError: null,
  };

  it('should get table members', () => {
    const result = getters[DataEntryGetterType.GET_TABLE_MEMBERS](state);
    expect(result).toEqual(collection[HYDRA_KEYS.MEMBER]);
  });

  it('should return empty array for table members if collection is null', () => {
    const stateWithNullCollection: IState = {
      ...state,
      collection: null,
    };
    const result = getters[DataEntryGetterType.GET_TABLE_MEMBERS](
      stateWithNullCollection
    );
    expect(result).toEqual([]);
  });

  it('should get table total items', () => {
    const result = getters[DataEntryGetterType.GET_TABLE_TOTAL_ITEMS](state);
    expect(result).toBe(collection[HYDRA_KEYS.TOTAL_ITEMS]);
  });

  it('should return 0 for total items if collection is null', () => {
    const stateWithNullCollection: IState = {
      ...state,
      collection: null,
    };
    const result = getters[DataEntryGetterType.GET_TABLE_TOTAL_ITEMS](
      stateWithNullCollection
    );
    expect(result).toBe(0);
  });

  it('should get table loading state', () => {
    const result = getters[DataEntryGetterType.GET_TABLE_LOADING](state);
    expect(result).toBe(state.collectionLoading);
  });

  it('should get table error', () => {
    const result = getters[DataEntryGetterType.GET_TABLE_ERROR](state);
    expect(result).toBe(state.collectionError);
  });
});
