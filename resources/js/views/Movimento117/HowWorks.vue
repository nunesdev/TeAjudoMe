<template>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
          <div class="text-left">
            <router-link v-if="isMobile" class="btn btn-showmap" :to="{ name: 'Movimento117' }"> <span class="icon-map"></span> <span v-text="$ml.get('menu.mapup')"></span> </router-link>
          </div>

          <h1>Como funciona</h1>
          <div class="text">
            <p>Para orientar os voluntários do TeAjudoMe abaixo segue algumas medidas de segurança
              e higiene para evitar riscos de contágio, que estão em conformidade com as orientações das autoridades de saúde:</p>
          </div>
          <h3>Para você que vai ajudar</h3>
          <div class="text">
            <p>É de extrema importância que não haja qualquer tipo de contato físico com as pessoas que ajudará,
              pois provavelmente são pessoas que se encontram em algum grupo de risco e é imprescindível cuidado redobrado.</p>
              <p>
                <ul class="list">
                  <li>Lavar as mãos ao sair de casa com a água e sabão;</li>
                  <li>Evitar ao máximo encostar as mãos em corrimãos, maçanetas, portas e portões ou em móveis públicos;</li>
                  <li>No caso de compras, passar álcool gel nas mãos antes de levar as compras ao local de entrega;</li>
                  <li>Não cumprimentar com apertos de mão, beijos e abraços;</li>
                  <li>Ao chegar, deixar as compras a pelo menos 1 metro de distância das pessoas que vão recebê-las;</li>
                  <li>Não tocar olhos, nariz e boca enquanto estiver com os produtos a serem entregues.</li>
                  <li>Ao tossir e espirrar, cobrir o nariz e boca com o cotovelo flexionado;</li>
                </ul>
              </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';
export default {
  name: 'staysafe',
  data() {
    return {
      isMobile: isMobile,
    }
  }
}
</script>

<style lang="css">
</style>
