<template>
  <div class="">
    <MglPopup>
      <div class="popup text-center">

        <img src="/images/movimento/caixa.png" width="48" height="48" alt="">

        <div class="popup-head row align-items-center">
          <h3 class="col-11">{{item.name}}</h3>
        </div>

        <h4 v-text="$ml.get('home.map.popup.talk_to')"></h4>

        <span v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
        <span v-if="item.phone"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
        <span v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>

        <div class="support"  v-if="item.options">

          <div v-if="item.options.others">
            <hr>
            <p v-text="item.options.others"></p>
          </div>
        </div>
        <div class="actions">
          <div @click="collect = !collect" class="btn btn-primary" :class="{'btn-active': collect}">
            <small>{{collect ? 'Concluir Coleta':'Coletar Doação'}}</small>
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
