<template>
  <div class="">
    <div class="bottombar container">
      <div class="bottombar-logo row align-items-center"  :class="{active:isActive}">

        <div class="col-12 bottombar-volunteers-count">
          <div class="row">
            <div class="col-3">
              <small v-text="$ml.get('sidebar.total.requests')">Solicitações</small><br/><span>{{getTotal('user')}}</span>
            </div>
            <div class="col-4">
              <small v-text="$ml.get('sidebar.total.volunteers')"></small><br/><span>{{getTotal('volunteer')}} </span>
            </div>
            <div class="col-5">
            <small v-text="$ml.get('sidebar.total.small_business_mobile')">Peq. negócios</small> <br/><span>{{getTotal('store')}}</span>
            </div>
          </div>
        </div>
      </div>


    </div>

    <div class="bottombar--actions">

      <div class="row">
        <div class="col-12">
          <router-link v-if="showMapUp" class="btn btn-showmap" :to="{ name: 'home' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
        </div>
        <div class="col-12">
          <router-link to="/preciso-de-ajuda"  class="btn btn-active btn-white">
            <span class="icon-hand-stop"></span> <span v-text="$ml.get('menu.needup')"></span>
          </router-link>
          <router-link  class="btn btn-white" to="/negocio">
            <span v-text="$ml.get('menu.marketup')"></span>
          </router-link>
          <router-link to="/posso-ajudar"  class="btn btn-white">
            <span v-text="$ml.get('menu.handup')"></span>
          </router-link>


        </div>
      </div>

      <div class="col-12 bottombar-links">
        <div class="row align-items-start">
          <div class="col-6">
            <router-link to="/" v-text="$ml.get('menu.mapa')"></router-link>
            <router-link to="/sobre" v-text="$ml.get('menu.sobre')"></router-link>
            <router-link to="/fique-seguro" v-text="$ml.get('menu.seguranca')"></router-link>
          </div>
          <div class="col-6 bottombar-flags">
            <a @click="$ml.change('portuguese')" href="#">Português</a>
            <a @click="$ml.change('spanish')" href="#">English</a>
            <a @click="$ml.change('english')" href="#">Spanish</a>
          </div>
        </div>

        <div class="row align-items-end">

        </div>
      </div>
    </div>
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
    getTotal(type) {
      return this.getMarkers.filter((item)=>{
        return item.type == type
      }).length
    },
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
