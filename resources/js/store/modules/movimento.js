/* eslint-disable no-param-reassign */
import {
  MOVIMENTO_MARKERS_OBJECT,
  MOVIMENTO_ADD_MARKER_OBJECT,
  MOVIMENTO_ADD_MARKER_POSITION,
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
