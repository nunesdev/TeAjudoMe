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
