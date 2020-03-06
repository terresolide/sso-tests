/**
 * Utils
 */

const UtilsPlugin = {
  install(Vue, options) {
     Vue.prototype.extractFilenameFromHeader = function (response){
       var headerDisposition = response.headers.get('Content-Disposition')
       var filename = 'undefined'
       if (headerDisposition) {
         var match = headerDisposition.match(/filename[^;\n=]*=(\\?\"|'){0,1}([^\\?\"']*)(\\?\"|'){0,1}/i)
         if (match) {
           filename = match[2]
         }
       }
       return filename
     }
  }
}