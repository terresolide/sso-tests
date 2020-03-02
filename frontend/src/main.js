import Vue from 'vue';

// to manage user
import Vuex from 'vuex'
Vue.use(Vuex)
import store from './store'

// for sso authentication
import Keycloak from 'keycloak-js'
import ssoOptions from '../config/sso'

export let keycloak = Keycloak(ssoOptions)

import App from './App.vue'

keycloak.init({
  onLoad: 'login-required',
  promiseType: 'native'
}).then(function (authenticated) {
  if (authenticated) {
    // Read user informations
    if (keycloak.tokenParsed) {
      var username = keycloak.tokenParsed.preferred_username
     // var name = keycloak.tokenParsed.given_name
     // var family_name = keycloak.tokenParsed.family_name
     var email = keycloak.tokenParsed.email
    
      // POUR LES APPLICATIONS CATALOGUE AERIS
      let user = { token: keycloak.token, email: email, username: username }
      store.commit('user/set', user)
      console.log('USER AUTHENTICATED')
    }
  } else {
    console.log('USER NOT AUTHENTICATED')
  }  
  new Vue({
    el: '#app',
    store:store,
    template: '<App/>',
    components: { App }
  })
})
