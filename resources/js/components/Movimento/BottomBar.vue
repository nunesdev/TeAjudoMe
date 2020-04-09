<template>
  <div class="">
    <div class="bottombar container">
      <div class="row align-items-center"  :class="{active:isActive}">

        <div class="col-12 bottombar-volunteers-count">
          <div class="row no-gutters">
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/movimento/caixa.png" width="22" alt="">
                </div>
                <div class="col-6">
                  <div class="stats">
                    <span>{{getTotal('user')}}</span> <small>{{getTotal('user') > 1 ? 'Doadores' : 'Doador'}}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/movimento/user.png" width="16" alt="">
                </div>
                <div class="col-6">
                  <div class="stats">
                    <span>{{getTotal('volunteer')}} </span> <small>{{getTotal('volunteer') > 1 ? 'Voluntários' : 'Voluntário'}}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/movimento/abrigo.png" width="16" alt="">
                </div>
                 <div class="col-6">
                   <div class="stats">
                     <span>{{getTotal('store')}}</span> <small>Centrais</small>
                   </div>
                 </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 text-right">
          <small>Total: {{getTotalMarkersMovimento}}</small>
        </div>
      </div>


    </div>

    <div class="bottombar--actions text-center">

      <div class="row">
        <div class="col-12">
          <router-link to="/movimento117/quero-doar"  class="btn btn-sm btn-active btn-white">
            <span class="icon-hand-stop"></span> <span>Quero doar</span>
          </router-link>
          <router-link  class="btn btn-sm btn-white" to="/movimento117/voluntario">
            <span>Quero ser voluntário</span>
          </router-link>
          <button v-if="!installedAppPWA" @click="installApp" type="button" class="btn btn-sm btn-primary" name="button"><span class="icon-download"></span>App</button>
        </div>
      </div>

      <div class="col-12 bottombar-links">
        <div class="row align-items-start">

          <div class="col-9">
            <router-link to="/movimento117/fique-seguro">Fique seguro</router-link>
            <router-link to="/movimento117/como-funciona">Como funciona</router-link>
            <router-link to="/movimento117/sobre">Sobre</router-link>
          </div>
          <div class="col-3">
            <div class="row justify-content-center align-items-center  no-gutters">

              <div class="col-12">
                <a target="_blank" href="https://instagram.com/movimento117">
                  <img src="/images/movimento/movimento.png?c=1" width="44"  alt="">
                </a>
              </div>
            </div>
          </div>
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
    }
  },
  watch:{
    $route (to, from){
      this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false
    }
  },
  computed: {
    ...mapGetters([
      'getMarkersMovimento',
      'getTotalMarkersMovimento'
    ])
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
    } else if (matchMedia('(display-mode: standalone)').matches) {
      console.log('Launched: Installed');
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'android'
        })
      this.installedAppPWA = true;
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
      return this.getMarkersMovimento.filter((item)=>{
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
