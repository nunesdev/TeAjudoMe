<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h3 v-text="$ml.get('sidebar.title')"></h3>
          <hr>
          <!-- <div class="" v-if="!isLogged">
            <GoogleLogin  :params="params" :renderParams="renderParams" :onSuccess="onSuccess" :onFailure="onFailure"></GoogleLogin>
            <hr>
          </div> -->

          <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">
            <div class="form-group text-right" v-if="isMobile && info.name">
              <button type="submit" class="btn btn-block btn-info" :disabled="!info.name"  :class="{'disabled':!info.name}" name="button">Salvar</button>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.name" name="name" :placeholder="$ml.get('sidebar.form.name')"  required>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.phone" name="phone" :placeholder="$ml.get('sidebar.form.phone')"  required>
               <small><span v-text="$ml.get('sidebar.form.whatsapp')"></span>  <input type="checkbox" v-model="info.whatsapp" name="" value=""> </small>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.email" name="email" :placeholder="$ml.get('sidebar.form.email')" required>
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
              <div class="row">
                <div class="col-12">
                  <label for="psicologo" class="checklabel">
                    <input  type="checkbox" id="psicologo" v-model="info.support.psicologo" name="" value="">
                    <small v-text="$ml.get('sidebar.form.i_am_doctor')"></small>
                  </label>
                </div>
                <div class="col-12" v-if="info.support.psicologo">
                  <div class="form-group">
                    <input class="form-control" type="text" v-model="info.support.document" name="" :placeholder="$ml.get('sidebar.form.document')" value="">
                  </div>
                </div>

              </div>
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
                      <small v-text="$ml.get('sidebar.form.help.talk')"></small>
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
              </div>
            </div>
            <div class="form-group">
              <label class="check_truth checklabel" for="veracidade">
                <input type="checkbox" id="veracidade" name="support[]" v-model="info.support.veracidade" value="">
                <small v-text="$ml.get('sidebar.form.truth')"></small>
              </label>
            </div>
            <div class="form-group" v-if="!isMobile">
              <button type="submit" class="btn btn-info btn-block" name="button" v-text="$ml.get('sidebar.form.save')"></button>
            </div>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters, mapMutations } from 'vuex';
import { isMobile } from 'mobile-device-detect';
import GoogleLogin from 'vue-google-login';

export default {
    name: 'AddVoluntario',
    components: {
      GoogleLogin
    },
    data(){
      return {
      //  isLogged: this.$cookies.get('ta_isLogged') ? true : false,
        isMobile: isMobile,
        info: {
          location: {},
          support: {}
        },
        params: {
          client_id: "755820160001-ciatl4bnkdt40a32ajb9n1l5p9ugh9jn.apps.googleusercontent.com"
        },
        renderParams: {
          width: 250,
          height: 50,
          longtitle: true
        }
      }
    },
    mounted() {
      this.getMyData()
    },
    computed: {

    },
    methods: {
      ...mapGetters([
        'getMarkerPosition',
      ]),
      ...mapActions([
        'actionSetNewUser',
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
          this.$gtag.event('add_voluntario', {
              'event_category': 'warning',
              'event_label': 'field',
              'event_value': 'location'
            })
          return;
        }

        if(!this.info.support.market && !this.info.support.food && !this.info.support.health && !this.info.support.talk) {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: this.$ml.get('sidebar.form.msg.error'),
            type: 'warning'
          });
          this.$gtag.event('add_voluntario', {
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
          this.$gtag.event('add_voluntario', {
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

          this.$gtag.event('add_voluntario', {
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
            text: this.$ml.get('sidebar.form.msg.success'),
            type: 'success'
          });

          this.actionSetNewUser(payload.data)
          this.$emit('closeSidebar', false);

          this.$gtag.event('add_voluntario', {
              'event_category': 'success',
              'event_label': 'ok_ao_inserir',
              'event_value': this.info
            })

            this.info = {location:{}, support:{}}
        } else {
          this.$gtag.event('add_voluntario', {
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
      getMyData() {
        // const data = this.$cookies.get('ta_isLogged');
        // this.info = data;
      },
      async getMyAddress() {
         const payload = await axios.get('https://cors-anywhere.herokuapp.com/http://ip-api.com/json?lang=pt-BR')

         if(payload.data.status === 'success') {
           this.info.city = payload.data.city;
           this.info.state = payload.data.regionName;
           this.info.location = payload.data;
         }
      },
      async recaptcha() {
        // (optional) Wait until recaptcha has been loaded.
        await this.$recaptchaLoaded()

        // Execute reCAPTCHA with action "login".
        const token = await this.$recaptcha('login')

        // Do stuff with the received token.
      },
      onSuccess(googleUser) {
        this.isLogged = true

        this.info.email = googleUser.getBasicProfile().zu
        this.info.name = googleUser.getBasicProfile().Ad

        this.$cookies.set('ta_isLogged', this.info)
      },
      onFailure() {

      }
    }
}
</script>
<style lang="sass" scoped>
  .form-horizontal
    .form-group
      .form-control
        @media only screen and (max-width: 600px)
          font-size: 14px
      small
        font-size: 15px
        display: block
        @media only screen and (max-width: 600px)
          font-size: 12px
      label
        line-height: 1rem
        display: block
    .helps
      .help
        border-radius: 4px
        margin-bottom: 12px
        cursor: pointer
        background: #3f5c88
        padding: 10px
        position: relative

        span
          font-size: 16px
        &.active
          background: #00bc99
        input
          opacity: 0
          height: 0
          width: 0
          position: absolute

</style>
