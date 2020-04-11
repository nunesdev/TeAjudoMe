<template>
  <div class="">
    <div class="sidebar">

      <div class="sidebar-volunteers-count">
        <div class="row align-items-center">
          <div class="col-6">
            <div class="row align-items-center no-gutters">
              <div class="col-6">
                <img src="/images/movimento/caixa.png" width="44" height="44" alt="">
              </div>
              <div class="col-6">
                <div class="stats">
                  <span>{{getTotal('user')}}</span> <small>Doadores</small>
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
                  <span>{{getTotal('volunteer')}} </span> <small>Voluntários</small>
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
                   <span>{{getTotal('store')}}</span> <small>Centrais de Coleta</small>
                 </div>
               </div>
            </div>
          </div>
          <div class="col-6">
            <div class="row align-items-center no-gutters">
              <div class="col-6">
                <img src="/images/movimento/sangue.png" width="44" height="44" alt="">
              </div>
               <div class="col-6">
                 <div class="stats">
                   <span>{{getTotalHemocentros('store')}}</span> <small>Hemocentros</small>
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
            <button @click="showCampaigns" type="button" class="btn btn-sm btn-primary" name="button">Campanhas</button>
            <button v-if="!installedAppPWA && showInstall" @click="installApp" type="button" class="btn btn-sm btn-primary" name="button"><span class="icon-download"></span>App</button>
            <div v-if="showButtonNotify" class='onesignal-customlink-container'></div>
            <router-link v-if="showMapUp" class="btn btn-showmap" to="/movimento117"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>
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
            <router-link to="/movimento117/como-funciona">Como funciona</router-link>
            <router-link to="/movimento117/sobre" v-text="$ml.get('menu.sobre')"></router-link>
            <router-link to="/movimento117/fique-seguro">Fique seguro</router-link>
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
      showButtonNotify: false,
      msg: "teste teste",
      installedAppPWA: false,
      showInstall: false
    }
  },
  watch:{
    $route (to, from){
      this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false
    }
  },
  updated() {
    if(self.INSTALLAPPEVENT) this.showInstall = true
  },
  created() {
    this.show()
    this.showButtonNotify = true;
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false

    if (navigator.standalone) {
      console.log('Launched: Installed (iOS)');
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'ios'
        })
      this.installedAppPWA = true;
      this.showInstall = false
    } else if (matchMedia('(display-mode: standalone)').matches) {
      console.log('Launched: Installed');
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'android'
        })
      this.installedAppPWA = true;
        this.showInstall = false
    } else {
      console.log('Launched: Browser Tab');
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'Browser'
        })
    }
  },
  computed: {
    ...mapGetters([
      'getMarkersMovimento'
    ])
  },
  methods: {
    getTotal(type) {
      return this.getMarkersMovimento.filter((item)=>{
        if(type == 'store' && item.type == 'store' && !item.options.blood) {
          return item.type == type
        } else if(type != 'store' && item.type != 'store') {
          return item.type == type
        }
      }).length
    },
    getTotalHemocentros(type) {
      return this.getMarkersMovimento.filter((item)=>{
        if(type == 'store' && item.type == 'store' && item.options.blood) {
          return item.type == type
        }
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
    showCampaigns() {
      this.$modal.show('select-campaign');
    },
    installApp() {
      self.INSTALLAPPEVENT.prompt();
      self.INSTALLAPPEVENT.userChoice.then((choice) => {
        if (choice.outcome === 'accepted') {
          this.installedAppPWA = true
        }
        self.INSTALLAPPEVENT = null;
      });
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
