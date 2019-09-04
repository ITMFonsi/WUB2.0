/*!

=========================================================
* WUBS www.wubs.at
=========================================================

* Hi there ;)

=========================================================

*/

// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins'
import vuetify from './plugins/vuetify'

import firebase from 'firebase'

// Components
import './components'

// Plugins
import VModal from 'vue-js-modal'

Vue.use(VModal, { dynamic: true, injectModalsContainer: true });

// Sync router with store
import { sync } from 'vuex-router-sync'

// Application imports
import i18n from '@/i18n'

// Sync store with router
sync(store, router)
Vue.config.productionTip = false

// firebase config
var firebaseConfig = {
  apiKey: "AIzaSyDommI-EUQ1dWdJgk9aMwQ3ppYKkU_-WLo",
  authDomain: "wubs-1.firebaseapp.com",
  databaseURL: "https://wubs-1.firebaseio.com",
  projectId: "wubs-1",
  storageBucket: "",
  messagingSenderId: "756027191937",
  appId: "1:756027191937:web:879bc99998b3f60f"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

/* eslint-disable no-new */
new Vue({
  i18n,
  router,
  store,
  render: h => h(App)
}).$mount('#app')
