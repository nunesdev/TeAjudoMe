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
            <div v-if="showHandUp" @click="changeState" class="btn btn-handup" v-text="$ml.get('menu.handup')">Posso ajudar
              <span class="icon-hand-stop"></span>
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
  </div>
</template>

<script>
 import AddVoluntario from '@components/AddVoluntario';
 import { mapGetters, mapActions } from 'vuex'
 import { MLBuilder } from 'vue-multilanguage'

export default {
  props: ['address'],
  name: 'Sidebar',
  components: {
    AddVoluntario
  },
  data() {
    return {
      isActive: false,
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

    changeState() {
      this.isActive = !this.isActive
      this.$emit('sidebarOpen', this.isActive);
    },
    closeSidebar(v) {
      this.isActive = v;
      this.$emit('sidebarOpen', this.isActive);
    },
  }
}
</script>

<style lang="css">
</style>
