<template>
   <div ref="parentSidebar">
     <vs-sidebar :parent="$refs.parentSidebar" v-model="active" default-index="1"  position-right  color="primary" class="sidebarx" spacer >

      <div class="header-sidebar" slot="header">
        <vs-avatar  size="70px" src="/images/teajudome.png"/>
      </div>

      <vs-sidebar-item index="1" icon="map" to="/">
        Mapa
      </vs-sidebar-item>

      <vs-sidebar-item index="2" icon="pan_tool" to="/preciso-de-ajuda">
        <span v-text="$ml.get('menu.needup')"></span>
      </vs-sidebar-item>

      <vs-sidebar-item index="3" icon="favorite" to="/posso-ajudar">
        <span v-text="$ml.get('menu.handup')"></span>
      </vs-sidebar-item>
      <vs-sidebar-item index="4" icon="store" to="/negocio">
        <span v-text="$ml.get('menu.marketup')"></span>
      </vs-sidebar-item>

      <vs-divider position="left"></vs-divider>

      <vs-sidebar-item index="5" icon="format_align_center" to="/sobre">
        Sobre
      </vs-sidebar-item>
      <vs-sidebar-item index="6" icon="get_app">
        <button v-if="!installedAppPWA" @click="installApp" type="button" class="btn btn-sm btn-primary" name="button">Adicionar à tela de ínicio</button>
      </vs-sidebar-item>

      <vs-sidebar-item index="2.1" icon="favorite" to="/movimento117">
        #AmorEmMovimento
      </vs-sidebar-item>
      <vs-sidebar-item index="2.2" icon="store" to="/">
        #CompreDoBairro #CompraDoPequeno
      </vs-sidebar-item>
      <vs-sidebar-item index="2.3" icon="house" to="/">
        #VizinhoEuTeAjudo
      </vs-sidebar-item>

      <div class="footer-sidebar" slot="footer">
        <vs-button  type="flat" target="_blank" href="https://instagram.com/teajudo.me">
          @teajudo.me
        </vs-button>
        <vs-button color="primary" type="border">
          <a @click="$ml.change('portuguese')" href="#">Português</a>
          <a @click="$ml.change('english')" href="#">English</a>
          <a @click="$ml.change('spanish')" href="#">Spanish</a>
        </vs-button>
      </div>

    </vs-sidebar>
   </div>

</template>

<script>
import EventBus from '@src/event-bus';


export default {
  data() {
    return {
      active: false,
      reduce: true,
      notExpand: false,

      installedAppPWA: false,
      showInstall: false
    }
  },
  created() {
    EventBus.$on('OPEN_SIDEBAR_HOME', this.changeState);

    if (navigator.standalone) {
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'ios'
        })
      this.installedAppPWA = true;
      this.showInstall = false
    } else if (matchMedia('(display-mode: standalone)').matches) {
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'android'
        })
      this.installedAppPWA = true;
        this.showInstall = false
    } else {
      this.$gtag.event('Launched_App', {
          'event_category': 'Launched',
          'event_label': 'standalone',
          'event_value': 'Browser'
        })
    }
  },
  methods: {
    changeState(v){
      setTimeout(()=>{
        this.active = v
      },500)
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

<style lang="sass">
#parentx
  overflow: hidden
  height: 100vh
  position: relative

.header-sidebar
  display: flex
  align-items: center
  justify-content: center
  flex-direction: column
  width: 100%
  h4
    display: flex
    align-items: center
    justify-content: center
    width: 100%
    > button
      margin-left: 10px
.footer-sidebar
  display: flex
  align-items: center
  justify-content: space-between
  width: 100%
  > button
      border: 0px solid rgba(0,0,0,0) !important
      border-left: 1px solid rgba(0,0,0,.07) !important
      border-radius: 0px !important
</style>
