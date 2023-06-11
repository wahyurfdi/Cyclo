require('./bootstrap')

import Vue from 'vue'
import router from './router'
import store from './store'
import Axios from 'axios'
import App from './views/App.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

window.Vue = require('vue').default
Vue.prototype.$http = Axios

Vue.component('fa-icon', FontAwesomeIcon)

library.add(fas, far, fab)

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})
