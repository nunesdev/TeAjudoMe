<template>
    <div class="">
      <div class="location" v-if="!isLocated">
        <div class="popup text-center">
          <img src="/images/map.png" width="80" alt="">
          <h3>Precisamos da sua localização</h3>
          <a class="btn btn-block btn-success" @click="locateMe">{{gettingLocation ? 'Carregando...' : 'Permitir'}}</a>
        </div>
      </div>

      <div class="map" v-if="isLocated">
        <div class="loading-markers" v-if="!loaded">
          carregando dados...
        </div>
        <MglMap
          :accessToken="accessToken"
          :mapStyle.sync="mapStyle"
          :center="coordinates"
          :zoom="zoom"
        >
          <MglMarker :draggable="true" @dragend="onDragEnd" :coordinates="coordinates" color="yellow">
            <div class="" slot="marker">
              <img src="/images/voce_aqui.png" width="32" height="32" alt="">
            </div>
            <MglPopup :showed="true">
              <div class="popup">
                <h3 v-text="$ml.get('home.map.marker.esta_aqui')"></h3>
                <small v-text="$ml.get('home.map.marker.drag')"></small>
              </div>
            </MglPopup>
          </MglMarker>

          <MglMarker v-for="(item, index) in markers" :key="index" :coordinates="[item.lng,item.lat]">
            <div class="" slot="marker">
              <img v-if="item.options && !item.options.document" src="/images/voluntario_2.png" width="32" height="32" alt="">
              <img v-if="item.options && item.options.document" src="/images/psicologia.png" width="32" height="32" alt="">
            </div>
            <MglPopup>

              <div class="popup">
                <div class="text-center" v-if="item.options && !item.options.document">
                  voluntário(a)
                </div>
                <div class="text-center" v-if="item.options && item.options.psicologo">
                  psicólogo(a)
                </div>

                <div class="popup-head row align-items-center">
                  <h3 class="col-11">{{item.name}}</h3>
                </div>
                <span v-if="item.options.psicologo && item.options.document"> {{item.options.document}} <img  src="/images/verified.png" width="16" height="16" alt=""></span>

                <h4>Fale comigo por</h4>

                <span v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
                <span v-if="item.phone"><a :href="`tel:${item.phone}`"> Telefone </a></span>
                <span v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=+55${item.phone}`"> WhatsApp </a></span>

                <div class="support"  v-if="item.options && !item.options.document">
                  <h4>posso ajudar com</h4>

                  <div>
                    <span v-if="item.options.market">
                      <i class="icon-shopping-cart"></i>
                      <small>Compras</small>
                    </span>
                    <span v-if="item.options.food">
                      <i class="icon-location-food"></i>
                      <small>Alimentação</small>
                    </span>
                    <span v-if="item.options.health">
                      <i class="icon-store-front"></i>
                      <small>Farmácia</small>
                    </span>
                    <span v-if="item.options.talk">
                      <i class="icon-conversation"></i>
                      <small>Conversar</small>
                    </span>
                  </div>
                </div>
              </div>
            </MglPopup>
          </MglMarker>
        </MglMap>

      </div>
    </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect';
import Sidebar from '@components/Sidebar';
import BottomBar from '@components/BottomBar';
import { MglMap, MglPopup, MglMarker  } from "vue-mapbox";
import { mapGetters, mapActions } from 'vuex'


export default {
  name: 'home',
  components: {
    MglMap,
    MglMarker,
    MglPopup,

    Sidebar,
    BottomBar
  },
  data() {
    return {
      items: [],
      loaded: false,

      isMobile: isMobile,
      sidebarOpen: false,
      location: null,
      gettingLocation: false,
      isLocated: this.$cookies.get('isLocated') ? true : true,
      errorStr: null,

      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/mapbox/streets-v11',
      coordinates: [-60.943904,-10.5705057],
      zoom: 2
    };
  },
  created() {
    if(this.$cookies.get('isLocated')) this.locateMe()
  },
  computed: {
    markers() {
      this.items = this.$store.getters.getMarkers;
      if(this.items[0]) this.loaded = true

      return this.items
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
          this.$cookies.set('isLocated', true);
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
        this.coordinates = [this.location.coords.longitude, this.location.coords.latitude];
        this.zoom = 12.5

      } catch(e) {
        this.gettingLocation = false;
        this.errorStr = e.message;
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

<style lang="sass">
  .location
    position: fixed
    width: 100%
    height: 100%
    top: 0
    left: 180px
    @media only screen and (max-width: 600px)
      left: 0
    .popup
      border: 1px solid #dedede
      border-radius: 4px
      position: absolute
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
      width: 300px
      color: #273141
      padding: 10px
      span
        font-size: 18px
  .map
    position: absolute
    top: 0
    left: 180px
    width: 100%
    height: 100%
    transition: left .2s linear
    @media only screen and (max-width: 600px)
      left: 0
      padding-top: 70px
    .loading-markers
      position: absolute
      top: 90px
      z-index: 1
      background: #ffed4a
      color: black
      padding: 5px
      left: 50%
      transform: translate(-50%)
    .popup
      color: #3e5c88
      &-head
        h3
          font-size: 22px
      hr
        margin-top: 180px
        margin-bottom: 10px
      h4
        font-size: 18px
        margin-top: 10px
      span
        display: inline-block
        background: aliceblue
        padding: 5px
      .support
        padding-top: 10px
        span
</style>
