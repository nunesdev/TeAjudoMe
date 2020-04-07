<template>
  <div>
    <MglPopup>
      <div class="popup text-center">
        <img src="/images/movimento/abrigo.png" width="48" height="48" alt="">


        <div class="popup-head row align-items-center">
          <h3 class="col-11">{{item.name}}</h3>
        </div>

        <div class="support"  v-if="item.options">

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

            <span v-if="item.options.available.others">
              <small>{{item.options.available.others}}</small>
            </span>
            <span v-if="item.options.available.delivery">
              <i>
              <svg width="16" height="16" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
              	 viewBox="0 0 404.742 404.742" style="enable-background:new 0 0 404.742 404.742;" xml:space="preserve">
              <g>
              	<path fill="currentColor" d="M337.242,134.651c-12.284,0-34.579-0.008-47.5-0.013v-9.004c0-16.542-13.458-30-30-30h-85.188
              		c-15.218-30.049-46.407-50.697-82.33-50.697C41.372,44.936,0,86.308,0,137.161c0,31.367,15.745,59.122,39.742,75.79v80.737
              		c0,16.542,13.458,30,30,30h0.884c4.135,20.573,22.343,36.118,44.116,36.118c21.773,0,39.981-15.545,44.116-36.118h100.884
              		c7.678,0,14.689-2.902,20-7.664c4.085,3.662,9.176,6.216,14.802,7.204c3.955,20.8,22.264,36.578,44.198,36.578
              		c22.188,0,40.664-16.146,44.328-37.303c12.501-3.619,21.672-15.162,21.672-28.815v-72.054
              		C404.742,170.521,360.952,134.651,337.242,134.651z M20,137.161c0-39.825,32.4-72.224,72.225-72.224
              		c39.824,0,72.224,32.399,72.224,72.224c0,39.825-32.399,72.224-72.224,72.224C52.4,209.385,20,176.985,20,137.161z
              		 M114.742,339.806c-13.785,0-25-11.215-25-25c0-13.785,11.215-25,25-25s25,11.215,25,25
              		C139.742,328.591,128.527,339.806,114.742,339.806z M338.742,339.806c-13.785,0-25-11.215-25-25c0-13.785,11.215-25,25-25
              		c13.785,0,25,11.215,25,25C363.742,328.591,352.527,339.806,338.742,339.806z M384.742,293.688c0,2.878-1.229,5.468-3.182,7.294
              		c-5.848-18.069-22.828-31.176-42.818-31.176c-20.614,0-38.023,13.938-43.329,32.882c-3.349-1.618-5.671-5.039-5.671-9v-139.05
              		c7.706,0.003,18.741,0.007,29,0.01v51.486c0,16.542,13.458,30,30,30h36V293.688z"/>
              	<path fill="currentColor"  d="M92.225,147.161h27.302c5.523,0,10-4.477,10-10c0-5.523-4.477-10-10-10h-17.302V91.5c0-5.523-4.477-10-10-10
              		c-5.523,0-10,4.477-10,10v45.66C82.225,142.684,86.702,147.161,92.225,147.161z"/>
              </g>
              </svg>
</i>
              <small>Drive-thru</small>
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
