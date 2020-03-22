<template>
  <div class="">
    <div class="bottombar row align-items-center"  :class="{active:isActive}">
      <div class="bottombar-logo text-center col">
        <img src="/images/teajudome.png"  alt="">
      </div>
      <div class="col bottombar-volunteers-count">
        {{getMarkers.length}} <small>voluntários</small>
      </div>
      <div class="col  text-center">

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

    <div @click="changeState" class="btn btn-handup">
      <span class="icon-hand-stop"></span>
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

<style lang="scss" scoped>
.btn-handup {
  position: fixed;
  bottom: 90px;
  right: 3px;
  border-radius: 50%;
  font-size: 3em;
  width: 60PX;
  height: 60px;
  background: #ffed4a;
  transition: background .25s ease-in;
  z-index: 1;

  @media only screen and (max-width: 600px) {

  }

  &:hover {
    color: #313a4a;
    background: #fff;
  }
}
</style>
