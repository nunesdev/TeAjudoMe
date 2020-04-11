<template>
    <div class="">

      <div class="map">

        <modal class="select-campaign" height="auto" :adaptive="true" name="select-campaign">
          <div class="modal-header">
            <h3>Selecione a campanha</h3>
          </div>
          <div class="modal-body">
            <div class="row ">
              <div class="col-12 pb pt select-campaign-item">
                <div class="row no-gutters">
                    <div class="col-3">
                      <img v-if="!isMobile" src="/images/movimento/user.png" width="92" height="92" alt="">
                      <img v-if="isMobile" src="/images/movimento/user.png" width="52" height="52" alt="">
                    </div>
                    <div class="col-9">
                      <h4>Movimento 117 - #AmorEmMovimento</h4>
                      <button class="btn btn-info" @click="hide()">Continuar nesse mapa</button>
                    </div>
                </div>
              </div>
              <div class="col-12 pb pt select-campaign-item">
                <div class="row no-gutters">
                    <div class="col-3">
                      <img v-if="!isMobile" src="/images/teajudome.png" width="92" height="92" alt="">
                      <img v-if="isMobile" src="/images/teajudome.png" width="52" height="52" alt="">
                    </div>
                    <div class="col-9">
                      <h4>TeAjudo - Pequenos Negócios</h4>
                      <router-link class="btn btn-active btn-info" to="/">Ir para o mapa</router-link >
                    </div>
                </div>

              </div>

            </div>
          </div>
        </modal>

        <div class="location">
          <div class="text-center">
            <a class="btn" @click="locateMe">
              <span class="icon-target"></span>
              <span v-if="!isMobile" v-text="$ml.get('home.map.location')"></span>
              <small v-if="!isLocated">loading...</small>
            </a>
          </div>
        </div>

        <div class="search-area" v-if="isSearchByArea">
          <div class="text-center">
            <a class="btn" @click="searchByArea">
              <span class="icon-busca"></span>
              <span  v-if="!isMobile" v-text="$ml.get('home.map.search_area')">Pesquisar nesta área</span>
            </a>
          </div>
        </div>

        <div class="loading-markers" v-if="!loadedItems">carregando dados...</div>
        <div class="loading-markers" v-if="!loadedMap">carregando mapa...</div>

        <MglMap
          v-if="markers"
          :accessToken="accessToken"
          :mapStyle.sync="mapStyle"
          :center="coordinates"
          :zoom="zoom"
          @load="onMapLoad"
        >
        <MglNavigationControl v-if="!isMobile" :position="positionControl" />
        <MglMarker :draggable="true" @dragend="onDragEnd" :coordinates="coordinates">
          <MglPopup :showed="true">
            <div class="popup">
              <h4>Você está aqui</h4>
              <div class="" v-if="!isMobile">
                <router-link class="btn btn-active btn-sm btn-white" to="/movimento117/quero-doar">Quero doar</router-link>
                <router-link class="btn btn-sm btn-white" to="/movimento117/voluntario">Quero ser um voluntário</router-link>
              </div>
            </div>
          </MglPopup>
        </MglMarker>

          <MglMarker v-for="(item, index) in markers" :key="index" :coordinates="[item.lng,item.lat]" color="blue">
            <div class="" slot="marker">
              <img v-if="item && item.type == 'volunteer' && !item.options.blood && !item.options.regional" src="/images/movimento/user.png" width="36" height="36" alt="">
              <img v-if="item && item.type == 'volunteer' && item.options.blood && !item.options.regional" src="/images/movimento/user_blood.png" width="36" height="36" alt="">
              <img v-if="item && item.type == 'volunteer' && item.options.regional && !item.options.blood" src="/images/movimento/user_regional.png" width="36" height="36" alt="">

              <img v-if="item && item.type == 'user' && !item.options.money" src="/images/movimento/caixa.png" width="38" height="38" alt="">
              <img v-if="item && item.type == 'user' && item.options.money" src="/images/movimento/doacao_money.png" width="38" height="38" alt="">

              <img v-if="item && item.type == 'store' && !item.options.blood" src="/images/movimento/abrigo.png" width="48" height="48" alt="">
              <img v-if="item && item.type == 'store' && item.options.blood" src="/images/movimento/sangue.png" width="48" height="48" alt="">


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

import MarkerVolunteer from '@components/Movimento/Markers/Volunteer';
import MarkerUser from '@components/Movimento/Markers/User';
import MarkerStore from '@components/Movimento/Markers/Store';

export default {
  name: 'home',
  components: {
    MglMap,
    MglMarker,
    MglPopup,
    MglAttributionControl,
    MglNavigationControl,
    MarkerVolunteer,
    MarkerStore,
    MarkerUser,
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
          'distance' : this.isMobile ? 100 : 120
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
        'distance' : this.isMobile ? (distance*60) : (distance*50)
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
    },
    show () {
      this.$modal.show('select-campaign');
    },
    hide () {
      this.$modal.hide('select-campaign');
    },
  }
}
</script>

<style lang="scss" scoped>
  .btn {
    &.btn-active {
      background: #264463;
    }
  }
</style>
