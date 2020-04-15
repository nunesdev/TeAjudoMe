<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>

    <div class="start" v-if="!startStep">
      <StartStep @onFinishStep="setStartStep"></StartStep>
    </div>

    <div class="" v-if="startStep">
      <BottomBar v-if="isMobile" />
      <SidebarMobile v-if="isMobile" />

      <router-view></router-view>


      <Sidebar v-if="!isMobile" />
      <notifications group="foo" />
    </div>
  </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect';
import Sidebar from '@components/Sidebar';
import BottomBar from '@components/BottomBar';
import SidebarMobile from '@components/SidebarMobile'
import StartStep from '@components/Movimento/StartStep'

export default {
  name: 'app',
  components: {
    Sidebar,
    BottomBar,
    SidebarMobile,
    StartStep
  },
  data() {
    return {
      isMobile: isMobile,
      sidebarOpen: false,
      startStep: true,
    };
  },
  mounted() {
    this.sendTagHash();

    setTimeout(()=>{
      this.startStep = this.$cookies.isKey('_tastartstep') || !isMobile ? true : false
    },1000)
  },
  created() {

  },
  methods: {
    onSidebarOpen(v) {
      this.sidebarOpen = v
    },
    setStartStep(v) {
      this.startStep = true
      this.$cookies.set('_tastartstep', true, 60 * 60 * 24 * 30);
    },
    sendTagHash() {
      var OneSignal = self.OneSignal || [];
      var uHashCurrent = 'teajudo';

      if (OneSignal && uHashCurrent !== '') {
        OneSignal.push(function() {
          OneSignal.sendTag("u_user_campaign", uHashCurrent);
        })
      }
    }
  }
}
</script>
