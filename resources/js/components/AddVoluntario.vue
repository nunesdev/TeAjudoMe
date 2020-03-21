<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h3>Seus dados</h3>
          <hr>
          <!-- <GoogleLogin v-if="!isLogged" :params="params" :renderParams="renderParams" :onSuccess="onSuccess" :onFailure="onFailure"></GoogleLogin> -->

          <form  class="form-horizontal" action="/api" v-on:submit.prevent="onSubmit" method="post">
            <div class="form-group text-right" v-if="isMobile && info.name">
              <button type="submit" class="btn btn-info" :disabled="!info.name"  :class="{'disabled':!info.name}" name="button">Salvar</button>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.name" name="name" placeholder="Seu nome"  required>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.phone" name="phone" placeholder="Telefone"  required>
               <small>Pode chamar via whatsapp ? <input type="checkbox" v-model="info.whatsapp" name="" value=""> </small>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
               <input type="text" class="form-control" v-model="info.city" name="city" placeholder="Cidade" required>
            </div>
            <div class="form-group">
               <input type="text" class="form-control" v-model="info.state" name="state" placeholder="Qual o seu estado" required>
            </div>
            <div class="form-group">
              <h4>Posso ajudar com:</h4>
              <hr>
              <div class="row helps text-center">
                <div class="col-6">
                  <div class="help" :class="{active: info.support.market}">
                    <label for="market" >

                      <span class="icon-shopping-cart"></span>
                      <small>Compras</small>
                      <input type="checkbox" name="support[]" v-model="info.support.market" id="market" value="market">
                    </label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="help" :class="{active: info.support.food}">
                    <label for="food">
                      <span class="icon-location-food"></span>
                      <small>Alimentação</small>
                      <input type="checkbox" name="support[]" v-model="info.support.food" id="food" value="food">
                    </label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="help" :class="{active: info.support.talk}">
                    <label for="talk">
                      <span class="icon-conversation"></span>
                      <small>Posso conversar</small>
                      <input type="checkbox" name="support[]" v-model="info.support.talk" id="talk" value="talk">
                    </label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="help" :class="{active: info.support.health}">
                    <label for="health">
                      <span class="icon-store-front"></span>
                      <small>Farmácia</small>
                      <input type="checkbox" name="support[]" v-model="info.support.health" id="health" value="health">
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" v-if="!isMobile">
              <button type="submit" class="btn btn-info btn-block" name="button">Salvar</button>
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

export default {
    name: 'AddVoluntario',
    data(){
      return {
        isMobile: isMobile,
        info: {
          location: {},
          support: {}
        },
      }
    },
    mounted() {
      this.getMyAddress()
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
        }

        const payload = await axios.post('/api', this.info)

        if(payload.data.status) {

          this.$notify({
            group: 'foo',
            title: 'Dados inseridos',
            text: 'Obrigado por fazer parte!',
            type: 'success'
          });

          this.actionSetNewUser(payload.data)
          this.$emit('closeSidebar', false);
          this.info = {location:{}, support:{}}
        } else {
          this.$notify({
            group: 'foo',
            title: 'Ops!',
            text: payload.data.message,
            type: 'warning',
            duration: -1
          });
        }

        return false;
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
      }
    }
}
</script>
<style lang="sass" scoped>
  .form-horizontal
    .form-group
      small
        font-size: 16px
        display: block
      label
        line-height: 2rem
        display: block
    .helps
      .help
        border-radius: 4px
        margin-bottom: 20px
        cursor: pointer
        background: #3f5c88
        padding: 10px
        position: relative

        span
          font-size: 18px
        &:hover, &.active
          background: #00bc99
        input
          opacity: 0
          height: 0
          width: 0
          position: absolute

</style>
