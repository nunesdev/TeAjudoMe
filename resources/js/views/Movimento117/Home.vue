<template>
    <div class="">
      <div class="map">
        <div class="location">
          <div class="text-center">
            <a class="btn" @click="locateMe">
              <span class="icon-target"></span>
              <span v-text="$ml.get('home.map.location')"></span>
              <small v-if="!isLocated">loading...</small>
            </a>
          </div>
        </div>

        <div class="search-area" v-if="isSearchByArea">
          <div class="text-center">
            <a class="btn" @click="searchByArea">
              <span class="icon-busca"></span>
              <span v-text="$ml.get('home.map.search_area')">Pesquisar nesta área</span>
            </a>
          </div>
        </div>

        <div class="loading-markers" v-if="!loadedItems">
          carregando dados...
        </div>
        <div class="loading-markers" v-if="!loadedMap">
          carregando mapa...
        </div>

        <MglMap
          v-if="markers"
          :accessToken="accessToken"
          :mapStyle.sync="mapStyle"
          :center="coordinates"
          :zoom="zoom"
          @load="onMapLoad"
        >
        <MglNavigationControl v-if="!isMobile" :position="positionControl" />


        <MglMarker :draggable="true" @dragend="onDragEnd" :coordinates="coordinates" color="#0eca4c">

          <MglPopup :showed="true">
            <div class="popup">
              <h3 v-text="$ml.get('home.map.marker.esta_aqui')"></h3>

              <div class="" v-if="!isMobile">
                <router-link class="btn btn-active  btn-sm btn-white" to="/preciso-de-ajuda" v-text="$ml.get('menu.needup')">Preciso de ajuda</router-link>
                <router-link class="btn btn-sm btn-white" to="/posso-ajudar" v-text="$ml.get('menu.handup')">Posso ajudar</router-link>
                <router-link class="btn btn-sm btn-white" to="/negocio" v-text="$ml.get('menu.marketup')">Tenho um pequeno negócio</router-link>
              </div>

            </div>
          </MglPopup>
        </MglMarker>

          <MglMarker v-for="(item, index) in markers" :key="index" :coordinates="[item.lng,item.lat]" color="blue">
            <div class="" slot="marker">
              <img v-if="item && item.type == 'volunteer'" src="/images/movimento/coletor.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'user'" src="/images/movimento/caixa.png" width="38" height="38" alt="">
              <img v-if="item && item.type == 'store'" src="/images/movimento/abrigo.png" width="48" height="48" alt="">


            </div>
            <MarkerVolunteer v-if="item.type == 'volunteer'" :item="item"></MarkerVolunteer>
            <MarkerUser v-if="item.type == 'user'" :item="item"></MarkerUser>
            <MarkerStore v-if="item.type == 'store'" :item="item"></MarkerStore>
          </MglMarker>
        </MglMap>
      </div>
    </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect';
import Mapbox from "mapbox-gl";
import {
  MglMap, MglPopup, MglMarker, MglAttributionControl,
  MglNavigationControl,
  MglFullscreenControl,
  MglScaleControl  } from "vue-mapbox";

import MglGeocoderControl from 'vue-mapbox-geocoder'
import { mapGetters, mapActions } from 'vuex'

import Sidebar from '@components/Sidebar';
import BottomBar from '@components/BottomBar';

import MarkerVolunteer from '@components/Markers/Movimento/Volunteer';
import MarkerUser from '@components/Markers/Movimento/User';
import MarkerStore from '@components/Markers/Movimento/Store';

