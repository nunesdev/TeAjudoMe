<template>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-sm-12">

          <h1>{{getLabelType()}}</h1>

          <div class="row" :class="{'justify-content-center':isMobile}"  style="padding-bottom: 20px">
            <div class="col-md-5">
              <div class="row no-gutters p-2">
                <div class="col-12">
                  <router-link class="btn btn-white"
                  :class="{'btn-active':isActive('user')}"
                  :to="{ name: 'Movimento117List', params: { type:'user' } }">Doadores</router-link>
                  <router-link class="btn btn-white"
                  :class="{'btn-active':isActive('store')}"
                  :to="{ name: 'Movimento117List', params: { type:'store' } }">Centrais</router-link>
                  <router-link class="btn btn-white"
                  :class="{'btn-active':isActive('volunteer')}"
                  :to="{ name: 'Movimento117List', params: { type:'volunteer' } }">Voluntários</router-link>
                </div>
              </div>
              <div class="row no-gutters p-2">
                <div class="col-12">
                  <button type="button" @click="order.near = !order.near" :class="{'btn-active':order.near}" class="btn btn-white" name="button">Mais próximo</button>
                  <button type="button" @click="order.away = !order.away" :class="{'btn-active':order.away}" class="btn btn-white" name="button">Mais longe</button>
                  <button v-if="type == 'store'" type="button" @click="filter.delivery = !filter.delivery" :class="{'btn-active':filter.delivery}" class="btn btn-white" name="button">Sistema Drive-thru</button>
                </div>
              </div>
              <div class="row no-gutters" v-if="type == 'store'">
                <div class="col-12">
                  <button class="btn btn-img filter-by-activity" data-activity='market'  @click="filterActive('market')" :class="{'btn-active':filter.market}" ><img src="/images/movimento/abrigo.png" width="30" alt="">Central de coleta</button>
                  <button class="btn btn-img filter-by-activity" data-activity='blood' @click="filterActive('blood')" :class="{'btn-active':filter.blood}" ><img src="/images/movimento/sangue.png" width="30" alt="">Hemocentro</button>
                </div>
              </div>
            </div>

            <div class="col-sm-8 col-md-6 col-lg-4 slider-distance">
              <small>Distância</small>
              <vue-slider
              v-model="distance"
              :data="distances"
              :marks="true"
              :hideLabel="true"
              >
              </vue-slider>
              <div class="row no-gutters">
                <div class="col-4 slider-distance-label text-left"><small>10km</small></div>
                <div class="col-4 slider-distance-label text-center"><small>50km</small></div>
                <div class="col-4 slider-distance-label text-right"><small>100km</small></div>
              </div>
            </div>
            <div class="col-md-1">

            </div>
          </div>


          <vs-divider></vs-divider>

          <div class="list-items">
            <div class="row justify-content-center text-center" v-if="!loadedItems">
              <div class="col-md-6 col-sm-12">
                <bounce-loader></bounce-loader>
              </div>
            </div>
            <div class="row" :class="{'row-reverse':order.away}" v-if="loadedItems">
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 item-card" v-for="(item, index) in items_filtered" :key="index">
                <vs-card class="">
                  <User :item="item" v-if="item.type == 'user'"></User>
                  <Store :item="item" v-if="item.type == 'store'"></Store>
                  <Volunteer :item="item" v-if="item.type == 'volunteer'"></Volunteer>
                </vs-card>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>
<script>
import EventBus from '@src/event-bus';
import { isMobile } from 'mobile-device-detect';
import Sidebar from '@components/Sidebar';
import { mapGetters, mapActions } from 'vuex'
import BounceLoader from 'vue-spinner/src/BounceLoader.vue'

import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/material.css'

import User from '@components/Movimento/List/User'
import Store from '@components/Movimento/List/Store'
import Volunteer from '@components/Movimento/List/Volunteer'

