import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Home from '../views/Home'
import About from '../views/About'
import StaySafe from '../views/StaySafe'



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
    }
  ]
})
