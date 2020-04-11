<template>
  <div class="">

    <MglPopup>
      <div class="popup text-center">


        <img v-if="!item.options.blood && !item.options.regional" src="/images/movimento/user.png" width="48" height="48" alt="">
        <img v-if="item.options.blood && !item.options.regional" src="/images/movimento/user_blood.png" width="48" height="48" alt="">
        <img v-if="!item.options.blood && item.options.regional" src="/images/movimento/user_regional.png" width="48" height="48" alt="">
        <div v-if="item.options.regional" class="">
          <small>Regional</small>
        </div>


        <div class="popup-head row align-items-center">
          <h3 class="col-11">{{item.name}}</h3>
        </div>
        <span v-if="item.options && item.options.psicologo && item.options.document"> {{item.options.document}} <img  src="/images/verified.png" width="16" height="16" alt=""></span>

        <h4 v-text="$ml.get('home.map.popup.talk_to')"></h4>

        <span v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
        <span v-if="item.phone"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
        <span v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>

        <div class="support"  v-if="item.options">
          <h4>Posso ajudar com</h4>

          <div>
            <span v-if="item.options.food">
              <small>Coletar doações</small>
            </span>
            <span v-if="item.options.blood">
              <small>Doar sangue</small>
            </span>
            <!-- <span v-if="item.options.dia_d">
              <small>Participar do dia D</small>
            </span> -->
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
  components :{ MglPopup }
}
</script>

<style lang="css">
</style>
