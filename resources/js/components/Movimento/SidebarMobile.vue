<template>
   <div ref="parentSidebar">

     <v-tour name="myTourSidebar" :steps="tour.steps" :options="tour.options" :callbacks="tour.myCallbacks">
       <template slot-scope="tour">
         <transition name="fade">
           <v-step
             class="v-step-custom"
             v-if="tour.currentStep === index"
             v-for="(step, index) of tour.steps"
             :key="index"
             :step="step"
             :previous-step="tour.previousStep"
             :next-step="tour.nextStep"
             :stop="tour.stop"
             :is-first="tour.isFirst"
             :is-last="tour.isLast"
             :labels="tour.labels"
           >
             <template>
               <div slot="actions">
                 <button @click="tour.skip" class="btn btn-sm btn-warning">Fechar</button>

                 <button @click="tour.previousStep" class="btn btn-sm btn-info">Anterior</button>
                 <button @click="tour.nextStep" class="btn btn-sm btn-success">Próximo</button>
               </div>
             </template>
           </v-step>
         </transition>
       </template>
     </v-tour>

     <vs-sidebar :parent="$refs.parentSidebar" v-model="active" default-index="1"  position-right  color="primary" class="sidebarx" spacer >

      <div class="header-sidebar" slot="header">
        <vs-avatar  size="70px" src="/images/movimento/user.png"/>
      </div>

      <vs-sidebar-item index="1" icon="map" to="/movimento117" class="v-step-8">
        Mapa
      </vs-sidebar-item>

      <vs-sidebar-item index="2" icon="favorite" to="/movimento117/quero-doar" class="v-step-9">
        Quero doar
      </vs-sidebar-item>

      <vs-sidebar-item index="3" icon="pan_tool" to="/movimento117/voluntario">
        Quero ser voluntário
      </vs-sidebar-item>

      <vs-divider position="left"></vs-divider>

      <vs-sidebar-item index="2.1" icon="favorite" to="/movimento117">
        <img src="/images/movimento/movimento.png" width="32" alt="">
        &nbsp;&nbsp; #AmorEmMovimento
      </vs-sidebar-item>
      <vs-sidebar-item index="2.2" icon="store" to="/">
        #CompreDoBairro #CompraDoPequeno
      </vs-sidebar-item>
      <vs-sidebar-item index="2.3" icon="house" to="/">
        #VizinhoEuTeAjudo
      </vs-sidebar-item>

      <vs-sidebar-item index="4" icon="swap_horizontal_circle" to="/movimento117/como-funciona">
        Como funciona
      </vs-sidebar-item>

      <vs-sidebar-item index="5" icon="done" to="/transparencia">
        Transparência
      </vs-sidebar-item>

      <vs-sidebar-item index="5" icon="format_align_center" to="/movimento117/sobre">
        Sobre
      </vs-sidebar-item>
      <vs-sidebar-item index="6" icon="get_app"
        :class="{'v-step-12':isAndroid,'v-step-12-1':isMobileSafari}"
        v-if="showInstall && !installedAppPWA">
        <button  @click="installApp" type="button" class="btn btn-sm btn-primary" name="button">Adicionar à tela de ínicio</button>
      </vs-sidebar-item>

      <vs-sidebar-item index="5" icon="system_update" @click="updateApp">
        Atualizar App
      </vs-sidebar-item>



      <div class="footer-sidebar" slot="footer">
        <vs-button  type="flat" target="_blank" href="https://instagram.com/movimento117">
          <img src="/images/movimento/movimento.png?c=1" width="44"  alt="">
          @movimento117
        </vs-button>
        <!-- <vs-button icon="settings" color="primary" type="border"></vs-button> -->
      </div>

    </vs-sidebar>
   </div>

</template>

<script>
import EventBus from '@src/event-bus';
import { isMobile, isAndroid,isMobileSafari } from 'mobile-device-detect';
import Steps from '@src/store/jsons/steps/movimento-sidebar'

export default {
  data() {
    return {
      active: false,
      reduce: true,
      notExpand: false,

      isMobile: isMobile,
      isAndroid: isAndroid,
      isMobileSafari: isMobileSafari,
      installedAppPWA: false,
      showInstall: false,
      tour: {
        steps: Steps,
        options: {
          highlight: true,
          labels: {
            buttonSkip: 'Fechar',
            buttonPrevious: 'Ant',
            buttonNext: 'Próx',
            buttonStop: 'Terminar'
          },
        },
        myCallbacks: {
          onPreviousStep: this.myCustomPreviousStepCallback,
          onNextStep: this.myCustomNextStepCallback,
          onStop: this.myCustomStopCallback
        }
      }
    }
  },
  updated() {
    if(self.INSTALLAPPEVENT) this.showInstall = true
    //this.$tours['myTourSidebar'].start()
  },
  created() {
    EventBus.$on('OPEN_SIDEBAR', this.changeState);

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

      if(isMobileSafari) {
        if (navigator.share) {
          navigator.share({
            title: 'TeAjudo.me',
            url: 'https://teajudo.me?utm_source=shareapp'
          }).then(() => {
            console.log('Thanks for sharing!');
          })
          .catch(console.error);
        } else {
          alert('Não é possível completar, para adicionar a tela clique em compartilhar no navegador, e depois em "Adicionar à tela de início"')
        }
      } else {
        self.INSTALLAPPEVENT.prompt();
        self.INSTALLAPPEVENT.userChoice.then((choice) => {
          if (choice.outcome === 'accepted') {
            this.installedAppPWA = true
          }
          self.INSTALLAPPEVENT = null;
        });
      }
    },
    updateApp() {
      self.location.reload()
    },
    myCustomPreviousStepCallback(currentStep) {

    },
    myCustomNextStepCallback(currentStep) {

    },
    myCustomStopCallback(v) {
      console.log(v);
    }
  }
}
</script>

<style lang="sass" scoped>
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
.v-step-custom
  z-index: 50000!important
</style>
