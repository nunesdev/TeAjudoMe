<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>

    <div class="start" v-if="!startStep">
      <StartStep @onFinishStep="setStartStep"></StartStep>
    </div>

    <div class="" v-if="startStep">

      <SidebarMobile v-if="isMobile" />

      <BottomBar v-if="isMobile"/>
      <router-view></router-view>

      <Sidebar v-if="!isMobile"/>
      <notifications group="foo" />
    </div>
  </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect'
import Sidebar from '@components/Movimento/Sidebar'
import BottomBar from '@components/Movimento/BottomBar'
import SidebarMobile from '@components/Movimento/SidebarMobile'
import StartStep from '@components/Movimento/StartStep'



export default {
  name: 'Movimento117',
  components: {
    Sidebar,
    SidebarMobile,
    BottomBar,
    StartStep
  },
  data() {
    return {
      isMobile: isMobile,
      sidebarOpen: false,
      startStep: this.$cookies.get('_tastartstep') || !isMobile ? true : false,
      installedAppPWA: false,
    };
  },
  methods: {
    setStartStep(v) {
      this.startStep = true
      this.$cookies.set('_tastartstep', true);
    },
  }
}
</script>
<style lang="scss">
.start {
  position: absolute;
  height: 100%;
  width: 100%;
  z-index: 1000;
  top: 0;
  left: 0;
}
</style>
