<template>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
          <div class="text-left">
            <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'home' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>
          <h1>Transparência</h1>
          <hr>
          <div class="">
            <small class="label text-right">Última atualização: {{lastUpdated}}</small>
            <p class="text-center">
              <h3>Valor arrecadado</h3>
              <b>R$ {{this.price}}</b>
            </p>
            <p class="text-center">
              <h3>Cestas Básicas</h3>
              <b>{{this.cestas}}</b>
            </p>
            <p>
              Meta de Cestas: {{this.target}}
              <hr>
              <small class="text-right label">Arrecadado</small>
              <vue-slider v-model="value" disabled :tooltip="'always'" :tooltip-formatter="sliderOptions.formatter1" :tooltip-placement="['top']"></vue-slider>
            </p>
            <p>Comprovantes de compra</p>
            <small>Colocaremos todos os comprovantes de compra aqui.</small>
            <hr>
            <p>Famílias atendidas</p>
            <small>Colocaremos aqui os bairros atendidos, com algumas fotos.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';
import EventBus from '@src/event-bus';
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/material.css'

export default {
  name: 'sobre',
  components: { VueSlider },
  data() {
    return {
      isMobile: isMobile,
      lastUpdated: '14/04/2020 ás 18h',
      target: 60,
      price: 60,
      cestas: 0,
      price_food: 60,
      value: 0,
      sliderOptions: {
        formatter1: '{value}%',
        dotSize: 18
      },
    }
  },
  created() {
    EventBus.$emit('OPEN_SIDEBAR_HOME', false);

    this.cestas = Math.ceil(this.price / this.price_food);
    this.value = Math.floor((this.cestas/this.target) * 100)

    if(this.value > 100) {
      this.sliderOptions.formatter1 = this.value+'%'
      this.value = 100
    }
  }
}
</script>
  <style lang="sass">
    .label
      display: block
    .vue-slider-process
      background-color: #8cc8ec
    .vue-slider-dot-handle
      background-color: #ff6c51
      &:after
        background-color: rgba(255, 108, 80,0.5)
    .vue-slider-dot-tooltip-inner
      background-color: #ff6c51
    .vue-slider-rail
      background-color: #bdd7e7
    .vue-slider-mark-step
      background-color: #355b73
    .vue-slider-mark-step-active
      background-color: #6fadd2
  </style>
