<template>
  <div class="">
    <div class="sidebar">

      <div class="sidebar-volunteers-count">
        <div class="row">
          <div class="col-6">
            <small v-text="$ml.get('sidebar.total.requests')">Solicitações</small><span>{{getTotal('user')}}</span>
          </div>
          <div class="col-6">
            <small v-text="$ml.get('sidebar.total.volunteers')"></small><span>{{getTotal('volunteer')}} </span>
          </div>
          <div class="col-12">
          <small v-text="$ml.get('sidebar.total.small_business')">Pequenos negócios</small>  <span>{{getTotal('store')}}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <hr>
          <div class="sidebar--actions">
            <router-link to="/preciso-de-ajuda"  class="btn btn-active btn-white">
              <span class="icon-hand-stop"></span> <span v-text="$ml.get('menu.needup')"></span>
            </router-link>

            <router-link to="/posso-ajudar"  class="btn btn-white">
              <span v-text="$ml.get('menu.handup')"></span>
            </router-link>
            <router-link  class="btn btn-white" to="/negocio">
              <span v-text="$ml.get('menu.marketup')"></span>
            </router-link>
            <router-link v-if="showMapUp" class="btn btn-showmap" :to="{ name: 'home' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>
        </div>
        <!-- <div class="col-12">
          <div class="row">
            <div class="col-12">
              <h6>Campanhas ativas:</h6>
              <ul class="list-unstyled">
                <li @click="getFilterByType('store')">
                  <div class="row">
                    <div class="col-3">
                      <img src="/images/movimento/user.png" width="32" height="32" alt="">

                    </div>
                    <div class="col-9">
                      <span>Movimento 117 - #AmorEmMovimento</span>
                      <router-link class="btn btn-sm btn-info" :to="{ name: 'Movimento117', params: {'utm_source':'home'} }">Ir para o mapa</router-link>
                    </div>
                  </div>
                </li>

              </ul>
            </div>
          </div>
        </div> -->

        <footer class="container">
          <div class="sponsors">
            <div class="sidebar-logo">
              <div class="row align-items-center">
                <div class="col-12">
                  <router-link :to="{ name: 'home' }"><img src="/images/teajudome.png?c=1"  alt=""></router-link>
                </div>
              </div>
            </div>
            <div class="col-12">
              <a @click="$ml.change('portuguese')" href="#">Português</a>
              <a @click="$ml.change('english')" href="#">English</a>
              <a @click="$ml.change('spanish')" href="#">Spanish</a>
            </div>
            <div class="col-12">
              <router-link to="/" v-text="$ml.get('menu.mapa')"></router-link>
              <router-link to="/sobre" v-text="$ml.get('menu.sobre')"></router-link>
              <router-link to="/fique-seguro" v-text="$ml.get('menu.seguranca')"></router-link>
                <a href="mailto:teajudome@gmail.com"><span v-text="$ml.get('menu.contato')"></span></a>
              <br/>
              <br>
            </div>
            <div class="col-12">
              <small v-text="$ml.get('sidebar.sponsor')"></small>
              <a target="_blank" href="https://mapbox.com"><img src="/images/mapbox-logo-black.png" width="80" alt=""></a>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>

 import { mapGetters, mapActions } from 'vuex'
 import { MLBuilder } from 'vue-multilanguage'

export default {
  props: ['address'],
  name: 'Sidebar',
  data() {
    return {
      isActive: false,
      isActiveSidebarMember: false,
      showHandUp: true,
      showMapUp: true,
      msg: "teste teste"
    }
  },
  watch:{
    $route (to, from){
      this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false
    }
  },
  created() {
    this.show()
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false
  },
  computed: {
    ...mapGetters([
      'getMarkers',
      'getFilter'
    ])
  },
  methods: {
    getTotal(type) {
      return this.getMarkers.filter((item)=>{
        return item.type == type
      }).length
    },
    getFilterByType(type) {
      const all_tems = this.getFilter(type)
    },
    show () {
      this.$modal.show('board');
    },
    hide () {
      this.$modal.hide('hello-world');
    },
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
