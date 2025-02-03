import { describe, it, expect } from 'vitest';
import { mutations } from '@/store/modules/dataEntry/mutations';
import { IState, DataEntryMutationType } from '@/@types/dataEntry';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse';
import { dataFactory } from '@test/data/anonymousHydraCollectionFactory.js';

describe('DataEntry Mutations', () => {
  const state: IState = {
    collection: null,
    collectionLoading: false,
    collectionError: null,
  };

  it('should set table loading state', () => {
    mutations[DataEntryMutationType.SET_TABLE](state);

    expect(state.collection).toBe(null);
    expect(state.collectionLoading).toBe(true);
    expect(state.collectionError).toBe(null);
  });

  it('should set table successfully', async () => {
    const data: HydraAnonymousCollection = await dataFactory.build();

    mutations[DataEntryMutationType.SET_TABLE_SUCCESS](state, data);

    expect(state.collectionLoading).toBe(false);
    expect(state.collectionError).toBe(null);
    expect(state.collection).toEqual(data);
  });

  it('should set table error', () => {
    const error = new Error('Table fetch error');

    mutations[DataEntryMutationType.SET_TABLE_ERROR](state, error);

    expect(state.collectionLoading).toBe(false);
    expect(state.collectionError).toBe(error);
    expect(state.collection).toBe(null);
  });
});
