import { describe, it, expect } from 'vitest';
import { getters } from '@/store/modules/dataset/getters';
import { IState, DatasetGetterType } from '@/@types/dataset';
import {
  datasetCollectionFactory,
  datasetFactory,
} from '@test/data/datasetFactory.js';

describe('Dataset Getters', () => {
  const collection = datasetCollectionFactory.build();
  const item = datasetFactory.build();

  const state: IState = {
    collection,
    collectionLoading: false,
    collectionError: null,
    item,
    itemLoading: false,
    itemError: null,
  };

  it('should get collection members', () => {
    const result = getters[DatasetGetterType.GET_COLLECTION_MEMBERS](state);
    expect(result).toEqual(collection['hydra:member']);
  });

  it('should return empty array for collection members if collection is null', () => {
    const stateWithNullCollection: IState = {
      ...state,
      collection: null,
    };
    const result = getters[DatasetGetterType.GET_COLLECTION_MEMBERS](
      stateWithNullCollection
    );
    expect(result).toEqual([]);
  });

  it('should get collection loading state', () => {
    const result = getters[DatasetGetterType.GET_COLLECTION_LOADING](state);
    expect(result).toBe(state.collectionLoading);
  });

  it('should get collection error', () => {
    const result = getters[DatasetGetterType.GET_COLLECTION_ERROR](state);
    expect(result).toBe(state.collectionError);
  });

  it('should get collection total items', () => {
    const result = getters[DatasetGetterType.GET_COLLECTION_TOTAL_ITEMS](state);
    expect(result).toBe(collection['hydra:totalItems']);
  });

  it('should return 0 for total items if collection is null', () => {
    const stateWithNullCollection: IState = {
      ...state,
      collection: null,
    };
    const result = getters[DatasetGetterType.GET_COLLECTION_TOTAL_ITEMS](
      stateWithNullCollection
    );
    expect(result).toBe(0);
  });

  it('should get item', () => {
    const result = getters[DatasetGetterType.GET_ITEM](state);
    expect(result).toEqual(item);
  });

  it('should get item loading state', () => {
    const result = getters[DatasetGetterType.GET_ITEM_LOADING](state);
    expect(result).toBe(state.itemLoading);
  });

  it('should get item error', () => {
    const result = getters[DatasetGetterType.GET_ITEM_ERROR](state);
    expect(result).toBe(state.itemError);
  });
});
