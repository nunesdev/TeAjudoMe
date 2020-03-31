import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Home from '../views/Home'
import About from '../views/About'
import StaySafe from '../views/StaySafe'
import Store from '../views/Store'
import NeedHelp from '../views/NeedHelp'
import Volunteer from '../views/Volunteer'



export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/fique-seguro',
      component : StaySafe,
      name: 'seguranca'
    },
    {
      path: '/sobre',
      component : About,
      name: 'sobre'
    },
    {
      path: '/negocio',
      component : Store,
      name: 'Negócio'
    },
    {
      path: '/preciso-de-ajuda',
      component : NeedHelp,
      name: 'Preciso de Ajuda'
    },
    {
      path: '/posso-ajudar',
      component : Volunteer,
      name: 'Posso Ajudar'
    }
  ]
})
