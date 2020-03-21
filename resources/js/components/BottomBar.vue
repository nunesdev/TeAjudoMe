<template>
  <div class="">
    <div class="bottombar row align-items-center"  :class="{active:isActive}">
      <div class="bottombar-logo text-center col">
        <img src="/images/teajudome.png"  alt="">
      </div>
      <div class="col">
        <div @click="changeState" class="btn btn-handup">Posso ajudar
          <span class="icon-hand-stop"></span>
        </div>
      </div>
      <div class="col bottombar-volunteers-count text-center">
        {{getMarkers.length}} <small>voluntários</small>
        <small>Contato:  <a href="mailto:teajudome@gmail.com">teajudome@gmail.com</a> </small>
      </div>
    </div>
    <div class="bottombar--secondary" :class="{active:isActive}">
      <div class="bottombar--close" @click="changeState">
        <span class="icon-circle-left"></span>
      </div>

      <div class="bottombar--secondary__body">
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
  name: 'BottomBar',
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
