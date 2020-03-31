<template>
  <div class="">
    <div class="bottombar container">
      <div class="bottombar-logo row align-items-center"  :class="{active:isActive}">
        <div class="col">
          <router-link :to="{ name: 'home' }"><img src="/images/teajudome.png?c=1"  alt=""></router-link>
        </div>

        <div class="col bottombar-links">
          <div class="row align-items-start">
            <div class="col-12">
              <router-link to="/" v-text="$ml.get('menu.mapa')"></router-link>
              <router-link to="/sobre" v-text="$ml.get('menu.sobre')"></router-link>
              <router-link to="/fique-seguro" v-text="$ml.get('menu.seguranca')"></router-link>
            </div>
          </div>

          <div class="row align-items-end">
            <div class="col-12 bottombar-flags">
              <a @click="$ml.change('portuguese')" href="#">PT</a>
              <a @click="$ml.change('spanish')" href="#">ES</a>
              <a @click="$ml.change('english')" href="#">EN</a>
            </div>
          </div>
        </div>
        <div class="col bottombar-volunteers-count">
          {{getMarkers.length}} <small v-text="$ml.get('menu.voluntarios')">voluntários</small>
        </div>
      </div>
    </div>


    <div v-if="showHandUp" @click="changeState" class="btn btn-handup"><strong v-text="$ml.get('menu.handup')"></strong> <span class="icon-hand-stop"></span></div>
    <div v-if="showHandUp" @click="changeStateMember" class="btn btn-needup"><strong v-text="$ml.get('menu.needup')"></strong></div>
    <router-link v-if="showMapUp" class="btn btn-handup" :to="{ name: 'home' }"><strong v-text="$ml.get('menu.mapup')"></strong> <span class="icon-map"></span></router-link>
  </div>
</template>

<script>
 import { mapGetters, mapActions } from 'vuex'
 import { MLBuilder } from 'vue-multilanguage'

export default {
  props: ['address'],
  name: 'BottomBar',
  data() {
    return {
      isActive: false,
      isActiveSidebarMember: false,
      showHandUp: true,
      showMapUp: true,
    }
  },
  watch:{
    $route (to, from){
      this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false
    }
  },
  computed: {
    ...mapGetters([
      'getMarkers',
    ]),
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false
  },
  methods: {
    changeState() {
      this.isActive = !this.isActive
      this.$emit('sidebarOpen', this.isActive);
    },
    changeStateMember() {
      this.isActiveSidebarMember = !this.isActiveSidebarMember
      this.$emit('sidebarOpen', this.isActiveSidebarMember);
    },
    closeSidebar(v) {

      this.isActive = v;
      this.isActiveSidebarMember = v;
      this.$emit('sidebarOpen', v);
    },
  }
}
</script>

<style lang="scss" scoped>
footer {
  padding-top: 0;
}
.btn-handup {
  position: fixed;
  bottom: 90px;
  right: 3px;
  border-radius: 50%;
  font-size: 8px;
  width: 60PX;
  height: 60px;
  background: #ffed4a;
  transition: background .25s ease-in;
  z-index: 1;

  span {
    display: block;
    font-size: 3em;
  }

  @media only screen and (max-width: 600px) {

  }

  &:hover {
    color: #313a4a;
    background: #fff;
  }
}
.btn-needup {
  position: fixed;
  bottom: 155px;
  right: 8px;
  color: #fff;
  border-radius: 50%;
  font-size: 8px;
  width: 50PX;
  height: 50px;
  background: #d43e66;
  transition: background 0.25s ease-in;
  z-index: 1;

  span {
    display: block;
    font-size: 3em;
  }

  @media only screen and (max-width: 600px) {

  }

  &:hover {
    color: #313a4a;
    background: #fff;
  }
}
</style>
