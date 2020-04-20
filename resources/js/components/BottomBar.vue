<template>
  <div class="">
    <div class="bottombar container">
      <div class=" row align-items-center "  :class="{active:isActive}">

        <div class="col-12 bottombar-volunteers-count">
          <div class="row no-gutters">
            <router-link  class="col-4" :to="{ name: 'List', params: {type:'user'} }">
              <div>
                <div class="row align-items-center no-gutters">
                  <div class="col-6">
                    <img src="/images/perfil.png" width="22" alt="">
                  </div>
                  <div class="col-6">
                    <div class="stats">
                      <span>{{getTotal('user')}}</span> <small v-text="$ml.get('sidebar.total.requests')"></small>
                    </div>
                  </div>
                </div>
              </div>
            </router-link>
            <router-link class="col-4" :to="{ name: 'List', params: {type:'volunteer'} }">
              <div >
                <div class="row align-items-center no-gutters">
                  <div class="col-6">
                    <img src="/images/voluntario.png" width="16" alt="">
                  </div>
                  <div class="col-6">
                    <div class="stats">
                      <span>{{getTotal('volunteer')}} </span> <small v-text="$ml.get('sidebar.total.volunteers')"></small>
                    </div>
                  </div>
                </div>
              </div>
            </router-link>
            <router-link class="col-4" :to="{ name: 'List', params: {type:'store'} }">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/comercio.png" width="16" alt="">
                </div>
                 <div class="col-6">
                   <div class="stats">
                     <span>{{getTotal('store')}}</span> <small v-text="$ml.get('sidebar.total.small_business_mobile')"></small>
                   </div>
                 </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>


    </div>

    <div class="bottombar--actions ">

      <div class="row">
        <div class="col-10 text-center">
          <router-link to="/preciso-de-ajuda"  class="btn btn-active btn-white">
            <span class="icon-hand-stop"></span> <span v-text="$ml.get('menu.needup')"></span>
          </router-link>

          <router-link  class="btn btn-white" to="/negocio">
            <span v-text="$ml.get('menu.marketup')"></span>
          </router-link>
          <router-link to="/posso-ajudar"  class="btn btn-white">
            <span v-text="$ml.get('menu.handup')"></span>
          </router-link>

        </div>
        <div class="col-2 text-right">
          <button @click="emitMethod" class="btn btn-info"><span class="icon-lista"></span></button>
        </div>
      </div>
    </div>

    <!-- <div class="bottombar--actions">

      <div class="col-12 bottombar-links">
        <div class="row align-items-start">
          <div class="col-6">
            <router-link to="/sobre" v-text="$ml.get('menu.sobre')"></router-link>
            <router-link to="/fique-seguro" v-text="$ml.get('menu.seguranca')"></router-link>
          </div>
          <div class="col-6 bottombar-flags">
            <a @click="$ml.change('portuguese')" href="#">Português</a>
            <a @click="$ml.change('english')" href="#">English</a>
            <a @click="$ml.change('spanish')" href="#">Spanish</a>
          </div>
        </div>

        <div class="row align-items-end">

        </div>
      </div>
    </div> -->
  </div>
</template>

<script>
 import { mapGetters, mapActions } from 'vuex'
 import { MLBuilder } from 'vue-multilanguage'
  import EventBus from '@src/event-bus';

export default {
  props: ['address'],
  name: 'BottomBar',
  data() {
    return {
      isActive: false,
      isMap: this.$router.currentRoute.name == 'home',
      isList: this.$router.currentRoute.name == 'List',
    }
  },
  computed: {
    ...mapGetters([
      'getMarkers',
      'getTotalMarkers',
    ]),
  },
  updated() {
    console.log(this.isMap);
    console.log(this.isList);
  },
  methods: {
    getTotal(type) {
      return this.getMarkers.filter((item)=>{
        return item.type == type
      }).length
    },
    emitMethod (v) {
       EventBus.$emit('OPEN_SIDEBAR_HOME', true);
    }
  }
}
</script>

<style lang="scss" scoped>
.bottombar {
  padding-top: 10px;
  padding-bottom: 10px;
  &.container {
    padding-left: 10px;
    padding-right: 10px;
  }

  .bottombar-volunteers-count {
    .col-4 {
      padding-left: 5px;
      padding-right: 5px;
    }
    img {
      max-width: 100%;
      width: 32px;
    }
    small {
      font-size: 11px;
    }
  }
}
footer {
  padding-top: 0;
}

.btn {
  &.btn-active {
    background: #264463;
  }
}
</style>
