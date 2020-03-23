<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>
    <BottomBar v-if="isMobile" @sidebarOpen="onSidebarOpen" />
    <router-view></router-view>

    <Sidebar v-if="!isMobile"  @sidebarOpen="onSidebarOpen" />
    <notifications group="foo" />
  </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect';
import Sidebar from '@components/Sidebar';
import BottomBar from '@components/BottomBar';
import { MglMap, MglPopup, MglMarker  } from "vue-mapbox";
import { mapGetters, mapActions } from 'vuex'


export default {
  name: 'app',
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
    };
  },
  created() {
    this.actionGetAllUsers()
  },
  methods: {
    ...mapActions([
      'actionGetAllUsers',
      'actionSetNewPosition'
    ]),
    onSidebarOpen(v) {
      this.sidebarOpen = v
    },
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
