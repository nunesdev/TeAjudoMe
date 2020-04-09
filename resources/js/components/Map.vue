<template >
  <div class="map-inner">
    <div class="location">
      <div class="text-center">
        <a class="btn" @click="locateMe">
          <span class="icon-target"></span>
          <span v-text="$ml.get('home.map.location')"></span>
        </a>
      </div>
    </div>
    <MglMap
      :accessToken="accessToken"
      :mapStyle.sync="mapStyle"
      :center="coordinates"
      :zoom="zoom"
    >

    <!-- <MglGeocoderControl
      :accessToken="accessToken"
      :input.sync="defaultInput"
      @result="handleResult"
    /> -->
    <MglNavigationControl position="top-right" />
    <!-- <MglGeolocateControl position="bottom-right" /> -->


    <MglMarker :draggable="true" @dragend="onDragEnd" :coordinates="coordinates" color="#0eca4c">

      <MglPopup :showed="true">
        <div class="popup">
          <h3 v-text="$ml.get('home.map.marker.esta_aqui')"></h3>
          <div class="dragme">
            <small v-text="$ml.get('home.map.marker.drag')"></small>
          </div>
        </div>
      </MglPopup>
    </MglMarker>
  </MglMap>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';
import Mapbox from "mapbox-gl";
import {
  MglMap, MglPopup, MglMarker, MglAttributionControl,
  MglNavigationControl,
  MglGeolocateControl,
  MglFullscreenControl,
  MglScaleControl  } from "vue-mapbox";

import MglGeocoderControl from 'vue-mapbox-geocoder'
import { mapGetters, mapActions } from 'vuex'

export default {
  props:['input'],
  name: 'Map',
  components: {
    MglMap,
    MglMarker,
    MglPopup,
    MglAttributionControl,
    MglNavigationControl,
    MglGeolocateControl,
    MglGeocoderControl,
  },
  created() {
    this.locateMe()

    this.mapbox = Mapbox;
    this.mapboxgeocoder = MglGeocoderControl
  },
  data() {
    return {
      defaultInput: this.input,
      mapbox: undefined,
      mapboxgeocoder: undefined,
      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/brunodevsp/ck8ngw7go0r6l1ipriw3gi2lk',
      coordinates: this.$cookies.get('_tageocord') ? [this.$cookies.get('_tageocord').lng, this.$cookies.get('_tageocord').lat] : [-60.943904,-10.5705057],
      zoom: this.$cookies.get('_tageocord') ? 10 : 2,
    }
  },
  methods: {
    ...mapActions([
      'actionGetAllUsers',
      'actionSetNewPosition'
    ]),
    async getLocation() {

      return new Promise((resolve, reject) => {

        if(!("geolocation" in navigator)) {
          reject(new Error('Geolocation is not available.'));
        }

        navigator.geolocation.getCurrentPosition(pos => {
          this.isLocated = true
          this.$cookies.set('isLocated', {"lng":pos.coords.longitude,"lat":pos.coords.latitude});
          resolve(pos);
        }, err => {
          reject(err);
        });

      });
    },
    async locateMe() {

      this.gettingLocation = true;
      try {

        this.gettingLocation = false;
        this.location = await this.getLocation();

        this.actionSetNewPosition({
          'lng': this.location.coords.longitude,
          'lat': this.location.coords.latitude
        });

        this.$emit('onDragEnd', true)

        this.coordinates = [this.location.coords.longitude, this.location.coords.latitude];
        this.zoom = 13

      } catch(e) {
        this.gettingLocation = false;
        this.errorStr = e.message;
      }
    },
    handleResult(v) {
      console.log(v);
    },
    handleSearch(v) {

    },
    onSidebarOpen(v) {
      this.sidebarOpen = v
    },
    onDragEnd(v) {
      var lngLat = v.marker.getLngLat();
      this.coordinates = [lngLat.lng,lngLat.lat]

      this.actionSetNewPosition({
        'lng': lngLat.lng,
        'lat': lngLat.lat
      });

      this.$emit('onDragEnd', v)
    }
  }
}
</script>

<style lang="sass">
  .map-inner
    position: absolute
    width: 100%
    height: 100%
</style>
