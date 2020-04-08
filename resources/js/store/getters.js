/* eslint-disable import/prefer-default-export */

/**
 * Users
 */
export const getMarkers = state => state.markers.allUsers
export const getTotalMarkers = state => state.markers.totalUsers
export const getMarkerPosition = state => state.markers.markerPosition

export const getFilter = state => (type) => {
   const items =  state.markers.allUsers.filter((item)=>{
    return item.type.match(type);
  })

  state.markers.allUsers = items;

  return items;
}


/**
 * Movimento
 */
export const getMarkersMovimento = state => state.movimento.allUsers
export const getMarkerPositionMovimento = state => state.movimento.markerPosition
export const getTotalMarkersMovimento = state => state.movimento.totalUsers
