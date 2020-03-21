<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>
    <Sidebar v-if="!isMobile"  @sidebarOpen="onSidebarOpen" />
    <notifications group="foo" />

    <div class="location" v-if="!isLocated">
      <div class="popup text-center">
        <img src="/images/map.png" width="80" alt="">
        <h3>Precisamos da sua localização</h3>
        <a class="btn btn-block btn-success" @click="locateMe">{{gettingLocation ? 'Carregando...' : 'Permitir'}}</a>
      </div>
    </div>

    <div class="map" v-if="isLocated">
      <MglMap
        :accessToken="accessToken"
        :mapStyle.sync="mapStyle"
        :center="coordinates"
        :zoom="zoom"
      >
        <MglMarker :draggable="true" @dragend="onDragEnd" :coordinates="coordinates" color="yellow">
          <MglPopup :showed="true">
            <div class="popup">
              <h3>Você está aqui</h3>
              <small>Se necessário, mova o pin para outro ponto!</small>

            </div>
          </MglPopup>
        </MglMarker>

        <MglMarker v-for="(item, index) in getMarkers" :key="index" :coordinates="[item.lng,item.lat]">
          <MglPopup>
            <div class="popup">
              <h3>{{item.name}}</h3>
              <h4>Você pode falar comigo por</h4>
              <span v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
              <span v-if="item.phone"><a :href="`tel:${item.phone}`"> Telefone </a>

                <span v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=+55${item.phone}`"> WhatsApp </a></span>
              </span>


              <div class="support"  v-if="item.options">
                <h4>posso ajudar com</h4>

                <div class="row">
                  <div class="col-6" v-if="item.options.market">
                    <span class="icon-shopping-cart"></span>
                    <small>Compras</small>
                  </div>
                  <div class="col-6" v-if="item.options.food">
                    <span class="icon-location-food"></span>
                    <small>Alimentação</small>
                  </div>
                  <div class="col-6" v-if="item.options.health">
                    <span class="icon-store-front"></span>
                    <small>Farmácia</small>
                  </div>
                  <div class="col-6" v-if="item.options.talk">
                    <span class="icon-conversation"></span>
                    <small>Conversar</small>
                  </div>
                </div>
              </div>
            </div>
          </MglPopup>
        </MglMarker>
      </MglMap>

    </div>

    <BottomBar v-if="isMobile" @sidebarOpen="onSidebarOpen" />
  </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect';
import Sidebar from '@components/Sidebar';
import BottomBar from '@components/BottomBar';
import { MglMap, MglPopup, MglMarker  } from "vue-mapbox";
import { mapGetters, mapActions } from 'vuex'


export default {
  components: {
    MglMap,
    MglMarker,
    MglPopup,

    Sidebar,
    BottomBar
  },
  data() {
    return {
      isMobile: isMobile,
      sidebarOpen: false,
      location: null,
      gettingLocation: false,
      isLocated: this.$cookies.get('isLocated') ? true : false,
      errorStr: null,

      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/mapbox/streets-v11',
      coordinates: [-46.6966505,-23.6129114],
      zoom: 12.5
    };
  },
  created() {
    if(this.$cookies.get('isLocated')) this.locateMe()  
    this.actionGetAllUsers()
  },
  computed: {
    ...mapGetters([
      'getMarkers',
    ]),
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

    .popup
      color: #3e5c88
      h4
        font-size: 18px
      span
        display: block
        background: aliceblue
      .support
        padding-top: 10px
        span
          background: none
</style>
