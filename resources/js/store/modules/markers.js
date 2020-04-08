/* eslint-disable no-param-reassign */
import {
  MARKERS_OBJECT,
  ADD_MARKET_OBJECT,
  ADD_MARKER_POSITION,
  MARKERS_TOTAL,
  ADD_MARKERS_TOTAL,
} from '../mutation-types';

const mutations = {
  [MARKERS_OBJECT](state, data) {
    state.allUsers = data
  },
  [ADD_MARKET_OBJECT](state,data) {
    state.allUsers = state.allUsers.concat(data)
  },
  [ADD_MARKER_POSITION](state,data) {
    state.markerPosition = data
  },
  [MARKERS_TOTAL](state,data) {
    state.totalUsers = data
  },
  [ADD_MARKERS_TOTAL](state,data) {
    state.totalUsers = (state.totalUsers+1)
  }
};

const state = {
  totalUsers: 0,
  allUsers: [],
  markerPosition: [],
};

export default {
  state,
  mutations,
};
