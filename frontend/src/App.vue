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
      <div><input type="button" value="Connect fmt-php" @click="loginClient('formater-php')" /></div>
       </div>
    <div v-else>
      <h1>You must log</h1>
      <input type="button" value="Login with sso" @click="login"/>
    </div>
  </span>
</template>
<script>
import { keycloak } from './main.js'
// import loginWindow from './login-window.vue'
export default {
  name: 'app',
  components: {
	 // loginWindow
  },
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
  data () {
	  return {
		  clientId: null
	  }
  },
  created () {
	  
  },
  methods: {
	  machin(code) {
		  console.log(code)
	  },
    loginClient (clientId) {
		  this.clientId = clientId
    	// response_type=code&redirect_uri=https%3A%2F%2Fdemo.formater%2F&client_id=formater-php&nonce=07b0ab2270e91f48cfec17da5650ebcd&state=8f68d7e802efa0b8451512b83f693e16
    	// &scope=openid
    	var date = new Date()
    	var parameters = {
    			response_type: 'code',
    			redirect_uri: window.location + '/test.html',
    			client_id: clientId,
    			nonce: date.getTime(),
    			state: 'test' + date.getTime()
    	}
    	var ssoAuthUrl = keycloak.authServerUrl + '/realms/' + keycloak.realm + '/protocol/openid-connect/auth'
    	 var url = ssoAuthUrl + '?' + Object.keys(parameters).map(function (prop) {
    	        return prop + '=' + encodeURIComponent(parameters[prop])
    	      }).join('&');
    	console.log(url)
     this.loginWindow = window.open(url, "login Aeris", "menubar=no, status=no, scrollbars=no, menubar=no, width=200, height=100")
     this.loginWindow.addEventListener('message', function(event) {
    	 console.log(event)
    	 this.close()
     })
    },
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
    		// on récupère le nom de fichier si possible
    		 var headerDisposition = response.headers.get('Content-Disposition')
         if (headerDisposition) {
           console.log(headerDisposition)
           var match = headerDisposition.match(/filename[^;\n=]*=(\\?\"|'){0,1}([^\\?\"']*)(\\?\"|'){0,1}/i)
           console.log(match)
           if (match) {
             var filename = match[2]
           }
          //  res = re.search("filename[^;\n=]*=(['\"])*(.*)(?(1)\1|)", string) res.group(2)
         }
        const url = window.URL.createObjectURL(response.bodyBlob);
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', filename)
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