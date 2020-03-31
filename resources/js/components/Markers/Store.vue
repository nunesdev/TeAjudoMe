<template>
  <div class="store">
    <MglPopup>
      <div class="popup text-center">
        <div class="">Pequeno Negócio</div>


        <div class="popup-head row align-items-center">
          <h3 class="col-11">{{item.name}}</h3>
        </div>

        <div class="support"  v-if="item.options">
          <div>
            <span v-if="item.options.market">
              <i class="icon-shopping-cart"></i>
              <small v-text="$ml.get('store.form.help.market')"></small>
            </span>

            <span v-if="item.options.health">
              <i class="icon-store-front"></i>
              <small v-text="$ml.get('store.form.help.health')"></small>
            </span>
            <span v-if="item.options.mechanical">
              <i class="icon-cogs"></i>
              <small v-text="$ml.get('store.form.help.mechanical')"></small>
            </span>
            <span v-if="item.options.market_garden">
              <i class="icon-location-food"></i>
              <small v-text="$ml.get('store.form.help.market_garden')"></small>
            </span>
            <span v-if="item.options.food">
              <i class="icon-location-food"></i>
              <small v-text="$ml.get('store.form.help.food')"></small>
            </span>
          </div>
          <div v-if="item.options.others">
            <hr>
            <p v-text="item.options.others"></p>
          </div>

          <div class="" v-if="item.options.available">
            <p>Horário</p>
            <span v-if="item.options.available.anytime">
              <small v-text="$ml.get('store.form.available.anytime')"></small>
            </span>
            <span v-if="item.options.available.week">
              <small v-text="$ml.get('store.form.available.week')"></small>
            </span>
            <span v-if="item.options.available.weekend">
              <small v-text="$ml.get('store.form.available.weekend')"></small>
            </span>
            <span v-if="item.options.available.anytime_hours">
              <small v-text="$ml.get('store.form.available.anytime_hours')"></small>
            </span>
            <span v-if="item.options.available.expedient">
              <small v-text="$ml.get('store.form.available.expedient')"></small>
            </span>
          </div>


        </div>

        <p v-text="$ml.get('home.map.popup.talk_to')"></p>

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
