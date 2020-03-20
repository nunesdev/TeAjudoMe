<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>
    <Sidebar @sidebarOpen="onSidebarOpen" />
    <notifications group="foo" />
    <div class="map">
        <div class="row">
          <div class="col-12">
            <table class="table" v-for="(item, index) in getMarkers" :key="index">
              <tbody>
                <tr>
                  <td>
                    {{item.name}}
                  </td>
                  <td>
                    {{item.email}}
                  </td>
                  <td>
                    {{item.phone}}
                  </td>
                  <td>
                    {{item.email}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

    </div>
  </div>
</template>
<script>
import Sidebar from '@components/Sidebar';
import { MglMap, MglPopup, MglMarker  } from "vue-mapbox";
import { mapGetters, mapActions } from 'vuex'


export default {
  components: {
    MglMap,
    MglMarker,
    MglPopup,

    Sidebar
  },
  data() {
    return {
      sidebarOpen: true,
      location: null,
      gettingLocation: false,
      errorStr: null,

      accessToken: 'pk.eyJ1IjoiYnJ1bm9kZXZzcCIsImEiOiJjazd6NzBocmwwMnQ5M2xvcWg0YmxqNmZpIn0.rfIgqe3-QTrf16tIVgjgjg',
      mapStyle: 'mapbox://styles/mapbox/streets-v11',
      coordinates: [0,0],
      zoom: 12.5
    };
  },
  created() {
    this.locateMe();
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
    ]),

    async getLocation() {

      return new Promise((resolve, reject) => {

        if(!("geolocation" in navigator)) {
          reject(new Error('Geolocation is not available.'));
        }

        navigator.geolocation.getCurrentPosition(pos => {
          console.log(pos);
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
    }
  }
}
</script>

<style lang="sass">
  .map
    position: absolute
    top: 0
    left: 180px
    width: 100%
    height: 100%
    transition: left .2s linear
    color: #000
    .popup
      color: #3e5c88
      span
        display: block
        background: aliceblue
      .support
        span
          background: none
</style>
