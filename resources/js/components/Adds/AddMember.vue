<template>
    <div class="">
      <div class="row justify-content-center">
        <div v-if="!isMobile" class="col-md-7 col-sm-12">
          <Map @onDragEnd="onDragEnd"></Map>
        </div>
        <div class="col-md-5 col-sm-12">
          <div class="container">
            <div class="overlay" v-if="!isLocated">
              <span v-text="$ml.get('sidebar.form.msg.error_location')"></span>
            </div>
            <div class="text-left">
              <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'home' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
            </div>
            <h3 v-text="$ml.get('sidebar.title')"></h3>
            <hr>

            <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">
              <div class="form-group text-right" v-if="info.name">
                <button type="submit" class="btn btn-block btn-info" :disabled="!info.name"  :class="{'disabled':!info.name}" name="button">Salvar</button>
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
                <h4 v-text="$ml.get('sidebar.form.subtitle_2')">Preciso de ajuda com:</h4>
                <hr>

                <div class="row helps text-center">
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.market}">
                      <label for="market" >

                        <span class="icon-shopping-cart"></span>
                        <small v-text="$ml.get('sidebar.form.help.market')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.market" id="market" value="market">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.food}">
                      <label for="food">
                        <span class="icon-location-food"></span>
                        <small v-text="$ml.get('sidebar.form.help.food')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.food" id="food" value="food">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.talk}">
                      <label for="talk">
                        <span class="icon-conversation"></span>
                        <small v-text="$ml.get('sidebar.form.help.talk_2')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.talk" id="talk" value="talk">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.health}">
                      <label for="health">
                        <span class="icon-store-front"></span>
                        <small v-text="$ml.get('sidebar.form.help.health')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.health" id="health" value="health">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.dog}">
                      <label for="dog">
                        <span>
                          <svg version="1.0" viewBox="0 0 1 1" xmlns="http://www.w3.org/2000/svg">
                          <g transform="matrix(1.6886 0 0 1.6886 -.40426 .14628)" fill="#1e1916" stroke-miterlimit="10.433" stroke-width="0">
                          <path fill="currentColor" d="m0.675 0.44929l-0.0028993 4.1666e-4 -0.0027951 3.6458e-4 -0.002691 2.9514e-4 -0.0025694 2.2569e-4 -0.0025 1.7361e-4 -0.0023785 1.0417e-4 -0.0022916 5.208e-5h-0.0022048l-0.0021007-6.944e-5 -0.0020139-1.2153e-4 -0.0019271-1.7361e-4 -0.0018403-2.2569e-4 -0.0017708-2.9514e-4 -0.0016666-3.2986e-4 -0.0015972-3.8194e-4 -0.0015104-4.3402e-4 -0.001441-4.8611e-4 -0.0013715-5.3819e-4 -0.0012847-5.9028e-4 -0.0012326-6.2499e-4 -0.0011458-6.7708e-4 -0.0010937-7.2916e-4 -0.0010243-7.6389e-4 -9.5485e-4 -8.1596e-4 -9.0277e-4 -8.5069e-4 -8.3333e-4 -9.0278e-4 -7.8125e-4 -9.3749e-4 -7.2916e-4 -9.7222e-4 -6.7708e-4 -0.0010243-6.2499e-4 -0.001059-0.0010938-0.0022222-9.2013e-4 -0.0023611-7.4652e-4 -0.0025-6.0764e-4 -0.0026215-4.6875e-4 -0.0027604-3.2985e-4 -0.0028646-2.4306e-4 -0.0029687-1.5625e-4 -0.0030729-8.68e-5 -0.0031771-1.736e-5 -0.0032465 3.472e-5 -0.0033333 3.472e-5 -0.0034028 6.944e-5 -0.0034548 8.681e-5 -0.007118 1.736e-5 -0.0036111-0.0038021-0.080329-0.015833 0.074166c-0.0033333 0.01375-0.0070833 0.026666 0.012917 0.037083 0.014167 0.012517-0.0016666 0.0296-0.017083 0.027517-0.04625 0.0016493-0.039583-0.029166-0.035416-0.05085l0.0025-0.031666 0.0075-0.064583-0.00625-0.01625c-0.050416-0.012917-0.084583-0.0225-0.12333-0.043333l-0.0275 0.00375c-0.012917 0.0020833-0.0095833 0.016667-0.010833 0.02625l-0.0041666 0.026267-0.022917 0.059583-0.0016666 0.0049826c-0.0016667 0.0041666-0.00125 0.020417 0.0045833 0.02875l0.0125 0.025017c0.0091666 0.013733 0.011667 0.048732-0.014167 0.037482h4.1666e-4l-0.019167-0.0079166c-0.01375-0.0058159-0.025-0.043732-0.03-0.071232l8.3333e-4 -0.039184c-0.012083-0.003316-0.017083 0.06625-0.012083 0.08085l0.012083 0.036232c0.0033333 0.011667-0.010417 0.015851-0.02 0.015851-0.0225 0-0.0325-0.022934-0.037083-0.0421l-0.0033333-0.014583c-0.0058333-0.022083-0.0029166-0.055833 0.0083333-0.075416l0.0058333-0.012083c0.0095833-0.024167-0.0029166-0.04125-0.0058333-0.05375-0.0095833-0.039166-0.0175-0.077083 0.0095833-0.11458l0.0025-0.0028993c-0.00125-0.002934-0.0091666-0.0091666-0.01375-0.023767-0.010417-0.033333-0.019583-0.087916-0.0066666-0.087916l0.0087499-4.1666e-4c0.021667 0 0.015 0.089999 0.04125 0.084166l0.1875 0.0020833 0.033333-0.0091492c0.011667-0.0033507 0.022083-0.010851 0.032916-0.017517l0.021667-0.013333c0.024167 0.024583 0.045833 0.04 0.081249 0.052916 0.0095833 0.073333-0.00125 0.0896-0.010417 0.13333l-0.0033333 0.017917c-0.0070833 0.031267-0.0091666 0.06375-0.0075 0.096249l8.3332e-4 0.015c-8.3332e-4 0.015417 0.0083333 0.016684 0.020417 0.020434 0.0079166 0.0041493 0.013333 0.019566-0.0020833 0.027066h4.1666e-4 -4.1666e-4z"/>
                          <path fill="currentColor" d="m0.715 1.2913e-4l9.375e-4 6.9444e-4 9.7221e-4 6.9444e-4 0.0019618 0.0015104 0.0020312 0.0016146 0.002066 0.0017187 0.0021007 0.0018055 0.002118 0.001875 0.0021528 0.0019444 0.0021701 0.0019965 0.0021701 0.002066 0.0021701 0.0020833 0.0042882 0.0042708 0.0021007 0.0021528 0.0020833 0.0021528 0.0020312 0.0021354 0.0019792 0.0021354 0.013333 0.014149c0.0083333 0.0087499 0.02125 0.0075 0.0325 0.0099999l0.0045833 4.1666e-4c0.012083 0.006684 0.0083333 0.020017 0.0041666 0.03l-0.0025 0.0062673c-0.012083 0.028732-0.047083 0.030816-0.072083 0.017483l-0.010833-0.0058333h-0.00375l-0.0079166 5e-3 -0.015417 0.012517c-0.0325-0.014167-0.05875-0.03085-0.079583-0.05335l0.048333-0.060833 0.01625-0.023333 0.0033333-0.0079166 0.00375-0.0087326s0.015-0.018767 0.02375-0.015017c0.0087499 0.0037673 0.014167 0.02 0.012083 0.028333l-0.0025 0.0099999-8.3333e-4 0.0099999h4.1667e-4"/>
                          </g>
                          </svg>

                        </span>
                        <small v-text="$ml.get('sidebar.form.help.dog')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.dog" id="dog" value="dog">
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group text-left">
                      <label for="" v-text="$ml.get('sidebar.form.help.others')"></label>
                      <input type="text" class="form-control" name="" v-model="info.support.others" value="">
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

import Helper from '../../helper'

import Map from '@components/Map'

export default {
    name: 'AddMember',
    components: {
      GoogleLogin,
      VuePhoneNumberInput,
      Map
    },
    data(){
      return {
        isLocated: false,
        isMobile: isMobile,
        info: {
          type: 'user',
          location: {},
          support: {}
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
        'actionSetNewUser',
        'actionSetNewPosition'
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

          this.$gtag.event('add_member', {
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
          this.$gtag.event('add_member', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'support'
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

          this.$gtag.event('add_member', {
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
            title: 'Pronto!',
            text: this.$ml.get('sidebar.form.msg.success_2'),
            type: 'success'
          });

          this.actionSetNewUser(payload.data.data)
          this.$router.push('/');

          this.$gtag.event('add_member', {
              'event_category': 'success',
              'event_label': 'ok_ao_inserir',
              'event_value': this.info
            })

            this.info = {location:{}, support:{}}
        } else {
          this.$gtag.event('add_member', {
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
<style lang="sass" scoped>


</style>
