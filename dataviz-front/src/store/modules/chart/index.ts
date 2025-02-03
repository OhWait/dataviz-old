import { Module } from 'vuex/types/index.js';
import { state } from './state';
import { getters } from './getters';
import { mutations } from './mutations';
import { actions } from './actions';
import { RootState } from '@/@types/store';
import { IState } from '@/@types/chart/store';

const store: Module<IState, RootState> = {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};

export default store;
