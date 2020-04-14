<template>
  <div class="">
    <modal class="select-campaign" :width="modalWidth"  height="auto" :adaptive="true" name="modal-notifications">
      <div class="modal-header justify-content-center">
        <h3 >Ação 1+1!</h3>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-12 pb pt select-campaign-item">
            <div class="text-center">
              <img src="/images/movimento/user.png" width="64" alt="">
            </div>
            <div class="pt-2">
              <h4>Hey! Que bom que você está aqui! Temos uma ação para você, e aí bora?</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"  @click="aceito()" class="btn btn-block btn-info" name="button">Aceito!</button>
      </div>
    </modal>

    <modal class="select-campaign" :width="modalWidth" height="auto" :adaptive="true" name="modal-notifications-2">
      <div class="modal-header justify-content-center">
        <h3 >Ação 1+1!</h3>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-12 pb pt select-campaign-item">
            <div class="text-center">
              <img src="/images/movimento/user_blood.png" width="64" alt="">
            </div>
            <div class="pt-2">
              <h4>Somos +50 voluntários no movimento, mas podemos ser 100 ou mais!</h4>
              <p> Vamos precisar de bastante gente nos próximos dias, que tal mandar esse link para um amigo seu que ainda não se cadastrou ? </p>
            </div>
            <div class="panel" style="background:aliceblue">
              https://bit.ly/2xqNrIR
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" @click="deixaComigo" class="btn btn-block btn-info" name="button">Deixa comigo!</button>
      </div>
    </modal>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect'
export default {
  data() {
    return {
      modalWidth: isMobile ? '90%' : 500,
      actions: ['action_1']
    }
  },
  mounted() {
    const notified = this.$cookies.get('_tanotify') ? this.$cookies.get('_tanotify')  : false

    if(notified && !notified.includes('action_1')) {
      this.$modal.show('modal-notifications');
    }

    if(notified && notified.includes('action_1')) {
      this.$router.push('/movimento117')
    }

    if(!notified) {
      this.$modal.show('modal-notifications');
    }
  },
  methods: {
    aceito(){
      this.$modal.hide('modal-notifications');
      this.$modal.show('modal-notifications-2');

      this.$gtag.event('movimento_notificacoes', {
          'event_category': 'acao',
          'event_label': 'acao_1',
          'event_value': 'aceito'
        })
    },
    deixaComigo() {
      this.$modal.hide('modal-notifications-2');
      this.$cookies.set('_tanotify',['action_1'])

      this.$gtag.event('movimento_notificacoes', {
          'event_category': 'acao',
          'event_label': 'acao_1',
          'event_value': 'deixa_comigo'
        })

      this.$router.push('/movimento117')
    }
  }
}
</script>

<style lang="css">
</style>
