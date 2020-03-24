import Vue from 'vue'
import { MLInstaller, MLCreate, MLanguage } from 'vue-multilanguage'
import es from './langs/es.json'
import en from './langs/en.json'
import pt from './langs/pt.json'

Vue.use(MLInstaller)

export default new MLCreate({
  initial: 'portuguese',
  save: true,
  languages: [
    new MLanguage('english').create(en),
    new MLanguage('portuguese').create(pt),
    new MLanguage('spanish').create(es)
  ]
})
