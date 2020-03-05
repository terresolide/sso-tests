/**
 * global store
 */
import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import user from './modules/user'

export default function makeStore(apiConfig) {
 return  new Vuex.Store({
    state: {
      api: apiConfig.url
    },
    getters: {
    	api (state, getters) {
    		return state.api
    	}
    },
    modules: {
	  user:user
    }
  })
}

