import { RootState } from '@/@types/store.js';
import { InjectionKey } from 'vue';
import { createStore, useStore as baseUseStore, Store } from 'vuex';
import theme from './modules/theme';
import chart from './modules/chart';

export const key: InjectionKey<Store<RootState>> = Symbol();

export const store = createStore<RootState>({
  modules: {
    theme,
    chart,
  },
});

export function useStore() {
  return baseUseStore(key);
}