export default {
  name: 'home',
  components: {
    MglMap,
    MglMarker,
    MglPopup,
    MglAttributionControl,
    MglNavigationControl,

    Sidebar,
    BottomBar,

    MarkerVolunteer,
    MarkerStore,
    MarkerUser
  },
  data() {
    return {
      mapx: undefined,
      mapbox : undefined,
      loadedMap: false,
      items: [],
      loadedItems: false,
      isSearchByArea: false,
      oldZoom: false,

      isMobile: isMobile,
      sidebarOpen: false,
      location: null,
      isLocated: this.$cookies.get('_tageocord_mv') ? true : false,

      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/brunodevsp/ck8ngw7go0r6l1ipriw3gi2lk',
      coordinates: this.$cookies.get('_tageocord_mv') ? [this.$cookies.get('_tageocord_mv').lng,this.$cookies.get('_tageocord_mv').lat] : [-60.943904,-10.5705057],
      zoom: this.$cookies.get('_tageocord_mv') ? 10 : 2,
      positionControl: isMobile ? 'top-right' : 'bottom-right'
    };
  },
  created() {
    this.mapbox = Mapbox;
  },
  computed: {
    markers() {
      this.items = this.$store.getters.getMarkersMovimento;
      if(this.items) this.loadedItems = true

      return this.items
    }
  },
  methods: {
    ...mapActions([
      'actionGetAllUsersMovimento',
      'actionSetNewPositionMovimento'
    ]),
    filterType(type) {
      return this.items.filter((item) => {
        return item.type.match(type);
      });
    },
    async getLocation() {

      return new Promise((resolve, reject) => {

        if(!("geolocation" in navigator)) {
          reject(new Error('Geolocation is not available.'));
        }

        navigator.geolocation.getCurrentPosition(pos => {
          setTimeout(()=>this.isLocated = true,1000)
          this.$cookies.set('_tageocord_mv', {"lng":pos.coords.longitude,"lat":pos.coords.latitude});
          resolve(pos);
        }, err => {
          reject(err);
        });

      });
    },
    async locateMe() {
      try {

        this.location = await this.getLocation();
        this.actionSetNewPositionMovimento({
          'lng': this.location.coords.longitude,
          'lat': this.location.coords.latitude
        });
        this.map.flyTo({
          center: [this.location.coords.longitude, this.location.coords.latitude],
          zoom: 10,
          easing(t) {
            return t;
          }
        })
        this.actionGetAllUsersMovimento({
          'campaign' : 'movimento117',
          'location': {lat:this.location.coords.latitude, lng: this.location.coords.longitude},
          'distance' : this.isMobile ? 4 : 8
        })

        this.map.on('zoomend', this.onZoomOut)

        this.loadedMap = true
      } catch(e) {
        console.error(e);
      }
    },
    onSidebarOpen(v) {
      this.sidebarOpen = v
    },
    onDragEnd(v) {
      var lngLat = v.marker.getLngLat();
      this.coordinates = [lngLat.lng,lngLat.lat]

      this.actionSetNewPositionMovimento({
        'lng': lngLat.lng,
        'lat': lngLat.lat
      });
    },
    onZoomOut(e) {
      this.isSearchByArea = true
    },
    onMapLoad(event) {
      this.map = event.map
      this.locateMe()
    },
    searchByArea() {
      const distance = this.distance(this.map.getCenter().lat,this.map.getCenter().lng,this.location.coords.latitude, this.location.coords.longitude)
      this.actionGetAllUsersMovimento({
        'campaign' : 'movimento117',
        'location': {lat: this.map.getCenter().lat,lng: this.map.getCenter().lng},
        'distance' : this.isMobile ? (distance*6) : (distance*3)
      })
      this.isSearchByArea = false
    },
    distance(lat1,lon1,lat2,lon2) {
    	var R = 6371; // km (change this constant to get miles)
    	var dLat = (lat2-lat1) * Math.PI / 180;
    	var dLon = (lon2-lon1) * Math.PI / 180;
    	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    		Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) *
    		Math.sin(dLon/2) * Math.sin(dLon/2);
    	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    	var d = R * c;
    	if (d>1) return Math.round(d);
    	return d;
    }
  }
}
</script>

<style lang="sass" scoped>

</style>
