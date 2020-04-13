<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>

    <div class="start" v-if="!startStep">
      <StartStep @onFinishStep="setStartStep"></StartStep>
    </div>

    <div class="" v-if="startStep">

      <v-tour name="myTour" :steps="tour.steps" :options="tour.options" :callbacks="tour.myCallbacks">
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
                  <button @click="tour.skip" class="btn btn-sm btn-warning"><span class="vs-icon icon-clear material-icons "></span> </button>

                  <button @click="tour.previousStep" class="btn btn-sm btn-info">Anterior</button>
                  <button @click="tour.nextStep" class="btn btn-sm btn-success">Próximo</button>
                </div>
              </template>
            </v-step>
          </transition>
        </template>
      </v-tour>

      <SidebarMobile v-if="isMobile" />

      <BottomBar v-if="isMobile"/>
      <router-view></router-view>

      <Sidebar v-if="!isMobile"/>
      <notifications group="foo" />
    </div>
  </div>
</template>
<script>
import { isMobile } from 'mobile-device-detect'
import Sidebar from '@components/Movimento/Sidebar'
import BottomBar from '@components/Movimento/BottomBar'
import SidebarMobile from '@components/Movimento/SidebarMobile'
import StartStep from '@components/Movimento/StartStep'
import Steps from '@src/store/jsons/steps/movimento'

import EventBus from '@src/event-bus';

export default {
  name: 'Movimento117',
  components: {
    Sidebar,
    SidebarMobile,
    BottomBar,
    StartStep
  },
  data() {
    return {
      isMobile: isMobile,
      sidebarOpen: false,
      startStep: true,
      installedAppPWA: false,
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
    };
  },
  mounted() {
    setTimeout(()=>{
      this.startStep = this.$cookies.get('_tastartstep') || !isMobile ? true : false
      if(this.startStep) this.$tours['myTour'].start()
    },1000)
  },
  updated() {

  },
  watch: {
    startStep(v) {
      if(v) this.$tours['myTour'].start()
    }
  },
  methods: {
    setStartStep(v) {
      this.startStep = true
      this.$cookies.set('_tastartstep', true);
    },
    myCustomPreviousStepCallback(currentStep) {

    },
    myCustomNextStepCallback(currentStep) {
      console.log(this.$tours['myTour']);
      if(currentStep > 6 && currentStep < 8) {
        setTimeout(()=>{EventBus.$emit('OPEN_SIDEBAR', true)},500);
      }
    },
    myCustomStopCallback() {

    }
  }
}
</script>
<style lang="scss">
.start {
  position: absolute;
  height: 100%;
  width: 100%;
  z-index: 1000;
  top: 0;
  left: 0;
}
</style>
