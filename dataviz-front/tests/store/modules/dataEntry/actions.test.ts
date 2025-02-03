import { actions } from '@/store/modules/dataEntry/actions';
import { ActionContext } from 'vuex';
import {
  DataEntryActionType,
  DataEntryMutationType,
  IState,
} from '@/@types/dataEntry';
import { HydraAnonymousCollection } from '@/@types/hydra/collectionResponse';
import { RootState } from '@/@types/store';
import { Mock, Mocked } from 'vitest';
import { dataEntryRepository } from '@/api/dataviz/dataEntryRepository';

vi.mock('@/api/dataviz/dataEntryRepository', () => ({
  dataEntryRepository: {
    getTable: vi.fn(),
  },
}));

const mockDataEntryRepository = dataEntryRepository as Mocked<
  typeof dataEntryRepository
>;

describe('dataEntry actions', () => {
  let commit: Mock;

  beforeEach(() => {
    commit = vi.fn();
  });

  describe(DataEntryActionType.FETCH_TABLE, () => {
    it('commits SET_TABLE and SET_TABLE_SUCCESS on successful fetch', async () => {
      const payload = { slug: 'test-slug', page: 1, itemsPerPage: 10 };
      const collectionResponse: HydraAnonymousCollection = {
        'hydra:member': [],
        'hydra:totalItems': 0,
      };
      mockDataEntryRepository.getTable.mockResolvedValue(collectionResponse);

      await actions[DataEntryActionType.FETCH_TABLE](
        {
          commit,
        } as unknown as ActionContext<IState, RootState>,
        payload
      );

      expect(commit).toHaveBeenCalledWith(DataEntryMutationType.SET_TABLE);
      expect(commit).toHaveBeenCalledWith(
        DataEntryMutationType.SET_TABLE_SUCCESS,
        collectionResponse
      );
    });

    it('commits SET_TABLE and SET_TABLE_ERROR on fetch error', async () => {
      const payload = { slug: 'test-slug', page: 1, itemsPerPage: 10 };
      const error = new Error('Fetch failed');
      mockDataEntryRepository.getTable.mockRejectedValue(error);

      await expect(
        actions[DataEntryActionType.FETCH_TABLE](
          {
            commit,
          } as unknown as ActionContext<IState, RootState>,
          payload
        )
      ).rejects.toThrow(error);

      expect(commit).toHaveBeenCalledWith(DataEntryMutationType.SET_TABLE);
      expect(commit).toHaveBeenCalledWith(
        DataEntryMutationType.SET_TABLE_ERROR,
        error
      );
    });
  });
});
