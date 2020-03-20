/* eslint-disable no-param-reassign */
import {
  MARKERS_OBJECT,
  ADD_MARKET_OBJECT,
  ADD_MARKER_POSITION,
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
  }
};

const state = {
  allUsers: [],
  markerPosition: [],
};

export default {
  state,
  mutations,
};
