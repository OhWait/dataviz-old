import { actions } from '@/store/modules/dataset/actions';
import { ActionContext } from 'vuex';
import {
  IState,
  DatasetActionType,
  DatasetMutationType,
  IDatasetCollection,
} from '@/@types/dataset';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { RootState } from '@/@types/store';
import { Mock, Mocked } from 'vitest';
import { datasetFactory } from '@test/data/datasetFactory';
import { datasetRepository } from '@/api/dataviz/datasetRepository';
import { HYDRA_KEYS } from '@/@types/hydra/HydraConstants';

vi.mock('@/api/dataviz/datasetRepository', () => ({
  datasetRepository: {
    getCollection: vi.fn(),
    getItem: vi.fn(),
  },
}));

const mockDatasetRepository = datasetRepository as Mocked<
  typeof datasetRepository
>;

describe('dataset actions', () => {
  let commit: Mock;

  beforeEach(() => {
    commit = vi.fn();
  });

  describe(DatasetActionType.FETCH_COLLECTION, () => {
    it('commits SET_COLLECTION and SET_COLLECTION_SUCCESS on successful fetch', async () => {
      const collectionResponse: HydraCollection<IDatasetCollection> = {
        [HYDRA_KEYS.MEMBER]: [],
        [HYDRA_KEYS.TOTAL_ITEMS]: 0,
      };
      mockDatasetRepository.getCollection.mockResolvedValue(collectionResponse);

      await actions[DatasetActionType.FETCH_COLLECTION]({
        commit,
      } as unknown as ActionContext<IState, RootState>);

      expect(commit).toHaveBeenCalledWith(DatasetMutationType.SET_COLLECTION);
      expect(commit).toHaveBeenCalledWith(
        DatasetMutationType.SET_COLLECTION_SUCCESS,
        collectionResponse
      );
    });

    it('commits SET_COLLECTION and SET_COLLECTION_ERROR on fetch error', async () => {
      const error = new Error('Fetch failed');
      mockDatasetRepository.getCollection.mockRejectedValue(error);

      await expect(
        actions[DatasetActionType.FETCH_COLLECTION]({
          commit,
        } as unknown as ActionContext<IState, RootState>)
      ).rejects.toThrow(error);

      expect(commit).toHaveBeenCalledWith(DatasetMutationType.SET_COLLECTION);
      expect(commit).toHaveBeenCalledWith(
        DatasetMutationType.SET_COLLECTION_ERROR,
        error
      );
    });
  });

  describe(DatasetActionType.FETCH_ITEM, () => {
    it('commits SET_ITEM and SET_ITEM_SUCCESS on successful fetch', async () => {
      const dataset = datasetFactory.build();
      mockDatasetRepository.getItem.mockResolvedValue(dataset);

      await actions[DatasetActionType.FETCH_ITEM](
        {
          commit,
        } as unknown as ActionContext<IState, RootState>,
        'test-slug'
      );

      expect(commit).toHaveBeenCalledWith(DatasetMutationType.SET_ITEM);
      expect(commit).toHaveBeenCalledWith(
        DatasetMutationType.SET_ITEM_SUCCESS,
        dataset
      );
    });

    it('commits SET_ITEM and SET_ITEM_ERROR on fetch error', async () => {
      const error = new Error('Fetch failed');
      mockDatasetRepository.getItem.mockRejectedValue(error);

      await expect(
        actions[DatasetActionType.FETCH_ITEM](
          {
            commit,
          } as unknown as ActionContext<IState, RootState>,
          'test-slug'
        )
      ).rejects.toThrow(error);

      expect(commit).toHaveBeenCalledWith(DatasetMutationType.SET_ITEM);
      expect(commit).toHaveBeenCalledWith(
        DatasetMutationType.SET_ITEM_ERROR,
        error
      );
    });
  });
});
