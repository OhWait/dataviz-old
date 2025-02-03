import { describe, it, expect } from 'vitest';
import { mutations } from '@/store/modules/dataset/mutations';
import { IState, DatasetMutationType } from '@/@types/dataset';
import {
  datasetCollectionFactory,
  datasetFactory,
} from '@test/data/datasetFactory.js';

describe('Dataset Mutations', () => {
  const state: IState = {
    collection: null,
    collectionLoading: false,
    collectionError: null,
    item: null,
    itemLoading: false,
    itemError: null,
  };

  it('should set collection loading state', () => {
    mutations[DatasetMutationType.SET_COLLECTION](state);

    expect(state.collectionLoading).toBe(true);
    expect(state.collectionError).toBe(null);
    expect(state.collection).toBe(null);
  });

  it('should set collection successfully', () => {
    const data = datasetCollectionFactory.build();

    mutations[DatasetMutationType.SET_COLLECTION_SUCCESS](state, data);

    expect(state.collectionLoading).toBe(false);
    expect(state.collectionError).toBe(null);
    expect(state.collection).toEqual(data);
  });

  it('should set collection error', () => {
    const error = new Error('Collection fetch error');

    mutations[DatasetMutationType.SET_COLLECTION_ERROR](state, error);

    expect(state.collectionLoading).toBe(false);
    expect(state.collectionError).toBe(error);
    expect(state.collection).toBe(null);
  });

  it('should set item loading state', () => {
    mutations[DatasetMutationType.SET_ITEM](state);

    expect(state.itemLoading).toBe(true);
    expect(state.itemError).toBe(null);
    expect(state.item).toBe(null);
  });

  it('should set item successfully', () => {
    const item = datasetFactory.build();

    mutations[DatasetMutationType.SET_ITEM_SUCCESS](state, item);

    expect(state.itemLoading).toBe(false);
    expect(state.itemError).toBe(null);
    expect(state.item).toEqual(item);
  });

  it('should set item error', () => {
    const error = new Error('Item fetch error');

    mutations[DatasetMutationType.SET_ITEM_ERROR](state, error);

    expect(state.itemLoading).toBe(false);
    expect(state.itemError).toBe(error);
    expect(state.item).toBe(null);
  });
});
