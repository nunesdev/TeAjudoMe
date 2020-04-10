<template>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
          <div class="text-left">
            <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'Movimento117' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>
          <h1 v-text="$ml.get('about.title')"></h1>
          <div class="">
            <div><p>O TeAjudoME foi criado exclusivamente por causa da pandemia COVID-19 (novo coronavirus),
              <br>com o intuíto de conectar pessoas que querem ajudar e com quem precisa de ajuda com compras no mercado, farmácia ou apenas conversar,
              e principalmente pessoas no grupo de risco.<br>A plataforma também conta com o auxílio de psicólogos devidamente registrados no conselho regional de psicologia.</p>

              <hr> A ferramenta é open-source e está disponível no <a target="_blank" href="https:/github.com/nunesdev/TeAjudoMe">Git hub</a>,
              Para entrar em contato: <a href="mailto:teajudome@gmail.com">teajudome@gmail.com</a>
              <p>
                Idealizado e desenvolvido por <a target="_blank" href="https://instagram.com/bruno.reiz">Bruno Nunes.</a>
                <br/><a target="_blank" href="https://instagram.com/teajudo.me">Instagram Te Ajudo.</a>
              </p>
              <hr>

              <div>
                Ícones feitos por <a href="https://www.flaticon.com/br/autores/freepik" title="Freepik">Freepik</a>
                from <a href="https://www.flaticon.com/br/" title="Flaticon">www.flaticon.com</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';
import EventBus from '@src/event-bus';
export default {
  name: 'sobre',
  data() {
    return {
      isMobile: isMobile,
    }
  },
  created() {
    EventBus.$emit('OPEN_SIDEBAR', false);
  }
}
</script>

<style lang="css">
</style>
