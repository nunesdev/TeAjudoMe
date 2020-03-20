import * as mutations from './mutation-types';
import axios from 'axios'


/* eslint-disable import/prefer-default-export */
/* eslint-disable no-unused-vars */

/**
 * User
 */
export const actionGetAllUsers = ({ commit }) => {
  return axios.get('/api')
    .then((result)=>{
      commit(mutations.MARKERS_OBJECT, result.data.data)
    })
};


export const actionSetNewUser = ({ commit }, obj) => {
  commit(mutations.ADD_MARKET_OBJECT, obj)
};

export const actionSetNewPosition = ({ commit }, obj) => {
  commit(mutations.ADD_MARKER_POSITION, obj)
};
