<template>
    <div class="">
      <div class="row justify-content-center">
        <div class="col-7">
          <Map @onDragEnd="onDragEnd"></Map>
        </div>
        <div class="col-5">
          <div class="container">
            <div class="overlay" v-if="!isLocated">
              <span v-text="$ml.get('sidebar.form.msg.error_location')"></span>
            </div>
            <h3 v-text="$ml.get('store.title')"></h3>
            <hr>

            <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">
              <div class="form-group text-right" v-if="info.name">
                <button type="submit" class="btn btn-info" :disabled="!info.name"  :class="{'disabled':!info.name}" name="button">Salvar</button>
              </div>

              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.name" name="name" :placeholder="$ml.get('store.form.name')"  required>
                 <small>ex: Mercadinho do seu Zé</small>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.support.owner" name="owner" :placeholder="$ml.get('store.form.owner')"  required>
              </div>
              <div class="form-group">
                <VuePhoneNumberInput @update="updatePhone" :translations="translations"  v-model="info.phone_" required />
                 <small><span v-text="$ml.get('sidebar.form.whatsapp')"></span>  <input type="checkbox" v-model="info.whatsapp" name="" value=""> </small>
              </div>
              <div class="form-group">
                 <input type="email" class="form-control" v-model="info.email" name="creditcard" :placeholder="$ml.get('sidebar.form.email')">
              </div>

              <div class="form-group">
                 <input type="text" class="form-control" id="address" v-model="info.address" name="address" :placeholder="$ml.get('store.form.address')" required>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.city" name="city" :placeholder="$ml.get('sidebar.form.city')" required>
              </div>
              <div class="form-group">
                 <input type="text" class="form-control" v-model="info.state" name="state" :placeholder="$ml.get('sidebar.form.state')" required>
              </div>
              <div class="form-group">
                <h4 v-text="$ml.get('store.form.subtitle')"></h4>
                <hr>

                <div class="row helps text-center">
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.market}">
                      <label for="s_market" >

                        <span class="icon-shopping-cart"></span>
                        <small v-text="$ml.get('store.form.help.market')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.market" id="s_market" value="market">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.food}">
                      <label for="s_food">
                        <span class="icon-location-food"></span>
                        <small v-text="$ml.get('store.form.help.food')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.food" id="s_food" value="food">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.market_garden}">
                      <label for="market_garden">
                        <span class="icon-location-food"></span>
                        <small v-text="$ml.get('store.form.help.market_garden')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.market_garden" id="market_garden" value="market_garden">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.health}">
                      <label for="s_health">
                        <span class="icon-store-front"></span>
                        <small v-text="$ml.get('store.form.help.health')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.health" id="s_health" value="health">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help" :class="{active: info.support.mechanical}">
                      <label for="mechanical">
                        <span class="icon-cogs"></span>
                        <small v-text="$ml.get('store.form.help.mechanical')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.mechanical" id="mechanical" value="mechanical">
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="help featured" :class="{active: info.support.add_others}">
                      <label for="others">
                        <span class="icon-add-outline"></span>
                        <small v-text="$ml.get('store.form.help.others')"></small>
                        <input type="checkbox" name="support[]" v-model="info.support.add_others" id="others" value="others">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12" v-if="info.support.add_others">
                    <div class="form-group">
                      <input class="form-control" type="text" v-model="info.support.others" name="" :placeholder="$ml.get('store.form.help.others_placeholder')" value="">
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
                <h4 v-text="$ml.get('store.form.available.title_2')"></h4>
                <hr>
                <div class="row helps text-center">
                  <div class="col">
                    <div class="help" :class="{active: info.support.available.delivery}">
                      <label for="available_delivery" >
                        <small v-text="$ml.get('store.form.available.delivery')">Delivery</small>
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
        info: {
          member: 'volunteer',
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

        if(!this.info.support.market && !this.info.support.food && !this.info.support.health && !this.info.support.mechanical && !this.info.support.others) {
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

        if(this.info.support.psicologo && !this.info.support.document) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error_document'),
            type: 'warning'
          });
          this.$gtag.event('add_store', {
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

          this.actionSetNewUser(payload.data)
          this.$router.push('/');

          this.$gtag.event('add_store', {
              'event_category': 'success',
              'event_label': 'ok_ao_inserir',
              'event_value': this.info
            })

            this.info = {location:{}, support:{}}
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
      }
    }
}
</script>
<style lang="sass" scoped>


</style>
