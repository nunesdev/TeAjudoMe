<template>
    <div class="">
      <div class="location" v-if="!isLocated">
        <div class="popup text-center">
          <div class="row align-items-center">
            <div class="col-12">
              <a class="btn" @click="locateMe">
                <span class="icon-target"></span>
                <span v-text="$ml.get('home.map.location')"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="map">
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
              <img v-if="item.options && !item.options.document && item.type =='volunteer'" src="/images/voluntario_2.png" width="32" height="32" alt="">
              <img v-if="item.options && item.options.document" src="/images/psicologia.png" width="32" height="32" alt="">
              <img v-if="item.type && item.type == 'user'" src="/images/perfil.png" width="32" height="32" alt="">
            </div>
            <MglPopup>

              <div class="popup">
                <div class="text-center"
                v-if="item.options && !item.options.document && item.type == 'volunteer'"
                v-text="$ml.get('home.map.popup.type_volunteer')"
                >

                </div>
                <div class="text-center"
                v-if="item.options && item.options.psicologo && item.type == 'volunteer'"
                v-text="$ml.get('home.map.popup.type_doctor')"
                >
                </div>

                <div class="text-center"
                v-if="item.type && item.type == 'user'"
                v-text="$ml.get('home.map.popup.type_user')"
                >
                </div>

                <div class="popup-head row align-items-center">
                  <h3 class="col-11">{{item.name}}</h3>
                </div>
                <span v-if="item.options && item.options.psicologo && item.options.document"> {{item.options.document}} <img  src="/images/verified.png" width="16" height="16" alt=""></span>

                <h4 v-text="$ml.get('home.map.popup.talk_to')"></h4>

                <span v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
                <span v-if="item.phone"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
                <span v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>

                <div class="support"  v-if="item.options && !item.options.document">
                  <h4 v-if="item.type == 'volunteer'" v-text="$ml.get('home.map.popup.help_with')"></h4>
                  <h4 v-else v-text="$ml.get('home.map.popup.help_with_user')"></h4>

                  <div>
                    <span v-if="item.options.market">
                      <i class="icon-shopping-cart"></i>
                      <small v-text="$ml.get('home.map.popup.help.market')"></small>
                    </span>
                    <span v-if="item.options.food">
                      <i class="icon-location-food"></i>
                      <small v-text="$ml.get('home.map.popup.help.food')"></small>
                    </span>
                    <span v-if="item.options.health">
                      <i class="icon-store-front"></i>
                      <small v-text="$ml.get('home.map.popup.help.health')"></small>
                    </span>
                    <span v-if="item.options.talk">
                      <i class="icon-conversation"></i>
                      <small v-if="item.type == 'volunteer'" v-text="$ml.get('home.map.popup.help.talk')"></small>
                      <small v-else v-text="$ml.get('home.map.popup.help.talk_2')"></small>
                    </span>


                    <span v-if="item.options.dog">
                      <i class="icon-dog">
                        <svg version="1.0" viewBox="0 0 1 1" xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1.6886 0 0 1.6886 -.40426 .14628)" fill="#1e1916" stroke-miterlimit="10.433" stroke-width="0">
                        <path fill="currentColor" d="m0.675 0.44929l-0.0028993 4.1666e-4 -0.0027951 3.6458e-4 -0.002691 2.9514e-4 -0.0025694 2.2569e-4 -0.0025 1.7361e-4 -0.0023785 1.0417e-4 -0.0022916 5.208e-5h-0.0022048l-0.0021007-6.944e-5 -0.0020139-1.2153e-4 -0.0019271-1.7361e-4 -0.0018403-2.2569e-4 -0.0017708-2.9514e-4 -0.0016666-3.2986e-4 -0.0015972-3.8194e-4 -0.0015104-4.3402e-4 -0.001441-4.8611e-4 -0.0013715-5.3819e-4 -0.0012847-5.9028e-4 -0.0012326-6.2499e-4 -0.0011458-6.7708e-4 -0.0010937-7.2916e-4 -0.0010243-7.6389e-4 -9.5485e-4 -8.1596e-4 -9.0277e-4 -8.5069e-4 -8.3333e-4 -9.0278e-4 -7.8125e-4 -9.3749e-4 -7.2916e-4 -9.7222e-4 -6.7708e-4 -0.0010243-6.2499e-4 -0.001059-0.0010938-0.0022222-9.2013e-4 -0.0023611-7.4652e-4 -0.0025-6.0764e-4 -0.0026215-4.6875e-4 -0.0027604-3.2985e-4 -0.0028646-2.4306e-4 -0.0029687-1.5625e-4 -0.0030729-8.68e-5 -0.0031771-1.736e-5 -0.0032465 3.472e-5 -0.0033333 3.472e-5 -0.0034028 6.944e-5 -0.0034548 8.681e-5 -0.007118 1.736e-5 -0.0036111-0.0038021-0.080329-0.015833 0.074166c-0.0033333 0.01375-0.0070833 0.026666 0.012917 0.037083 0.014167 0.012517-0.0016666 0.0296-0.017083 0.027517-0.04625 0.0016493-0.039583-0.029166-0.035416-0.05085l0.0025-0.031666 0.0075-0.064583-0.00625-0.01625c-0.050416-0.012917-0.084583-0.0225-0.12333-0.043333l-0.0275 0.00375c-0.012917 0.0020833-0.0095833 0.016667-0.010833 0.02625l-0.0041666 0.026267-0.022917 0.059583-0.0016666 0.0049826c-0.0016667 0.0041666-0.00125 0.020417 0.0045833 0.02875l0.0125 0.025017c0.0091666 0.013733 0.011667 0.048732-0.014167 0.037482h4.1666e-4l-0.019167-0.0079166c-0.01375-0.0058159-0.025-0.043732-0.03-0.071232l8.3333e-4 -0.039184c-0.012083-0.003316-0.017083 0.06625-0.012083 0.08085l0.012083 0.036232c0.0033333 0.011667-0.010417 0.015851-0.02 0.015851-0.0225 0-0.0325-0.022934-0.037083-0.0421l-0.0033333-0.014583c-0.0058333-0.022083-0.0029166-0.055833 0.0083333-0.075416l0.0058333-0.012083c0.0095833-0.024167-0.0029166-0.04125-0.0058333-0.05375-0.0095833-0.039166-0.0175-0.077083 0.0095833-0.11458l0.0025-0.0028993c-0.00125-0.002934-0.0091666-0.0091666-0.01375-0.023767-0.010417-0.033333-0.019583-0.087916-0.0066666-0.087916l0.0087499-4.1666e-4c0.021667 0 0.015 0.089999 0.04125 0.084166l0.1875 0.0020833 0.033333-0.0091492c0.011667-0.0033507 0.022083-0.010851 0.032916-0.017517l0.021667-0.013333c0.024167 0.024583 0.045833 0.04 0.081249 0.052916 0.0095833 0.073333-0.00125 0.0896-0.010417 0.13333l-0.0033333 0.017917c-0.0070833 0.031267-0.0091666 0.06375-0.0075 0.096249l8.3332e-4 0.015c-8.3332e-4 0.015417 0.0083333 0.016684 0.020417 0.020434 0.0079166 0.0041493 0.013333 0.019566-0.0020833 0.027066h4.1666e-4 -4.1666e-4z"/>
                        <path fill="currentColor" d="m0.715 1.2913e-4l9.375e-4 6.9444e-4 9.7221e-4 6.9444e-4 0.0019618 0.0015104 0.0020312 0.0016146 0.002066 0.0017187 0.0021007 0.0018055 0.002118 0.001875 0.0021528 0.0019444 0.0021701 0.0019965 0.0021701 0.002066 0.0021701 0.0020833 0.0042882 0.0042708 0.0021007 0.0021528 0.0020833 0.0021528 0.0020312 0.0021354 0.0019792 0.0021354 0.013333 0.014149c0.0083333 0.0087499 0.02125 0.0075 0.0325 0.0099999l0.0045833 4.1666e-4c0.012083 0.006684 0.0083333 0.020017 0.0041666 0.03l-0.0025 0.0062673c-0.012083 0.028732-0.047083 0.030816-0.072083 0.017483l-0.010833-0.0058333h-0.00375l-0.0079166 5e-3 -0.015417 0.012517c-0.0325-0.014167-0.05875-0.03085-0.079583-0.05335l0.048333-0.060833 0.01625-0.023333 0.0033333-0.0079166 0.00375-0.0087326s0.015-0.018767 0.02375-0.015017c0.0087499 0.0037673 0.014167 0.02 0.012083 0.028333l-0.0025 0.0099999-8.3333e-4 0.0099999h4.1667e-4"/>
                        </g>
                        </svg>

                      </i>
                      <small v-text="$ml.get('home.map.popup.help.dog')"></small>
                    </span>
                  </div>
                  <div v-if="item.options.others">
                    <hr>
                    <p v-text="item.options.others"></p>
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
      isLocated: this.$cookies.get('isLocated') ? true : false, 
      errorStr: null,

      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/brunodevsp/ck8561s7l04me1imoc1r5jk3x',
      coordinates: [-60.943904,-10.5705057],
      zoom: 2,
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

<style lang="sass" scoped>
  .location
    position: fixed
    width: 100%
    height: 100%
    top: 0
    left: 180px
    background: rgba(255,255,255,0.8)
    z-index: 3
    @media only screen and (max-width: 600px)
      left: 0
    .popup
      border: 1px solid #dedede
      background: white
      border-radius: 4px
      position: absolute
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
      width: 210px
      color: #57ab9f
      padding: 5px 8px

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
        margin-top: 10px
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
        .icon-dog
          color: #3e5c88
          svg
            width: 16px
            height: 16px
</style>