export default {
  name: 'Movimento117List',
  props: ['type'],
  components: {
    Sidebar,
    VueSlider,
    User,
    Store,
    Volunteer,
    BounceLoader
  },
  data() {
    return {
      items: [],
      loadedItems: false,

      isMobile: isMobile,
      location: null,
      isLocated: this.$cookies.get('_tageocord') ? true : false,
      distance: 10,
      distances: [10,20,50,80,100],
      sliderOptions: {
        dotSize: 18
      },
      order: {
        'near': true,
        'away': false
      },
      filter: {
        delivery: false,
        market: false,
        blood: false,
      }
    };
  },
  watch: {
    distance(){
      this.getNewItems()
    }
  },
  mounted() {
    EventBus.$emit('OPEN_SIDEBAR', false);
    this.locateMe();
  },
  computed: {
    items_filtered(){
      this.items = this.filterByType()

      if(this.filter.delivery && this.type == 'store')
        this.items.concat(this.filterByDelivery())

      if(this.filter.market && this.type == 'store')
        this.items.concat(this.filterByAtividade('central_coleta'))

      if(this.filter.blood && this.type == 'store')
        this.items.concat(this.filterByAtividade('blood'))

      if(this.items) this.loadedItems = true
      return this.items
    },
    ...mapGetters([
      'getMarkersMovimento',
    ]),
  },
  methods: {
    ...mapActions([
      'actionGetAllUsersMovimento',
      'actionSetNewPositionMovimento'
    ]),

    async locateMe() {
      try {

        this.location = await this.getLocation();

        this.actionSetNewPositionMovimento({
          'lng': this.location.coords.longitude,
          'lat': this.location.coords.latitude
        });
        if(this.items_filtered.length == 0) {
          this.actionGetAllUsersMovimento({
            'campaign' : 'movimento117',
            'location': {lat:this.location.coords.latitude, lng: this.location.coords.longitude},
            'distance' : 10
          })
        } else {
          this.loadedItems = true
        }

      } catch(e) {
        console.error(e);
      }
    },

    async getLocation() {

      return new Promise((resolve, reject) => {

        if(!("geolocation" in navigator)) {
          reject(new Error('Geolocation is not available.'));
        }

        navigator.geolocation.getCurrentPosition(pos => {
          setTimeout(()=>this.isLocated = true,1000)
          this.$cookies.set('_tageocord', {"lng":pos.coords.longitude,"lat":pos.coords.latitude});
          resolve(pos);
        }, err => {
          reject(err);
        });

      });
    },

    getLabelType(){
      const types = {
        'store' : 'Centrais',
        'user'  : 'Doadores',
        'volunteer' : 'Voluntários'
      }

      return types[this.type]
    },
    getNewItems() {
      const payload = this.actionGetAllUsersMovimento({
        'campaign' : 'movimento117',
        'location': {lat:this.location.coords.latitude, lng: this.location.coords.longitude},
        'distance' : parseInt(this.distance)
      })
      this.loadedItems = false
      payload.then(()=>{
        this.loadedItems = true
      })
    },
    isActive(type) {
      return this.$router.currentRoute.params.type == type
    },

    // FILTERS
    filterActive(current) {
      this.filter[current] = !this.filter[current]
      document.querySelectorAll('.filter-by-activity').forEach((item)=>{
        if(item.classList.contains('btn-active')) {
          const activity = item.getAttribute('data-activity')
          this.filter[activity] = false
        }
      })

    },
    filterByType() {
      return this.items = this.$store.getters.getMarkersMovimento.filter((item)=>{
        return item.type == this.type
      });
    },

    filterByDelivery() {
      return this.items = this.$store.getters.getMarkersMovimento.filter((item)=>{
        return item.type == this.type && item.options && item.options.available && item.options.available.delivery
      });
    },
    filterByAtividade(atividade) {
      return this.items = this.$store.getters.getMarkersMovimento.filter((item)=>{
        return item.type == this.type && item.options && item.options[atividade]
      });
    },

  }
}
</script>

<style lang="sass">
  .content
    padding-top: 40px
    @media only screen and (max-width: 600px)
      padding-top: 90px!important
    h1
      @media only screen and (max-width: 600px)
        font-size: 18px
        display: inline-flex
  .v-spinner
    display: inline-block
    padding-top: 100px
  .list-items
    padding-top: 40px
    .item-card
      min-height: 200px
      @media only screen and (max-width: 600px)
        min-height: inherit
        &:last-child
          padding-bottom: 40px
  .slider-distance
    @media only screen and (max-width: 600px)
      width: 90%
  .slider-distance-label

  .vue-slider-mark
    @media only screen and (max-width: 600px)
      z-index: 1
  .vue-slider-dot
    @media only screen and (max-width: 600px)
      z-index: 1
  .btn-img
    border: 1px solid #dedede
    padding-right: 10px
    padding-left: 2px
    padding-top: 2px
    padding-bottom: 2px
    margin-bottom: 5px
    img
      margin-right: 5px
  @media only screen and (max-width: 600px)
    .p-2
      padding: 5px!important
</style>
