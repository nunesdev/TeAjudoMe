<template>
  <div class="">
    <MglPopup>
      <div class="popup text-center">

        <img v-if="!item.options.money" src="/images/movimento/caixa.png" width="48" height="48" alt="">
        <img v-if="item.options.money" src="/images/movimento/doacao_money.png" width="48" height="48" alt="">

        <div class="popup-head row align-items-center">
          <h3 class="col-11">{{item.name}}</h3>
        </div>

        <h4  v-if="item.options && !item.options.money" v-text="$ml.get('home.map.popup.talk_to')"></h4>

        <span v-if="item.email && !item.options.money"><a :href="`mailto:${item.email}`"> Email </a></span>
        <span v-if="item.phone && !item.options.money"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
        <span v-if="item.whatsapp && !item.options.money"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>

        <div class="support" v-if="item.options && !item.options.money">

          <div v-if="item.options.others">
            <hr>
            <p v-text="item.options.others"></p>
          </div>
        </div>
        <div class="actions" v-if="item.options.campaign_focus">
          <div class="btn btn-active btn-primary">
            <small>Bruno é o responsável.</small>
            <img src="/images/movimento/caixa.png" width="22" alt="">
          </div>
        </div>
      </div>
    </MglPopup>
  </div>
</template>

<script>
import { MglPopup } from "vue-mapbox";
export default {
  props: ['item'],
  components :{ MglPopup },
  data() {
    return {
      collect: false,
    }
  }
}
</script>

<style lang="scss" scoped>
.btn-info {
  &.btn-active {
    background: #0eca4c;
  }
}
</style>
