<template>
    <div class="">
      <div class="row justify-content-center">
        <div :class="{
          'col-md-7 col-sm-12 full-height':!isMobile,
          'fixed-map':isMobile,
          'fixed-map-show':isMapShow
          }">
          <Map @onDragEnd="onDragEnd"  @onResult="onResultAddress"></Map>
          <div class="fixed-map-close" v-if="isMobile">
            <a @click="isMapShow = false" class="btn btn-showmap">Ok, feito</a>
          </div>
        </div>
        <div class="col-md-5 col-sm-12">
          <div class="container">
            <div class="overlay" v-if="!isLocated">
              <span v-text="$ml.get('sidebar.form.msg.error_location')"></span>
            </div>
            <div class="text-right">
              <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'Movimento117' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
            </div>
            <h3 v-text="$ml.get('sidebar.title')"></h3>
            <small style="line-height:18px">
              Você pode doar alimentos e/ou doar algum valor, fique à vontade. Ao doar alimentos, será necessário preencher os dados, para que um voluntário
              próximo à você, possa entrar em contato para retirar.
            </small>
            <hr>

            <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">
              <div class="form-group">

                <div class="row helps text-center">


                  <div class="col-md-6 col-sm-12 " v-if="!campaign_focus">
                    <div class="help" :class="{active: info.support.money}">
                      <label for="paypal">
                        <span>
                          <img src="/images/movimento/doacao_money.png" width="32" height="32" alt="">
                        </span>
                        <small>Doar via transferência</small>
                        <input type="checkbox" name="support[]" v-model="info.support.money" id="paypal" value="paypal">
                      </label>
                    </div>

                  </div>
                  <div class="col-md-6 col-sm-12 ">
                    <div class="help" :class="{active: info.support.food}">
                      <label for="food">
                        <span>
                          <img src="/images/movimento/caixa.png" width="32" height="32" alt="">
                        </span>
                        <small>Doar alimentos</small>
                        <input type="checkbox" name="support[]" v-model="info.support.food" id="food" value="food">
                      </label>
                    </div>
                  </div>

                  <div class="col-12" v-if="info.support.money">
                    <div class="card">
                      <div class="row no-gutters align-items-center">
                        <!-- <div class="col-md-6 col-sm-12 ">
                          <span> <img src="/images/movimento/paypal.png" width="32" height="32" alt=""> </span>
                          <p>
                            Via paypal: <br/>paulista@teste.com
                          </p>
                        </div> -->
                        <div class="col-md-6 col-sm-12 ">
                          <span> <img src="/images/movimento/pagar.png" width="32" height="32" alt=""> </span>
                          <p>
                            Via transferência:<br/>
                            <small><b>Banco Bradesco - Agência: 3368-5</b></small>
                            <small><b>Conta corrente: 16600-6</b></small>
                            <small><b>União Central Brasileira da Igreja Adventista do Sétimo dia</b></small>
                            <small><b>CNPJ: 55.233.019/0001-70</b></small>
                            <small>É importante que você envie o comprovante para jovens.ap@outlook.com</small>
                          </p>
                        </div>
                      </div>
                    </div>
                    <small><label for="doacao_publica"> <input id="doacao_publica" type="checkbox" v-model="info.support.public_donate" name="" value=""> <span>Quer inserir sua doação no mapa?  O valor da doação não será exibido.</span> </label> </small>
                  </div>

                </div>
              </div>

              <div class="" v-if="info.support.food || info.support.public_donate">
                <div class="form-group" v-if="isMobile">
                  <a class="btn btn-sm white btn-success" @click="isMapShow = !isMapShow">Adicionar endereço (localização)</a>
                </div>
                <div class="form-group" v-if="info.address && isMobile">
                  <input type="text"  class="form-control" v-model="info.address" name="address" disabled>
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
                <div class="form-group" v-if="info.address && !isMobile">
                  <input type="text"  class="form-control" v-model="info.address" name="address" disabled>
                </div>
                <div class="form-group">
                   <input type="text" class="form-control" v-model="info.city" name="city" :placeholder="$ml.get('sidebar.form.city')" required>
                </div>
                <div class="form-group">
                   <input type="text" class="form-control" v-model="info.state" name="state" :placeholder="$ml.get('sidebar.form.state')" required>
                </div>
                <div class="form-group text-left">
                  <label for="">Observações</label>
                  <input type="text" class="form-control" name="" v-model="info.support.others" value="">
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
        isMapShow: false,
        campaign_focus: false,
        info: {
          address: false,
          campaign: 'movimento117',
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
    mounted(){
      if(this.$router.currentRoute.query && this.$router.currentRoute.query.campaign) {
        this.campaign_focus = true
        this.info.support.campaign_focus =  true;
      }
    },
    methods: {
      ...mapGetters([
        'getMarkerPosition',
      ]),
      ...mapActions([
        'actionSetNewUserMovimento',
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

          this.$gtag.event('add_member_movimento_117', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'location'
            })

          this.isLocated = false

          return;
        }

        if(!this.info.support.market && !this.info.support.food && !this.info.support.health && !this.info.support.talk && !this.info.support.money) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error'),
            type: 'warning'
          });
          this.$gtag.event('add_member_movimento_117', {
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

          this.$gtag.event('add_member_movimento_117', {
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

          this.actionSetNewUserMovimento(payload.data.data)
          this.$gtag.event('add_member_movimento_117', {
              'event_category': 'success',
              'event_label': 'ok_ao_inserir',
              'event_value': this.info
            })
            this.sendTagHash();
            this.info = {location:{}, support:{}}
            this.$router.push('/movimento117');
        } else {
          this.$gtag.event('add_member_movimento_117', {
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
      },
      sendTagHash() {
        var OneSignal = self.OneSignal || [];
        var UData = {
          "name":this.info.name,
          "city":this.info.city,
          "state":this.info.state,
          "phone":this.info.phone,
          "type":this.info.type,
          "food": this.info.support.blood ? true : false,
        }

        if (OneSignal && UData !== '') {
          console.log('OneSignal UData: ', UData);
          OneSignal.push(function() {
            OneSignal.sendTag("user_name", UData.name);
            OneSignal.sendTag("user_city", UData.city);
            OneSignal.sendTag("user_state", UData.state);
            OneSignal.sendTag("user_phone", UData.phone);
            OneSignal.sendTag("u_user_type", UData.type);
            OneSignal.sendTag("m_user_food", UData.food);
          })
        }
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

  .card {
    padding: 10px;
  }

</style>
