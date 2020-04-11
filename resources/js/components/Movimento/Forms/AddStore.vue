<template>
    <div class="">
      <div class="row justify-content-center">


        <div :class="{'col-md-7 col-sm-12':!isMobile,'fixed-map':isMobile,'fixed-map-show':isMapShow}">
          <Map @onDragEnd="onDragEnd" @onResult="onResultAddress"></Map>
          <div class="fixed-map-close" v-if="isMobile">
            <a @click="isMapShow = false" class="btn btn-showmap">Ok, feito</a>
          </div>
        </div>

        <div class="col-md-5 col-sm-12">
          <div class="container">
            <div class="overlay" v-if="!isLocated">
              <span v-text="$ml.get('sidebar.form.msg.error_location')"></span>
            </div>
            <div class="text-left">
              <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'home' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
            </div>
            <h3>Dados do local</h3>

            <hr>

            <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">

              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.name" name="name" placeholder="Nome do local"  required>
                 <small>ex: Casa dona Maria / Hemocentro Hospital das Clínicas</small>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.support.owner" name="owner" placeholder="Nome do responsável"  required>
              </div>
              <div class="form-group">
                <VuePhoneNumberInput @update="updatePhone" :translations="translations"  v-model="info.phone_" required />
                 <small><span v-text="$ml.get('sidebar.form.whatsapp')"></span>  <input type="checkbox" v-model="info.whatsapp" name="" value=""> </small>
              </div>
              <div class="form-group">
                 <input type="email" class="form-control" v-model="info.email" name="creditcard" :placeholder="$ml.get('sidebar.form.email')">
              </div>

              <div class="form-group" v-if="isMobile">
                <a class="btn btn-sm white btn-success" @click="isMapShow = !isMapShow">Alterar endereço (localizacão)</a>
                 <!-- <input type="text" class="form-control" id="address" v-model="info.address" name="address" :placeholder="$ml.get('store.form.address')" required> -->
              </div>
              <div class="form-group" v-if="info.address">
                <input type="text"  class="form-control" v-model="info.address" name="address" disabled>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.city" name="city" :placeholder="$ml.get('sidebar.form.city')" required>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.state" name="state" :placeholder="$ml.get('sidebar.form.state')" required>
              </div>
              <div class="form-group">
                <h4>A central é: </h4>
                <hr>

                <div class="row helps text-center">
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.central_coleta}">
                      <label for="central_coleta" >

                        <span>
                          <img src="/images/movimento/caixa.png" width="32" height="32" alt="">
                        </span>
                        <small>Ponto de coleta</small>
                        <input type="checkbox" name="support[]" v-model="info.support.central_coleta" id="central_coleta" value="central_coleta">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.blood}">
                      <label for="blood">
                        <span>
                          <img src="/images/movimento/doacao.png" width="32" height="32" alt="">
                        </span>
                        <small>Hemocentro</small>
                        <input type="checkbox" name="support[]" v-model="info.support.blood" id="blood" value="blood">
                      </label>
                    </div>
                  </div>


                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <small>Observações</small>
                      <input class="form-control" type="text" v-model="info.support.others" name=""  value="">
                    </div>
                  </div>

                </div>
              </div>

              <div class="form-group">
                <h4 v-text="$ml.get('store.form.available.title')">Horário de funcionamento</h4>
                <hr>

                <div class="row helps text-center">
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.anytime}">
                      <label for="available_anytime" >

                        <small v-text="$ml.get('store.form.available.anytime')">Todos os dias</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.anytime" id="available_anytime" value="available_anytime">
                      </label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.week}">
                      <label for="available_week" >
                        <small v-text="$ml.get('store.form.available.week')">Seg à Sex</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.week" id="available_week" value="available_week">
                      </label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.weekend}">
                      <label for="available_weekend" >
                        <small v-text="$ml.get('store.form.available.weekend')">Fim de Semana</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.weekend" id="available_weekend" value="available_weekend">
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row helps text-center">
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.anytime_hours}">
                      <label for="available_anytime_hours" >
                        <small v-text="$ml.get('store.form.available.anytime_hours')">24 horas</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.anytime_hours" id="available_anytime_hours" value="available_anytime_hours">
                      </label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.expedient}">
                      <label for="available_expedient" >
                        <small v-text="$ml.get('store.form.available.expedient')">9 ás 18h</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.expedient" id="available_expedient" value="available_expedient">
                      </label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="help featured" :class="{active: info.support.available.add_others}">
                      <label for="available_others" >
                        <small v-text="$ml.get('store.form.available.others')">Outro horário?</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.add_others" id="available_others" value="available_others">
                      </label>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-12" v-if="info.support.available.add_others">
                    <div class="form-group">
                      <input class="form-control" type="text" v-model="info.support.available.others" name="" :placeholder="$ml.get('store.form.available.others_placeholder')" value="">
                    </div>
                  </div>
                </div>

              </div>
              <div class="form-group">
                <h4>Pode receber via sistema drive-thru ?</h4>
                <small>Se aplica apenas para pontos de coletas</small>
                <br>
                <div class="row helps text-center">
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.delivery}">
                      <label for="available_delivery" >
                        <small>Sim</small>
                        <input type="checkbox" name="support[]" v-model="info.support.available.delivery" id="available_delivery" value="available_delivery">
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="check_truth checklabel" for="veracidade">
                  <input type="checkbox" id="veracidade" name="support[]" v-model="info.support.veracidade" value="">
                  <small v-text="$ml.get('sidebar.form.truth')"></small>
                </label>
              </div>
              <div class="form-group text-right">
                <button type="submit" class="btn btn-block btn-info" :disabled="!info.name"  :class="{'disabled':!info.name}" name="button">Salvar</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters, mapMutations } from 'vuex';
