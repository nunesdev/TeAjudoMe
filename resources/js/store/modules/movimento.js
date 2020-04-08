/* eslint-disable no-param-reassign */
import {
  MOVIMENTO_MARKERS_OBJECT,
  MOVIMENTO_ADD_MARKER_OBJECT,
  MOVIMENTO_ADD_MARKER_POSITION,
  MOVIMENTO_ADD_MARKER_TOTAL,
  MOVIMENTO_MARKERS_TOTAL,
} from '../mutation-types';

const mutations = {
  [MOVIMENTO_MARKERS_OBJECT](state, data) {
    state.allUsers = data
  },
  [MOVIMENTO_ADD_MARKER_OBJECT](state,data) {
    state.allUsers = state.allUsers.concat(data)
  },
  [MOVIMENTO_ADD_MARKER_POSITION](state,data) {
    state.markerPosition = data
  },
  [MOVIMENTO_MARKERS_TOTAL](state,data) {
    state.totalUsers = data
  },
  [MOVIMENTO_ADD_MARKER_TOTAL](state,data) {
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
