import createPersistedState from 'vuex-persistedstate';

import markers from './modules/markers';
import movimento from './modules/movimento';

import * as actions from './actions';
import * as getters from './getters';

export default {
  actions,
  getters,
  modules: {
    markers,
    movimento
  },

  //plugins: [createPersistedState()],
};
