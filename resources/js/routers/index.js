import Vue from 'vue'
import Router from 'vue-router'



Vue.use(Router)

import Home from '../views/Home'


const baseRoutes = [
  {
    path: '/dash',
    component : Home,
  }
]

export default new Router({
  mode: 'history', 
  baseRoutes,
})
