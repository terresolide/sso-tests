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
    },
    token (state, getters) {
      if (state.user) {
        return state.user.token
      } else {
        return null
      }
    }
  },
  mutations: {
    set(state, user) {
      state.user = user
    },
    setToken(state, token) {
      if (state.user) {
        state.user.token = token
      }
    }
  }
}