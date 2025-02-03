// src/store/modules/dataset/state.test.ts
import { describe, it, expect } from 'vitest';
import { state } from '@/store/modules/dataset/state';
import { IState } from '@/@types/dataset';

describe('Dataset State', () => {
  it('should have the correct initial state', () => {
    const initialState: IState = {
      collection: null,
      collectionLoading: false,
      collectionError: null,
      item: null,
      itemLoading: false,
      itemError: null,
    };

    expect(state).toEqual(initialState);
  });
});