import { isMobile } from 'mobile-device-detect';

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

import Helper from '@src/helper'

import Map from '@components/Map'

export default {
    name: 'AddStore',
    components: {
      VuePhoneNumberInput,
      Map
    },
    data(){
      return {
        isLocated: false,
        isMobile: isMobile,
        isMapShow: false,
        info: {
          address: false,
          member: 'volunteer',
          campaign: 'movimento117',
          location: {},
          support: {
            available: {}
          }
        },

        translations: {
          countrySelectorLabel: this.$ml.get('sidebar.form.input.countrySelectorLabel'),
          countrySelectorError: this.$ml.get('sidebar.form.input.countrySelectorError'),
          phoneNumberLabel: this.$ml.get('sidebar.form.input.phoneNumberLabel'),
          example: this.$ml.get('sidebar.form.input.example')
        }
      }
    },
    created() {
      if(this.isMobile)
        this.getLocationMobile();

      if(this.getMarkerPosition().lat && this.getMarkerPosition().lng)
        this.isLocated = true
    },
    methods: {
      ...mapGetters([
        'getMarkerPosition',
      ]),
      ...mapActions([
        'actionSetNewPosition',
        'actionSetNewUserMovimento'
      ]),

      async getLocationMobile() {
        console.log('Mobile',this.isMobile);
        const payload = await Helper.locateMe()

        this.actionSetNewPosition({
          'lng': payload.coords.longitude,
          'lat': payload.coords.latitude
        });

        if(this.getMarkerPosition().lat && this.getMarkerPosition().lng)
          this.isLocated = true
      },

      async onSubmit(e) {
        e.preventDefault();

        if(this.getMarkerPosition().lat && this.getMarkerPosition().lng) {
          this.info.location.lat = this.getMarkerPosition().lat
          this.info.location.lon = this.getMarkerPosition().lng
        } else {

          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error_location'),
            type: 'warning'
          });

          this.$gtag.event('add_store', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'location'
            })

          this.isLocated = false

          return;
        }

        if(!this.info.support.central_coleta && !this.info.support.blood & !this.info.support.others) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error'),
            type: 'warning'
          });
          this.$gtag.event('add_store', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'support'
            })
          return;
        }

        if(!this.info.support.available.anytime && !this.info.support.available.anytime_hours && !this.info.support.available.week && !this.info.support.available.weekend && !this.info.support.available.expedient && !this.info.support.available.others) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error_2'),
            type: 'warning'
          });
          this.$gtag.event('add_store', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'support.available'
            })
          return;
        }

        if(!this.info.support.veracidade) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error_truth'),
            type: 'warning'
          });

          this.$gtag.event('add_store', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'check_veracidade'
            })
          return;

        }

        const payload = await axios.post('/api/saveStore', this.info)

        if(payload.data.status) {

          this.$notify({
            group: 'foo',
            title: 'Yeah!',
            text: this.$ml.get('sidebar.form.msg.success'),
            type: 'success'
          });

          this.actionSetNewUserMovimento(payload.data.data)


          this.$gtag.event('add_store', {
              'event_category': 'success',
              'event_label': 'ok_ao_inserir',
              'event_value': this.info
            })

            this.info = {location:{}, support:{}}
            this.$router.push('/movimento117');
        } else {
          this.$gtag.event('add_store', {
              'event_category': 'error',
              'event_label': 'erro_ao_inserir',
              'event_value': this.info
            })

          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: payload.data.message,
            type: 'warning',
            duration: 5000
          });
        }

        return false;
      },
      async recaptcha() {
        await this.$recaptchaLoaded()
        const token = await this.$recaptcha('login')
      },
      updatePhone(v) {
        this.info.phone = v.formattedNumber
      },
      onDragEnd(v) {
        if(this.getMarkerPosition().lat && this.getMarkerPosition().lng)
          this.isLocated = true
      },
      onResultAddress(v){
        console.log('res',v);
        this.info.address = v.place_name;
      }
    }
}
</script>
<style lang="scss">
  .fixed-map {
    position: fixed;
    width: 90%;
    visibility: hidden;
    height: 80%;
    z-index: 10;
    left: 50%;
    transform: translate(-50%);
    -webkit-box-shadow: 2px -5px 32px -13px rgba(184,184,184,1);
    -moz-box-shadow: 2px -5px 32px -13px rgba(184,184,184,1);
    box-shadow: 2px -5px 32px -13px rgba(184,184,184,1);
    overflow: hidden;
    border-radius: 15px;

    &.fixed-map-show {
    visibility: visible;
    }

    &-close {
      position: absolute;
      top: 10px;
      left: 10px;

      @media only screen and (max-width: 600px) {
        bottom: 30px;
        top: auto;
        right: 10px;
        left: auto;
      }
    }

    .location {
      top: 20px;
      bottom: auto;
      @media only screen and (max-width: 600px) {
        top: 50%;
        transform: translate(0,-50%);
        right: 10px;
      }
    }
  }

</style>
