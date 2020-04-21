<template>
  <div class="">
    <div class="row no-gutters" slot="header">
      <div class="col-2">
        <img v-if="item.options && item.options.money" src="/images/movimento/doacao_money.png" width="32" height="32" alt="">
        <img v-else src="/images/movimento/caixa.png" width="32" height="32" alt="">
      </div>
      <div class="col-8">
        <h3>
          {{item.name}}
        </h3>
      </div>
      <div v-if="!item.options.money" class="col-2 distance text-right">{{getDistance(item)}}</div>
    </div>
    <div class="info">
      <div class="type">
        <div>

          <span class="tag" v-if="item.options.food">
            <small v-text="$ml.get('home.map.popup.help.food')"></small>
          </span>
          <span class="tag" v-if="item.options.money">
            <small>Doação via transferência</small>
          </span>
        </div>
        <div v-if="item.options.others">
          <hr>
          <p v-text="item.options.others"></p>
        </div>
      </div>
    </div>
    <div slot="footer">
      <div class="contact">
        <span class="tag" v-if="item.email && !item.options.money"><a :href="`mailto:${item.email}`"> Email </a></span>
        <span class="tag" v-if="item.phone && !item.options.money"><a :href="`tel:${item.phone}`" v-text="$ml.get('home.map.popup.phone')"></a></span>
        <span class="tag" v-if="item.whatsapp && !item.options.money"><a target="_blank" :href="`https://api.whatsapp.com/send?phone=${item.phone}`"> WhatsApp </a></span>
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
        .help-with
          margin-bottom: 5px
          font-size: 14px
      .available
        margin-bottom: 5px
    .tag
      border: 1px solid #dedede
      padding: 5px 15px
      border-radius: 18px
      line-height: 18px
      display: inline-flex
      margin-bottom: 5px
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
