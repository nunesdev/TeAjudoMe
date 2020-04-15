import Vue from 'vue'
import Router from 'vue-router'
import VueBodyClass from 'vue-body-class';

Vue.use(Router)

import Home from '../views/Home'
import About from '../views/About'
import StaySafe from '../views/StaySafe'
import Store from '../views/Store'
import NeedHelp from '../views/NeedHelp'
import Volunteer from '../views/Volunteer'
import Transparencia from '../views/Transparencia'

const baseRoutes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: { bodyClass: 'dashboard'  }
  },
  {
    path: '/fique-seguro',
    component : StaySafe,
    name: 'seguranca',
    meta: { bodyClass: 'staysafe'  }
  },
  {
    path: '/sobre',
    component : About,
    name: 'sobre',
    meta: { bodyClass: 'about'  }
  },
  {
    path: '/negocio',
    component : Store,
    name: 'Negócio',
    meta: { bodyClass: 'small_business'  }
  },
  {
    path: '/preciso-de-ajuda',
    component : NeedHelp,
    name: 'Preciso de Ajuda',
    meta: { bodyClass: 'needhelp'  }
  },
  {
    path: '/posso-ajudar',
    component : Volunteer,
    name: 'Posso Ajudar',
    meta: { bodyClass: 'canhelp'  }
  },
  {
    path: '/transparencia',
    component : Transparencia,
    name: 'Transparencia',
    meta: { bodyClass: 'canhelp'  }
  }
]

import Movimento from './movimento'

const routes = baseRoutes.concat(
  Movimento
)

const router = new Router({
  routes
})



const vueBodyClass = new VueBodyClass(routes);

router.beforeEach((to, from, next) => { vueBodyClass.guard(to, next) });

export default router;
