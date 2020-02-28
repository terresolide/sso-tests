/**
 * Global User
 */
module.exports = {
    namespaced: true,
	state: {
	  user: null
	},
	getters: {
		email (state, getters) {
			if (state.user) {
			  return state.user.email
			} else {
				return null
			}
		}
	},
    mutations: {
	  set(state, user) {
		  state.user = user
	  }
	}
}