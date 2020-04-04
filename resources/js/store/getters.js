/* eslint-disable import/prefer-default-export */

/**
 * Users
 */
export const getMarkers = state => state.markers.allUsers
export const getMarkerPosition = state => state.markers.markerPosition

export const getFilter = state => (type) => {
   const items =  state.markers.allUsers.filter((item)=>{
    return item.type.match(type);
  })

  state.markers.allUsers = items;

  return items;
}
