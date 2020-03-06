<template>
  <span>
    <div v-if="email">
      <div class="logout">
       <input type="button" value="Logout" @click="logout" />
     </div>
      <h1>Welcome {{ email }}</h1>
      Download :
      <div><input type="button" value="Download file1" @click="download('file1')" /></div>
      <div><input type="button" value="Download file2" @click="download('file2')" /></div>
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
    },
    api () {
    	return this.$store.getters['api']
    }
  },
  created () {
	  this.download('file5')
  },
  methods: {
    login () {
      keycloak.login()
    },
    logout () {
      keycloak.logout()
    },
    download (file) {
    	var url = this.api + '/download?file=' + encodeURIComponent(file + '.txt')
    	this.$http.get(url, {responseType: 'blob'})
    	.then( function (response) {
        const url = window.URL.createObjectURL(response.bodyBlob);
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', file + '.txt')
        document.body.appendChild(link)
        link.click()
     }, function (response) {
	    		switch (response.status) {
	    		case 403:
	    			alert('403 - You must log')
	    			break
	    		case 404:
	    			alert('404 - File Not found')
	    			break
	    		case 401:
	    			alert('4O1 - Unauthorized')
	    			break
	    		default:
	    			alert('Error')
	    		}
    	})
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