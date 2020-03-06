import Vue from 'vue';
// To request
import VueResource from 'vue-resource'
Vue.use(VueResource)

// some custom functions
import UtilsPlugin from './utils.js'
Vue.use(UtilsPlugin)

// to manage user and api 
import Vuex from 'vuex'
Vue.use(Vuex)
import apiConfig from '../config/api'
import makeStore from './store'
let store = makeStore(apiConfig)

// for sso authentication
import Keycloak from 'keycloak-js'
import ssoOptions from '../config/sso'

export let keycloak = Keycloak(ssoOptions)

// and now the app
import App from './App.vue'

keycloak.init({
  onLoad: 'check-sso',
  promiseType: 'native'
}).then(function (authenticated) {
  if (authenticated) {
    // Read user informations
    if (keycloak.tokenParsed) {
      var username = keycloak.tokenParsed.preferred_username
      var email = keycloak.tokenParsed.email
    
      // record user
      let user = { token: keycloak.token, email: email, username: username }
      store.commit('user/set', user)
      console.log('USER AUTHENTICATED')
    }
  } else {
    console.log('USER NOT AUTHENTICATED')
  } 
  // to automatically add header to http request be careful
  // it add Authorization header to all POST request
  // you must add the parameter simple=true
  // to your request if you don't want the header Authorization
  Vue.http.interceptors.push(function(request, next) {
    if (keycloak.token && !request.simple) {
      request.headers.set('Authorization', 'Bearer ' + keycloak.token);
      request.headers.set('Accept', 'application/json');
    }
      next() ;
  })
  // Update access token all 3'30"
 function updateSSoToken() {
    setTimeout(function () {
      keycloak.updateToken(200000).then(function(token) {
        store.commit('user/setToken', keycloak.token)
      }),
      updateSSoToken();
      }, 200000);
  }
  updateSSoToken();

  // launch the app
  new Vue({
    el: '#app',
    store:store,
    template: '<App/>',
    components: { App }
  })
})
