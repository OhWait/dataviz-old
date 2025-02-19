import HydraCollection from '@/@types/hydra/collectionResponse';
import { ITheme } from './model';
import { ActionContext } from 'vuex';
import { RootState } from '@/@types/store.js';

export interface IState {
  collection: HydraCollection<ITheme> | null;
  collectionLoading: boolean;
  collectionError: Error | null;
}

export interface IGetters {
  [ThemeGetterType.GET_COLLECTION_MEMBERS](state: IState): ITheme[];
  [ThemeGetterType.GET_COLLECTION_TOTAL_ITEMS](state: IState): number;
  [ThemeGetterType.GET_COLLECTION_LOADING](state: IState): boolean;
  [ThemeGetterType.GET_COLLECTION_ERROR](state: IState): Error | null;
}

export interface IMutations<S = IState> {
  [ThemeMutationType.SET_COLLECTION](state: S): void;
  [ThemeMutationType.SET_COLLECTION_SUCCESS](
    state: S,
    data: HydraCollection<ITheme>
  ): void;
  [ThemeMutationType.SET_COLLECTION_ERROR](state: S, error: Error): void;
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
  [ThemeActionType.FETCH_COLLECTION]({
    commit,
  }: AugmentedActionContext): Promise<HydraCollection<ITheme>>;
}

export enum ThemeActionType {
  FETCH_COLLECTION = 'FETCH_COLLECTION',
}

export enum ThemeMutationType {
  SET_COLLECTION = 'SET_COLLECTION',
  SET_COLLECTION_SUCCESS = 'SET_COLLECTION_SUCCESS',
  SET_COLLECTION_ERROR = 'SET_COLLECTION_ERROR',
}

export enum ThemeGetterType {
  GET_COLLECTION_MEMBERS = 'GET_COLLECTION_MEMBERS',
  GET_COLLECTION_LOADING = 'GET_COLLECTION_LOADING',
  GET_COLLECTION_ERROR = 'GET_COLLECTION_ERROR',
  GET_COLLECTION_TOTAL_ITEMS = 'GET_COLLECTION_TOTAL_ITEMS',
}

export enum ThemeStore {
  NAMESPACE = 'theme',

  // actions
  FETCH_COLLECTION = `${NAMESPACE}/${ThemeActionType.FETCH_COLLECTION}`,

  // getters
  GET_COLLECTION_MEMBERS = `${NAMESPACE}/${ThemeGetterType.GET_COLLECTION_MEMBERS}`,
  GET_COLLECTION_TOTAL_ITEMS = `${NAMESPACE}/${ThemeGetterType.GET_COLLECTION_TOTAL_ITEMS}`,
  GET_COLLECTION_LOADING = `${NAMESPACE}/${ThemeGetterType.GET_COLLECTION_LOADING}`,
  GET_COLLECTION_ERROR = `${NAMESPACE}/${ThemeGetterType.GET_COLLECTION_ERROR}`,

  // mutations
  SET_COLLECTION = `${NAMESPACE}/${ThemeMutationType.SET_COLLECTION}`,
  SET_COLLECTION_SUCCESS = `${NAMESPACE}/${ThemeMutationType.SET_COLLECTION_SUCCESS}`,
}
