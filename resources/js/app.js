
import Vue from 'vue'
import Vuex from 'vuex';

import router from './routers/index'
import * as VueGoogleMaps from "vue2-google-maps";
import { VueReCaptcha } from 'vue-recaptcha-v3'
import Notifications from 'vue-notification'
import Store from './store/store';
import VueCookies from 'vue-cookies'

Vue.use(VueCookies)
Vue.use(Vuex);
Vue.use(VueReCaptcha, { siteKey: '6LfhneIUAAAAAD5iy7oduG0ni8-1ex59VGmxrHP6' })
Vue.use(Notifications)

const store = new Vuex.Store(Store);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.config.productionTip = false

import App from './views/App.vue'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
  created() {
  },
  mounted() {

  },
  router,
  store,
  render: h => h(App)
}).$mount('#app')
