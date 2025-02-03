import { RootState } from '../store';
import {
  AnonymousMember,
  HydraAnonymousCollection,
} from '../hydra/collectionResponse';
import { ActionContext } from 'vuex';

export interface IState {
  collection: HydraAnonymousCollection | null;
  collectionLoading: boolean;
  collectionError: Error | null;
}

export interface IGetters {
  [DataEntryGetterType.GET_TABLE_MEMBERS](state: IState): AnonymousMember[];
  [DataEntryGetterType.GET_TABLE_TOTAL_ITEMS](state: IState): number;
  [DataEntryGetterType.GET_TABLE_LOADING](state: IState): boolean;
  [DataEntryGetterType.GET_TABLE_ERROR](state: IState): Error | null;
}

export interface IMutations<S = IState> {
  [DataEntryMutationType.SET_TABLE](state: S): void;
  [DataEntryMutationType.SET_TABLE_SUCCESS](
    state: S,
    data: HydraAnonymousCollection
  ): void;
  [DataEntryMutationType.SET_TABLE_ERROR](state: S, error: Error): void;
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
  [DataEntryActionType.FETCH_TABLE](
    { commit }: AugmentedActionContext,
    payload: { slug: string; page: number; itemsPerPage: number }
  ): Promise<HydraAnonymousCollection>;
}

export enum DataEntryActionType {
  FETCH_TABLE = 'FETCH_TABLE',
}

export enum DataEntryMutationType {
  SET_TABLE = 'SET_TABLE',
  SET_TABLE_SUCCESS = 'SET_TABLE_SUCCESS',
  SET_TABLE_ERROR = 'SET_TABLE_ERROR',
}

export enum DataEntryGetterType {
  GET_TABLE_MEMBERS = 'GET_TABLE_MEMBERS',
  GET_TABLE_LOADING = 'GET_TABLE_LOADING',
  GET_TABLE_ERROR = 'GET_TABLE_ERROR',
  GET_TABLE_TOTAL_ITEMS = 'GET_TABLE_TOTAL_ITEMS',
}

export enum DataEntryStore {
  NAMESPACE = 'dataEntry',

  // actions
  FETCH_TABLE = `${NAMESPACE}/${DataEntryActionType.FETCH_TABLE}`,

  // getters
  GET_TABLE_MEMBERS = `${NAMESPACE}/${DataEntryGetterType.GET_TABLE_MEMBERS}`,
  GET_TABLE_TOTAL_ITEMS = `${NAMESPACE}/${DataEntryGetterType.GET_TABLE_TOTAL_ITEMS}`,
  GET_TABLE_LOADING = `${NAMESPACE}/${DataEntryGetterType.GET_TABLE_LOADING}`,
  GET_TABLE_ERROR = `${NAMESPACE}/${DataEntryGetterType.GET_TABLE_ERROR}`,
}
