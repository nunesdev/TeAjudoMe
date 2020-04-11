<template>
  <div class="">
    <div class="bottombar container">
      <div class="row align-items-center"  :class="{active:isActive}">

        <div class="col-12 bottombar-volunteers-count">
          <div class="row no-gutters">
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/movimento/caixa.png" width="22" alt="">
                </div>
                <div class="col-6">
                  <div class="stats">
                    <span>{{getTotal('user')}}</span> <small>{{getTotal('user') > 1 ? 'Doadores' : 'Doador'}}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/movimento/user.png" width="16" alt="">
                </div>
                <div class="col-6">
                  <div class="stats">
                    <span>{{getTotal('volunteer')}} </span> <small>{{getTotal('volunteer') > 1 ? 'Voluntários' : 'Voluntário'}}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row align-items-center no-gutters">
                <div class="col-6">
                  <img src="/images/movimento/abrigo.png" width="16" alt="">
                </div>
                 <div class="col-6">
                   <div class="stats">
                     <span>{{getTotal('store')}}</span> <small>Centrais</small>
                   </div>
                 </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="col-12 text-right">
          <small>Total: {{getTotalMarkersMovimento}}</small>
        </div> -->
      </div>


    </div>

    <div class="bottombar--actions ">

      <div class="row">
        <div class="col-10 text-center">
          <router-link to="/movimento117/quero-doar"  class="btn btn-sm btn-active btn-white">
            <span class="icon-hand-stop"></span> <span>Quero doar</span>
          </router-link>
          <router-link  class="btn btn-sm btn-white" to="/movimento117/voluntario">
            <span>Quero ser voluntário</span>
          </router-link>
        </div>
        <div class="col-2 text-right">
          <button @click="emitMethod" class="btn btn-info"><span class="icon-lista"></span></button>
        </div>
      </div>
    </div>
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
      isActiveSidebarMember: false,
      showHandUp: true,
      showMapUp: true,
    }
  },
  watch:{
    $route (to, from){
      this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
      this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false
    }
  },
  computed: {
    ...mapGetters([
      'getMarkersMovimento',
      'getTotalMarkersMovimento'
    ])
  },
  updated() {
    if(self.INSTALLAPPEVENT) this.showInstall = true
  },
  mounted() {
    this.showHandUp = this.$router.currentRoute.name == 'Movimento117' ? true : false
    this.showMapUp = this.$router.currentRoute.name != 'Movimento117' ? true : false
  },
  methods: {
    getTotal(type) {
      return this.getMarkersMovimento.filter((item)=>{
        return item.type == type && !item.options.blood
      }).length
    },
    changeState() {
      this.isActive = !this.isActive
      this.$emit('sidebarOpen', this.isActive);
    },
    changeStateMember() {
      this.isActiveSidebarMember = !this.isActiveSidebarMember
      this.$emit('sidebarOpen', this.isActiveSidebarMember);
    },

    show () {
      this.$modal.show('select-campaign');
    },
    emitMethod (v) {
       EventBus.$emit('OPEN_SIDEBAR', true);
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
