<template>
  <div class="">
    <div class="row no-gutters" slot="header">
      <div class="col-2">
        <img v-if="item && item.options && item.options.market" src="/images/supermercado.png" width="32" height="32" alt="">
        <img v-if="item && item.options && item.options.food" src="/images/comercio.png" width="32" height="32" alt="">
        <img v-if="item && item.options && item.options.health" src="/images/farmacia.png" width="32" height="32" alt="">
        <img v-if="item && item.options && item.options.market_garden" src="/images/feira.png" width="32" height="32" alt="">
        <img v-if="item && item.options && item.options.mechanical" src="/images/carro.png" width="32" height="32" alt="">
        <img v-if="item && item.options && item.options.others" src="/images/comercio.png" width="32" height="32" alt="">
      </div>
      <div class="col-8">
        <h3>
          {{item.name}}
        </h3>
      </div>
      <div class="col-2 distance text-right">{{getDistance(item)}}</div>
    </div>
    <div class="info">
      <div class="type">
        <span class="tag" v-if="item.options.market">
          <!-- <i class="icon-shopping-cart"></i> -->
          <small v-text="$ml.get('store.form.help.market')"></small>
        </span>
        <span class="tag" v-if="item.options.available && item.options.available.delivery">
          <!-- <i class="vs-icon material-icons">local_shipping</i> -->
          <small v-text="$ml.get('store.form.available.delivery')"></small>
        </span>
      </div>
      <div class="available" v-if="item.options.available">


        <span class="tag" v-if="item.options.available.anytime">
          <small v-text="$ml.get('store.form.available.anytime')"></small>
        </span>
        <span class="tag" v-if="item.options.available.week">
          <small v-text="$ml.get('store.form.available.week')"></small>
        </span>
        <span class="tag" v-if="item.options.available.weekend">
          <small v-text="$ml.get('store.form.available.weekend')"></small>
        </span>
        <span class="tag" v-if="item.options.available.anytime_hours">
          <small v-text="$ml.get('store.form.available.anytime_hours')"></small>
        </span>
        <span class="tag" v-if="item.options.available.expedient">
          <small v-text="$ml.get('store.form.available.expedient')"></small>
        </span>

        <span class="tag" v-if="item.options.available.others">
          <small>{{item.options.available.others}}</small>
        </span>

      </div>
    </div>
    <div slot="footer">
      <div class="contact">

        <span class="tag" v-if="item.email"><a :href="`mailto:${item.email}`"> Email </a></span>
        <span class="tag" v-if="item.phone"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
        <span class="tag" v-if="item.whatsapp"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  props: ['item'],
  computed: {
    ...mapGetters([
      'getMarkerPosition',
    ]),
  },
  methods: {
    getDistance(item) {
      return this.getDistanceCal(this.getMarkerPosition.lat,this.getMarkerPosition.lng, item.lat, item.lng)
    },
    getDistanceCal(lat1,lon1,lat2,lon2) {
      var R = 6371; // km (change this constant to get miles)
    	var dLat = (lat2-lat1) * Math.PI / 180;
    	var dLon = (lon2-lon1) * Math.PI / 180;
    	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    		Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) *
    		Math.sin(dLon/2) * Math.sin(dLon/2);
    	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    	var d = R * c;
    	if (d>1) return Math.round(d)+"km";
    	else if (d<=1) return Math.round(d*1000)+"m";
    	return d;
    },
  }
}
</script>

<style lang="sass" scoped>
  .item-card
    .material-icons
      font-size: 16px
    .info
      padding-top: 10px
      .type
        margin-bottom: 5px
      .available
        margin-bottom: 5px
    .tag
      border: 1px solid #dedede
      padding: 5px 15px
      border-radius: 18px
      display: inline-flex
    h3
      font-size: 18px
    .distance
      color: #00b3a0
      font-size: 13px
      @media only screen and (max-width: 600px)
        font-size: 12px
    .available, .contact
      p
        display: inline-flex
</style>
