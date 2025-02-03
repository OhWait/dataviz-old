import { RootState } from '../store';
import HydraCollection from '../hydra/collectionResponse';
import { IDataset, IDatasetCollection } from './model';
import { ActionContext } from 'vuex';

export interface IState {
  collection: HydraCollection<IDatasetCollection> | null;
  collectionLoading: boolean;
  collectionError: Error | null;
  item: IDataset | null;
  itemLoading: boolean;
  itemError: Error | null;
}

export interface IGetters {
  [DatasetGetterType.GET_COLLECTION_MEMBERS](
    state: IState
  ): IDatasetCollection[];
  [DatasetGetterType.GET_COLLECTION_TOTAL_ITEMS](state: IState): number;
  [DatasetGetterType.GET_COLLECTION_LOADING](state: IState): boolean;
  [DatasetGetterType.GET_COLLECTION_ERROR](state: IState): Error | null;
  [DatasetGetterType.GET_ITEM](state: IState): IDataset | null;
  [DatasetGetterType.GET_ITEM_LOADING](state: IState): boolean;
  [DatasetGetterType.GET_ITEM_ERROR](state: IState): Error | null;
}

export interface IMutations<S = IState> {
  [DatasetMutationType.SET_COLLECTION](state: S): void;
  [DatasetMutationType.SET_COLLECTION_SUCCESS](
    state: S,
    data: HydraCollection<IDatasetCollection>
  ): void;
  [DatasetMutationType.SET_COLLECTION_ERROR](state: S, error: Error): void;
  [DatasetMutationType.SET_ITEM](state: S): void;
  [DatasetMutationType.SET_ITEM_SUCCESS](state: S, item: IDataset): void;
  [DatasetMutationType.SET_ITEM_ERROR](state: S, error: Error): void;
}

export type AugmentedActionContext = Omit<
  ActionContext<IState, RootState>,
  'commit'
> & {
  commit<K extends keyof IMutations>(
    key: K,
    payload?: Parameters<IMutations[K]>[1]
  ): ReturnType<IMutations[K]>;
};

export interface IActions {
  [DatasetActionType.FETCH_COLLECTION](
    { commit }: AugmentedActionContext,
    payload: { themes?: string[]; dataProvider?: boolean } | undefined
  ): Promise<HydraCollection<IDatasetCollection>>;

  [DatasetActionType.FETCH_ITEM](
    { commit }: AugmentedActionContext,
    slug: string
  ): Promise<IDataset>;
}

export enum DatasetActionType {
  FETCH_COLLECTION = 'FETCH_COLLECTION',
  FETCH_ITEM = 'FETCH_ITEM',
}

export enum DatasetMutationType {
  SET_COLLECTION = 'SET_COLLECTION',
  SET_COLLECTION_SUCCESS = 'SET_COLLECTION_SUCCESS',
  SET_COLLECTION_ERROR = 'SET_COLLECTION_ERROR',
  SET_ITEM = 'SET_ITEM',
  SET_ITEM_SUCCESS = 'SET_ITEM_SUCCESS',
  SET_ITEM_ERROR = 'SET_ITEM_ERROR',
}

export enum DatasetGetterType {
  GET_COLLECTION_MEMBERS = 'GET_COLLECTION_MEMBERS',
  GET_COLLECTION_LOADING = 'GET_COLLECTION_LOADING',
  GET_COLLECTION_ERROR = 'GET_COLLECTION_ERROR',
  GET_COLLECTION_TOTAL_ITEMS = 'GET_COLLECTION_TOTAL_ITEMS',
  GET_ITEM = 'GET_ITEM',
  HAS_ITEM = 'HAS_ITEM',
  GET_ITEM_LOADING = 'GET_ITEM_LOADING',
  GET_ITEM_ERROR = 'GET_ITEM_ERROR',
}

export enum DatasetStore {
  NAMESPACE = 'dataset',

  // actions
  FETCH_COLLECTION = `${NAMESPACE}/${DatasetActionType.FETCH_COLLECTION}`,
  FETCH_ITEM = `${NAMESPACE}/${DatasetActionType.FETCH_ITEM}`,

  // getters
  GET_COLLECTION_MEMBERS = `${NAMESPACE}/${DatasetGetterType.GET_COLLECTION_MEMBERS}`,
  GET_COLLECTION_TOTAL_ITEMS = `${NAMESPACE}/${DatasetGetterType.GET_COLLECTION_TOTAL_ITEMS}`,
  GET_COLLECTION_LOADING = `${NAMESPACE}/${DatasetGetterType.GET_COLLECTION_LOADING}`,
  GET_COLLECTION_ERROR = `${NAMESPACE}/${DatasetGetterType.GET_COLLECTION_ERROR}`,
  GET_ITEM = `${NAMESPACE}/${DatasetGetterType.GET_ITEM}`,
  HAS_ITEM = `${NAMESPACE}/${DatasetGetterType.HAS_ITEM}`,
  GET_ITEM_LOADING = `${NAMESPACE}/${DatasetGetterType.GET_ITEM_LOADING}`,
  GET_ITEM_ERROR = `${NAMESPACE}/${DatasetGetterType.GET_ITEM_ERROR}`,

  // mutations
  SET_COLLECTION = `${NAMESPACE}/${DatasetMutationType.SET_COLLECTION}`,
  SET_COLLECTION_SUCCESS = `${NAMESPACE}/${DatasetMutationType.SET_COLLECTION_SUCCESS}`,
  SET_ITEM = `${NAMESPACE}/${DatasetMutationType.SET_ITEM}`,
  SET_ITEM_SUCCESS = `${NAMESPACE}/${DatasetMutationType.SET_ITEM_SUCCESS}`,
}
