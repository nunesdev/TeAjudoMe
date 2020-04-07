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
import Sidebar from '@components/Movimento/Sidebar';
import BottomBar from '@components/Movimento/BottomBar';


export default {
  name: 'app',
  components: {
    Sidebar,
    BottomBar
  },
  data() {
    return {
      isMobile: isMobile,
      sidebarOpen: false
    };
  },
  mounted() {
  },
  created() {

  },
  methods: {
    onSidebarOpen(v) {
      this.sidebarOpen = v
    },
  }
}
</script>
