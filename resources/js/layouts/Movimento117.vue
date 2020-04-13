<template>
  <div class="wrapper"
  :class='{"sidebar-active":sidebarOpen}'>

    <div class="start" v-if="!startedStep">
      <StartStep @onFinishStep="setStartedStep"></StartStep>
    </div>

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
                <button @click="tour.skip" class="btn btn-sm btn-warning">Fechar</button>

                <button @click="tour.previousStep" class="btn btn-sm btn-info">Anterior</button>
                <button @click="tour.nextStep" class="btn btn-sm btn-success">Próximo</button>
              </div>
            </template>
          </v-step>
        </transition>
      </template>
    </v-tour>

    <div class="" v-if="startedStep">



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
      startedStep: true,
      startedTutorial : this.$cookies.get('_tastartutorial') ? true : false,
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
      this.startedStep = this.$cookies.get('_tastartstep') || !isMobile ? true : false
      if(this.startedStep && !this.startedTutorial) this.$tours['myTour'].start()

    },1000)
  },
  watch: {
    startedStep(v) {
      if(v) this.$tours['myTour'].start()
    }
  },
  methods: {
    setStartedStep(v) {
      this.startedStep = true
      this.$cookies.set('_tastartstep', true);
      this.$tours['myTour'].start()
    },
    myCustomPreviousStepCallback(currentStep) {

    },
    myCustomNextStepCallback(currentStep) {
      if(currentStep > 6 && currentStep < 8) {
        setTimeout(()=>{
          EventBus.$emit('OPEN_SIDEBAR', true)
          this.$cookies.set('_tastartutorial', true);

          this.startedTutorial = false;

        },500);
      }
    },
    myCustomStopCallback(v) {
      this.$cookies.set('_tastartutorial', true);
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
