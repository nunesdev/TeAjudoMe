<template>
  <div class="">
    <div class="sidebar">
      <div class="sidebar-logo text-center">
        <img src="/images/teajudome.png?c=1"  alt="">
      </div>
      <div class="sidebar-volunteers-count text-center">
        <div class="row justify-content-center">
          <div class="col-12">
            {{getMarkers.length}} <small>voluntários</small>
            <small>Contato:  <a href="mailto:teajudome@gmail.com">teajudome@gmail.com</a> </small>
          </div>
          <div class="col-12">
            <div @click="changeState" class="btn btn-handup">Posso ajudar
              <span class="icon-hand-stop"></span>
            </div>
          </div>

          <footer>
            <router-link to="/">Mapa</router-link>
            <router-link to="/sobre">Sobre</router-link>
            <router-link to="/fique-seguro">Fique Seguro</router-link>
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

export default {
  props: ['address'],
  name: 'Sidebar',
  components: {
    AddVoluntario
  },
  data() {
    return {
      isActive: false
    }
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
