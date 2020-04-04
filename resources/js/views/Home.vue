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

        <div class="loading-markers" v-if="!loaded">
          carregando dados...
        </div>
        <MglMap
          v-if="markers"
          :accessToken="accessToken"
          :mapStyle.sync="mapStyle"
          :center="coordinates"
          :zoom="zoom"
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
              <img v-if="item && item.type == 'volunteer' && item.options && !item.options.psicologo" src="/images/voluntario.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'volunteer' && item.options && item.options.psicologo" src="/images/psicologia.png" width="32" height="32" alt="">

              <img v-if="item && item.type == 'user'" src="/images/perfil.png" width="32" height="32" alt="">

              <img v-if="item && item.type == 'store' && item.options && item.options.market" src="/images/supermercado.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'store' && item.options && item.options.food" src="/images/comercio.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'store' && item.options && item.options.health" src="/images/farmacia.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'store' && item.options && item.options.market_garden" src="/images/feira.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'store' && item.options && item.options.mechanical" src="/images/carro.png" width="32" height="32" alt="">
              <img v-if="item && item.type == 'store' && item.options && item.options.others" src="/images/comercio.png" width="32" height="32" alt="">
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

import MarkerVolunteer from '@components/Markers/Volunteer';
import MarkerUser from '@components/Markers/User';
import MarkerStore from '@components/Markers/Store';

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
      items: [],
      loaded: false,

      isMobile: isMobile,
      sidebarOpen: false,
      location: null,
      isLocated: this.$cookies.get('_tageocord') ? true : false,

      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/brunodevsp/ck8561s7l04me1imoc1r5jk3x',
      coordinates: this.$cookies.get('_tageocord') ? [this.$cookies.get('_tageocord').lng,this.$cookies.get('_tageocord').lat] : [-60.943904,-10.5705057],
      zoom: this.$cookies.get('_tageocord') ? 14.95 : 2,
      positionControl: isMobile ? 'top-right' : 'bottom-right'
    };
  },
  created() {
    this.locateMe()
    this.mapbox = Mapbox;
  },
  computed: {
    markers() {
      this.items = this.$store.getters.getMarkers;
      if(this.items) this.loaded = true

      return this.items
    }
  },
  methods: {
    ...mapActions([
      'actionGetAllUsers',
      'actionSetNewPosition'
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
          this.$cookies.set('_tageocord', {"lng":pos.coords.longitude,"lat":pos.coords.latitude});
          resolve(pos);
        }, err => {
          reject(err);
        });

      });
    },
    async locateMe() {
      console.log('a');
      try {

        this.location = await this.getLocation();

        this.actionSetNewPosition({
          'lng': this.location.coords.longitude,
          'lat': this.location.coords.latitude
        });

        this.coordinates = [this.location.coords.longitude, this.location.coords.latitude];

        setTimeout(()=>this.zoom = 14.95, 2000)

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

      this.actionSetNewPosition({
        'lng': lngLat.lng,
        'lat': lngLat.lat
      });
    }
  }
}
</script>

<style lang="sass" scoped>

</style>
