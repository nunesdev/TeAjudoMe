<template>
  <div class="">
    <div class="sidebar">
      <div class="sidebar-logo text-center">
        <router-link :to="{ name: 'home' }"><img src="/images/teajudome.png?c=1"  alt=""></router-link>
      </div>
      <div class="sidebar-volunteers-count text-center">
        <div class="row justify-content-center">
          <div class="col-12">
            {{getMarkers.length}} <small v-text="$ml.get('menu.voluntarios')"></small>
            <small v-text="$ml.get('menu.contato')">  <a href="mailto:teajudome@gmail.com">teajudome@gmail.com</a> </small>
          </div>
          <div class="col-12">
            <div v-if="showHandUp" @click="changeStateMember" class="btn btn-needup">
              <span v-text="$ml.get('menu.needup')"></span>
            </div>
            <div v-if="showHandUp" @click="changeState" class="btn btn-handup">
              <span v-text="$ml.get('menu.handup')"></span> <span class="icon-hand-stop"></span>
            </div>
            <router-link v-if="showMapUp" class="btn btn-handup" :to="{ name: 'home' }" v-text="$ml.get('menu.mapup')"> <span class="icon-map"></span></router-link>
          </div>

          <footer>
            <router-link to="/" v-text="$ml.get('menu.mapa')"></router-link>
            <router-link to="/sobre" v-text="$ml.get('menu.sobre')"></router-link>
            <router-link to="/fique-seguro" v-text="$ml.get('menu.seguranca')"></router-link>
            <hr>
            <a @click="$ml.change('portuguese')" href="#">PT</a>
            <a @click="$ml.change('spanish')" href="#">ES</a>
            <a @click="$ml.change('english')" href="#">EN</a>

            <div class="sponsors">
            <div class="col-12">
              <small v-text="$ml.get('sidebar.sponsor')"></small>
              <a target="_blank" href="https://mapbox.com"><img src="/images/mapbox-logo-white.png" width="80" alt=""></a>
            </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <div class="sidebar--secondary" :class="{active:isActive}">
      <div class="sidebar--close" @click="changeState">
        <span class="icon-circle-left"></span>
      </div>

      <div class="sidebar--secondary__body">
        <AddVoluntario :address.async="address" @closeSidebar="closeSidebar" />
      </div>
    </div>
    <div class="sidebar--third" :class="{active:isActiveSidebarMember}">
      <div class="sidebar--close" @click="changeState">
        <span class="icon-circle-left"></span>
      </div>

      <div class="sidebar--third__body">
        <AddMember :address.async="address" @closeSidebar="closeSidebar" />
      </div>
    </div>
  </div>
</template>

<script>
 import AddVoluntario from '@components/AddVoluntarioSidebar';
 import AddMember from '@components/AddMemberSidebar';

 import { mapGetters, mapActions } from 'vuex'
 import { MLBuilder } from 'vue-multilanguage'

export default {
  props: ['address'],
  name: 'Sidebar',
  components: {
    AddVoluntario,
    AddMember
  },
  data() {
    return {
      isActive: false,
      isActiveSidebarMember: false,
      showHandUp: true,
      showMapUp: true
    }
  },
  watch:{
    $route (to, from){
      this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false
    }
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false
  },
  computed: {
    ...mapGetters([
      'getMarkers',
    ]),
  },
  methods: {
    changeStateMember() {
      this.isActiveSidebarMember = !this.isActiveSidebarMember
      this.$emit('sidebarOpen', this.isActiveSidebarMember);
    },
    changeState() {
      this.isActive = !this.isActive
      this.$emit('sidebarOpen', this.isActive);
    },
    closeSidebar(v) {
      this.isActive = v;
      this.isActiveSidebarMember = v;
      this.$emit('sidebarOpen', v);
    },
  }
}
</script>

<style lang="css">
</style>
