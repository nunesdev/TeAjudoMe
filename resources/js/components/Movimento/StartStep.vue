<template>
  <swiper class="swiper" ref="mySwiper" :options="swiperOptions">
  <swiper-slide>
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/movimento/start/smartphone.png" width="128" alt="">
      </div>
      <div class="col-12">
          <h3>Olá!</h3>
          <p>Antes de começar, quero te dar umas dicas, para que você tenha uma boa experiência com a nossa ferramenta</p>
          <p>Vamos lá ?</p>
      </div>
    </div>
  </swiper-slide>
  <swiper-slide v-if="isAndroid">
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/movimento/start/sino.png" width="128" alt="">
          </div>
      <div class="col-12">
          <h3>Receba notificações</h3>
          <p>Fique tranquilo, só enviaremos o necessário, para que você fique atualizado das ações</p>
          <p>Clique no botão abaixo, ou no sino
            <svg class="onesignal-bell-svg" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 99.7 99.7" style="filter: drop-shadow(0 2px 4px rgba(34,36,38,0.35));; -webkit-filter: drop-shadow(0 2px 4px rgba(34,36,38,0.35));;"><circle class="background" cx="49.9" cy="49.9" r="49.9" style="fill: rgb(126, 211, 33);"></circle>
            <path class="foreground" d="M50.1 66.2H27.7s-2-.2-2-2.1c0-1.9 1.7-2 1.7-2s6.7-3.2 6.7-5.5S33 52.7 33 43.3s6-16.6 13.2-16.6c0 0 1-2.4 3.9-2.4 2.8 0 3.8 2.4 3.8 2.4 7.2 0 13.2 7.2 13.2 16.6s-1 11-1 13.3c0 2.3 6.7 5.5 6.7 5.5s1.7.1 1.7 2c0 1.8-2.1 2.1-2.1 2.1H50.1zm-7.2 2.3h14.5s-1 6.3-7.2 6.3-7.3-6.3-7.3-6.3z" style="fill: rgb(255, 255, 255);"></path><ellipse class="stroke" cx="49.9" cy="49.9" rx="37.4" ry="36.9" style="stroke: rgb(255, 255, 255);"></ellipse></svg>
      </p>
          <div class='onesignal-customlink-container'></div>
      </div>
    </div>
  </swiper-slide>

  <swiper-slide v-if="isAndroid">
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/movimento/start/baixar.png" width="128" alt="">
      </div>
      <div class="col-12">
          <h3>Acesso rápido</h3>
          <p>Adicione nossa ferramenta à sua tela inicial, para você voltar aqui com mais facilidade, beleza ?</p>
          <button @click="installApp" type="button" class="btn btn-active" name="button">Adicionar à tela inicial</button>
      </div>
    </div>
  </swiper-slide>
  <swiper-slide v-if="isIOS">
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/movimento/start/baixar.png" width="128" alt="">
      </div>
      <div class="col-12">
          <h3>Acesso rápido</h3>
          <p>Adicione nossa ferramenta à sua tela inicial, para você voltar aqui com mais facilidade, beleza ?</p>
          <p>No próximo passo, você aprende como fazer, mas precisa ser feito no Safari, tá ?</p>

      </div>
    </div>
  </swiper-slide>

  <swiper-slide v-if="isMobileSafari">
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/movimento/start/add_iphone.gif" width="180" alt="">

      </div>
      <div class="col-12">
        <br/><p>Fácil né ? Pode fazer agora se quiser ;)</p>
      </div>
    </div>
  </swiper-slide>

  <swiper-slide>
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/campanhas.png" width="128" alt="">
      </div>
      <div class="col-12">
          <h3>Campanhas</h3>
          <p>No menu, você conhece outras campanhas para participar <br/> legal né ?</p>
      </div>
    </div>
  </swiper-slide>

  <swiper-slide>
    <div class="row justify-content-center text-center">
      <div class="col-12">
        <img src="/images/teajudome.png" width="128" alt="">
      </div>
      <div class="col-12">
          <h3>Obrigado</h3>
          <p>Desde já obrigado por fazer parte desse movimento.</p>
          <p>Visite as seções de "Como funciona" e "Sobre", para saber mais acesse no menu.</p>
          <p>Siga o <a target="_blank" href="https://instagram.com/teajudo.me">TeAjudo.Me no Instagram.</a> </p>
          <button class="btn btn-info" type="button" @click="setStartStep()" name="button">Começar</button>
      </div>
    </div>
  </swiper-slide>
  <div class="swiper-pagination" slot="pagination"></div>
  </swiper>
</template>

<script>
import { isMobile, isAndroid,isMobileSafari, isIOS } from 'mobile-device-detect';
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'

export default {
  components: {
    Swiper,
    SwiperSlide
  },

  data() {
    return {
      isMobile: isMobile,
      isAndroid: isAndroid,
      isMobileSafari: isMobileSafari,
      isIOS: isIOS,
      swiperOptions: {
        pagination: {
          el: '.swiper-pagination'
        },
      },
      showInstall: false,
    }
  },
  updated() {
    if(self.INSTALLAPPEVENT) this.showInstall = true
  },
  created() {
    if(self.INSTALLAPPEVENT) this.showInstall = true
  },
  computed: {
    swiper() {
      return this.$refs.mySwiper.$swiper
    }
  },
  methods: {
    setStartStep() {
      this.$emit('onFinishStep', true)
    },
    installApp() {
      self.INSTALLAPPEVENT.prompt();
      self.INSTALLAPPEVENT.userChoice.then((choice) => {
        if (choice.outcome === 'accepted') {
          this.showInstall = false
        }
        self.INSTALLAPPEVENT = null;
      });
    },
  }
}
</script>

<style lang="scss" scoped>
.onesignal-bell-container {
  .onesignal-bell-launcher {
    bottom: 20px!important;
  }
}
.foreground {
  fill: #fff;
}
.stroke {
  fill: none;
stroke: #fff;
stroke-width: 3px;
stroke-miterlimit: 10;
}
.swiper {
  height: 100%;
  width: 100%;

  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    background-color: #fff;
    padding: 0 15px;

    p {
      font-weight: 300;
      font-size: 16px;
    }

    img, svg {
      margin-bottom: 20px;
    }


  }
}
</style>
