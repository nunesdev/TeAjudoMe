<template>
  <div class="">
    <div class="bottombar container">
      <div class=" row align-items-center "  :class="{active:isActive}">

        <div class="col-12 bottombar-volunteers-count">
          <div class="row no-gutters">
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/perfil.png" width="22" alt="">
                </div>
                <div class="col-6">
                  <div class="stats">
                    <span>{{getTotal('user')}}</span> <small v-text="$ml.get('sidebar.total.requests')"></small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/voluntario.png" width="16" alt="">
                </div>
                <div class="col-6">
                  <div class="stats">
                    <span>{{getTotal('volunteer')}} </span> <small v-text="$ml.get('sidebar.total.volunteers')"></small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/comercio.png" width="16" alt="">
                </div>
                 <div class="col-6">
                   <div class="stats">
                     <span>{{getTotal('store')}}</span> <small v-text="$ml.get('sidebar.total.small_business_mobile')"></small>
                   </div>
                 </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 text-right">
          <small>Total: {{getTotalMarkers}}</small>
        </div>
      </div>


    </div>


    <div class="bottombar--actions">

      <div class="row">
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
          <button @click="show" type="button" class="btn btn-sm btn-primary" name="button">Campanhas</button>
          <button v-if="!installedAppPWA && showInstall" @click="installApp" type="button" class="btn btn-sm btn-primary" name="button"><span class="icon-download"></span>App</button>
        </div>
      </div>

      <div class="col-12 bottombar-links">
        <div class="row align-items-start">
          <div class="col-6">
            <!-- <router-link to="/" v-text="$ml.get('menu.mapa')"></router-link> -->
            <router-link to="/sobre" v-text="$ml.get('menu.sobre')"></router-link>
            <router-link to="/fique-seguro" v-text="$ml.get('menu.seguranca')"></router-link>
            <div class='onesignal-customlink-container'></div>
          </div>
          <div class="col-6 bottombar-flags">
            <a @click="$ml.change('portuguese')" href="#">Português</a>
            <a @click="$ml.change('english')" href="#">English</a>
            <a @click="$ml.change('spanish')" href="#">Spanish</a>
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
      installedAppPWA: false,
      showInstall: false
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
      'getTotalMarkers',
    ]),
  },
  updated() {
    if(self.INSTALLAPPEVENT) this.showInstall = true
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'home' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'home' ? true : false

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
    installApp() {
      self.INSTALLAPPEVENT.prompt();
      self.INSTALLAPPEVENT.userChoice.then((choice) => {
        if (choice.outcome === 'accepted') {
          this.installedAppPWA = true
        }
        self.INSTALLAPPEVENT = null;
      });
    },
    show () {
      this.$modal.show('select-campaign');
    }
  }
}
</script>

<style lang="scss" scoped>
.bottombar {
  padding-top: 10px;
  padding-bottom: 10px;
  &.container {
    padding-left: 10px;
    padding-right: 10px;
  }

  .bottombar-volunteers-count {
    .col-4 {
      padding-left: 5px;
      padding-right: 5px;
    }
    img {
      max-width: 100%;
      width: 32px;
    }
    small {
      font-size: 11px;
    }
  }
}
footer {
  padding-top: 0;
}

.btn {
  &.btn-active {
    background: #264463;
  }
}
</style>
