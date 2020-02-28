/**
 * global store
 */
import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import user from './modules/user'
console.log(user)
export default  new Vuex.Store({
  modules: {
	  user:user
  }
})

