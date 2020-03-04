<template>
  <span>
    <div v-if="email">
      <div class="logout">
       <input type="button" value="Logout" @click="logout" />
     </div>
      <h1>Welcome {{ email }}</h1>
    </div>
    <div v-else>
      <h1>You must log</h1>
      <input type="button" value="Login with sso" @click="login"/>
    </div>
  </span>
</template>
<script>
import { keycloak } from './main.js'
export default {
  name: 'app',
  computed: {
    email () {
      return this.$store.getters['user/email']
    },
    token () {
      return this.$store.getters['user/token']
    }
  },
  methods: {
    login () {
      keycloak.login()
    },
    logout () {
      keycloak.logout()
    }
  }
}
</script>
<style>
.logout{
  text-align:right;
  margin:1Opx;
}
</style>