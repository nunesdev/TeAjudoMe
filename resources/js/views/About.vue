<template>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
          <div class="text-left">
            <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'home' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>
          <h1 v-text="$ml.get('about.title')"></h1>
          <div class="" v-html="$ml.get('about.text')"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';
import EventBus from '@src/event-bus';
export default {
  name: 'sobre',
  data() {
    return {
      isMobile: isMobile,
    }
  },
  created() {
    EventBus.$emit('OPEN_SIDEBAR_HOME', false);
  }
}
</script>

<style lang="css">
</style>
