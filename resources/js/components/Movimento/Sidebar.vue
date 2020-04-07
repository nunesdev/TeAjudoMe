<template>
  <div class="">
    <div class="sidebar">

      <div class="sidebar-volunteers-count">
        <div class="row ">
          <div class="col-6">
            <div class="row align-items-center no-gutters">
              <div class="col-6">
                <img src="/images/movimento/caixa.png" width="44" height="44" alt="">
              </div>
              <div class="col-6">
                <div class="stats">
                  <span>{{getTotal('user')}}</span> <small>{{getTotal('user') > 1 ? 'Doadores' : 'Doador'}}</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="row align-items-center no-gutters">
              <div class="col-6">
                <img src="/images/movimento/user.png" width="44" height="44" alt="">
              </div>
              <div class="col-6">
                <div class="stats">
                  <span>{{getTotal('volunteer')}} </span> <small>{{getTotal('volunteer') > 1 ? 'Voluntários' : 'Voluntário'}}</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="row align-items-center no-gutters">
              <div class="col-6">
                <img src="/images/movimento/abrigo.png" width="44" height="44" alt="">
              </div>
               <div class="col-6">
                 <div class="stats">
                   <span>{{getTotal('store')}}</span> <small>Central de Coleta</small>
                 </div>
               </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <hr>
          <div class="sidebar--actions">
            <router-link to="/movimento117/quero-doar"  class="btn btn-active btn-white">
              <span class="icon-hand-stop"></span> <span>Quero doar</span>
            </router-link>

            <router-link to="/movimento117/voluntario"  class="btn btn-white">
              <span>Quero ser um voluntário</span>
            </router-link>

            <router-link v-if="showMapUp" class="btn btn-showmap" to="/movimento117"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>
        </div>

        <footer class="container">
          <div class="sponsors">
            <div class="sidebar-logo">
              <div class="row justify-content-center align-items-center  no-gutters">
                <div class="col-4">
                  <router-link :to="{ name: 'home' }"><img src="/images/teajudome.png?c=1"  alt=""></router-link>
                </div>

                <div class="col-4">
                  <a target="_blank" href="https://instagram.com/movimento117">
                    <img src="/images/movimento/movimento.png?c=1"  alt="">
                  </a>
                </div>
              </div>
            </div>
            <div class="col-12">
              <router-link to="/movimento117" v-text="$ml.get('menu.mapa')"></router-link>
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
      this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false
    }
  },
  created() {
    this.show()
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false
  },
  computed: {
    ...mapGetters([
      'getMarkersMovimento'
    ])
  },
  methods: {
    getTotal(type) {
      return this.getMarkersMovimento.filter((item)=>{
        return item.type == type
      }).length
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

<style lang="scss" scoped>
.sidebar-volunteers-count {
  .row {
    .col-6 {
      // padding-left: 5px;
      // padding-right: 5px;
    }
  }
  .stats {
    span {
      font-size: 22px;
    }
    small {
      line-height: 15px;
    }
  }
}

.btn {
  &.btn-active {
    background: #264463;
  }
}

.sidebar-logo {
  padding-bottom: 20px;
}
</style>
