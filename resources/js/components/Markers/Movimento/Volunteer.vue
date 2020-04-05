<template>
  <div class="">

    <MglPopup>
      <div class="popup text-center">


        <div class="text-center">Voluntário(a)</div>


        <div class="popup-head row align-items-center">
          <h3 class="col-11">{{item.name}}</h3>
        </div>
        <span v-if="item.options && item.options.psicologo && item.options.document"> {{item.options.document}} <img  src="/images/verified.png" width="16" height="16" alt=""></span>

        <h4 v-text="$ml.get('home.map.popup.talk_to')"></h4>

        <span v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
        <span v-if="item.phone"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
        <span v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>

        
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
