import * as mutations from './mutation-types';
import axios from 'axios'


/* eslint-disable import/prefer-default-export */
/* eslint-disable no-unused-vars */

/**
 * User
 */
export const actionGetAllUsers = ({ commit }, obj) => {
  return axios.get('/api', {
    params:{
      lat: obj.location.lat,
      lng: obj.location.lng,
      distance: obj.distance
    }
  })
  .then((result)=>{
    commit(mutations.MARKERS_OBJECT, result.data.data)
    commit(mutations.MARKERS_TOTAL, result.data.total)
  })
};


export const actionSetNewUser = ({ commit }, obj) => {
  commit(mutations.ADD_MARKET_OBJECT, obj)
  commit(mutations.ADD_MARKERS_TOTAL, 1)
};

export const actionSetNewPosition = ({ commit }, obj) => {
  commit(mutations.ADD_MARKER_POSITION, obj)
};


/**
 * Movimento117
 */
export const actionGetAllUsersMovimento = ({ commit }, obj) => {
  return axios.get('/api/campaign/?campaign='+obj.campaign, {
    params:{
      lat: obj.location.lat,
      lng: obj.location.lng,
      distance: obj.distance
    }
  })
  .then((result)=>{
    commit(mutations.MOVIMENTO_MARKERS_OBJECT, result.data.data)
    commit(mutations.MOVIMENTO_MARKERS_TOTAL, result.data.total)
  })
};


export const actionSetNewUserMovimento = ({ commit }, obj) => {
  commit(mutations.MOVIMENTO_ADD_MARKER_OBJECT, obj)
};

export const actionSetNewPositionMovimento = ({ commit }, obj) => {
  commit(mutations.MOVIMENTO_ADD_MARKER_POSITION, obj)
};
