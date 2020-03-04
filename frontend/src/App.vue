<template>
	<span>
	  <div v-if="email">
	    <div class="logout">
       <input type="button" value="Logout" @click="logout" />
     </div>
	    <h1>Welcome {{ email }}</h1>
	  </div>
	  <div v-else>No body is authentified</div>
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