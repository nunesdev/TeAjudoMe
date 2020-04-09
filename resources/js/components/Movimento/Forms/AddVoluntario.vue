<template>
    <div class="">
      <div class="row justify-content-center">

        <div
          :class="{
            'col-md-7 col-sm-12 full-height':!isMobile,
            'fixed-map':isMobile,
            'fixed-map-show':isMapShow
            }">
          <Map @onDragEnd="onDragEnd"></Map>
          <div class="fixed-map-close" v-if="isMobile">
            <a @click="isMapShow = false" class="btn btn-showmap">Fechar</a>
          </div>
        </div>

        <div class="col-md-5 col-sm-12">
          <div class="container">
            <div class="overlay" v-if="!isLocated">
              <span v-text="$ml.get('sidebar.form.msg.error_location')"></span>
            </div>
            <div class="text-left">
              <router-link v-if="isMobile" class="btn btn-showmap" to="/movimento117"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
            </div>
            <h3 v-text="$ml.get('sidebar.title')"></h3>
            <small style="line-height:18px">É importante a sua localização, não precisa ser exata, pode ser aproximada.</small>
            <hr>

            <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">
              <div class="form-group" v-if="isMobile">
                <a class="btn btn-sm white btn-success" @click="isMapShow = !isMapShow">Adicionar endereço(localização)</a>
                 <!-- <input type="text" class="form-control" id="address" v-model="info.address" name="address" :placeholder="$ml.get('store.form.address')" required> -->
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.name" name="name" :placeholder="$ml.get('sidebar.form.name')"  required>
              </div>
              <div class="form-group">
                 <VuePhoneNumberInput @update="updatePhone" :translations="translations"  v-model="info.phone_" required />
                 <small><span v-text="$ml.get('sidebar.form.whatsapp')"></span>  <input type="checkbox" v-model="info.whatsapp" name="" value=""> </small>
              </div>
              <div class="form-group">
                 <input type="email" class="form-control" v-model="info.email" name="email" :placeholder="$ml.get('sidebar.form.email')" required>
              </div>

              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.city" name="city" :placeholder="$ml.get('sidebar.form.city')" required>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.state" name="state" :placeholder="$ml.get('sidebar.form.state')" required>
              </div>
              <div class="form-group">
                <h4 v-text="$ml.get('sidebar.form.subtitle')"></h4>
                <hr>

                <div class="row helps text-center">

                  <div class="col-md-6 col-sm-12 ">
                    <div class="help" :class="{active: info.support.food}">
                      <label for="m_food">
                        <span>
                          <img src="/images/movimento/caixa.png" width="32" height="32" alt="">
                        </span>
                        <small>Coletar doações de alimentos</small>
                        <input type="checkbox" name="support[]" v-model="info.support.food" id="m_food" value="food">
                      </label>

                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 ">
                    <div class="help" :class="{active: info.support.blood}">
                      <label for="blood">
                        <span>
                          <img src="/images/movimento/doacao.png" width="32" height="32" alt="">
                        </span>
                        <small>Doar sangue</small>
                        <input type="checkbox" name="support[]" v-model="info.support.blood" id="blood" value="blood">
                      </label>

                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 ">
                    <div class="help" :class="{active: info.support.dia_d}">
                      <label for="dia_d">
                        <span>
                          <img src="/images/movimento/socorro.png" width="32" height="32" alt="">
                        </span>
                        <small>Participar do dia D</small>
                        <input type="checkbox" name="support[]" v-model="info.support.dia_d" id="dia_d" value="dia_d">
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
import GoogleLogin from 'vue-google-login';

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

import Helper from '@src/helper'
import Avatars from '@store/jsons/avatar.json'

import Map from '@components/Map'

export default {
    name: 'AddVoluntario',
    components: {
      GoogleLogin,
      VuePhoneNumberInput,
      Map
    },
    data(){
      return {
        isLocated: false,
        isMobile: isMobile,
        isMapShow: false,
        info: {
          campaign: 'movimento117',
          type: 'volunteer',
          location: {},
          support: {}
        },

        translations: {
          countrySelectorLabel: this.$ml.get('sidebar.form.input.countrySelectorLabel'),
          countrySelectorError: this.$ml.get('sidebar.form.input.countrySelectorError'),
          phoneNumberLabel: this.$ml.get('sidebar.form.input.phoneNumberLabel'),
          example: this.$ml.get('sidebar.form.input.example')
        },
        avatars: Avatars,
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
          this.$gtag.event('add_voluntario_movimento117', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'location'
            })

          this.isLocated = false
          return;
        }

        if(!this.info.support.market && !this.info.support.food && !this.info.support.health && !this.info.support.talk) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error'),
            type: 'warning'
          });
          this.$gtag.event('add_voluntario_movimento117', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'support'
            })
          return;
        }

        if(this.info.support.psicologo && !this.info.support.document) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error_document'),
            type: 'warning'
          });
          this.$gtag.event('add_voluntario_movimento117', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'document'
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

          this.$gtag.event('add_voluntario_movimento117', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'check_veracidade'
            })
          return;

        }

        const payload = await axios.post('/api', this.info)

        if(payload.data.status) {

          this.$notify({
            group: 'foo',
            title: 'Yeah!',
            text: 'obrigado por fazer parte!',
            type: 'success'
          });

          this.actionSetNewUserMovimento(payload.data.data)
          this.$gtag.event('add_voluntario_movimento117', {
              'event_category': 'success',
              'event_label': 'ok_ao_inserir',
              'event_value': this.info
            })

            this.info = {location:{}, support:{}}

            this.$router.push('/movimento117');
        } else {
          this.$gtag.event('add_voluntario_movimento117', {
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
    }

    .location {
      top: 20px;
      bottom: auto;
    }
  }

</style>
