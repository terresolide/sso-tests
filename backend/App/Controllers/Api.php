<?php

namespace App\Controllers;

use \Core\View;
use \App\Config as Config;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Api extends \Core\Controller
{
    private $oidc = null;
    private $accessToken = null;
    private $user = null;
    
    public function before () {

        // Add headers for ajax request
        // allow cross origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
        }
        header('Access-Control-Allow-Headers: Content-Type,  Authorization');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        // if use session
        // header('Access-Control-Allow-Credentials: true');
        
        // return if it's an OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit();
        }
        
        // get token in header
        $token = $this->getHeaderToken();
        $this->checkToken($token);
        
    }
  
  /**
   * Show the index page
   *
   * @return void
   */
  public function indexAction()
  {
    
  }
  public function downloadAction()
  {
      if (isset($_GET['file'])) {
          $file = urldecode($_GET['file']);
          $user = $this->oidc->requestUserInfo();
          $filepath = PUBLIC_DIR . '/upload/' .$file;
          if (file_exists($filepath)) {
              //record email and file
              // @todo
              // Download::insert($user->email, $file);
              
              // send the file
              header("Content-Description: File Transfer");
  
              header("Content-type: application/octet-stream");
             // header("Content-type: text/html");
              
              // for zip file 
              // header("Content-type: archive/zip");
               header("Content-Transfer-Encoding: binary");
             
              header("Content-Length: ".filesize($filepath));
              header('Content-Disposition: attachment; filename="'.$file.'"');
              ob_end_flush();
              @readfile($filepath);
              exit;
          }
      }
  }
  private function getHeaderToken () {
      $headers = getallheaders();
      if (isset($headers['Authorization'])) {
         return str_replace('Bearer ', '', $headers['Authorization']);
      } else {
        // 403 forbidden unauthentified
        header('HTTP/1.0 403 Forbidden');
         // echo '403 FORBIDDEN';
         exit;
      }
  }
  private function checkToken($token) {
      $this-> initOidc();
      $statusToken = $this->oidc->introspectToken($token,'access_token');
      if (!$statusToken->active) {
          // token has expired or never exists
          // 403 forbidden unauthentified
          header('HTTP/1.0 403 Forbidden');
          exit;
      } else {
          // we already can access to email and others informations
          $this->oidc->setAccessToken($token);
      }
  }
  private function initOidc() {
      $this->oidc = new \OpenIDConnectClient(
          Config::PROVIDER_URL,
          Config::CLIENT_ID,
          Config::CLIENT_SECRET,
          Config::BASE_URL,
          Config::BASE_URL . '/unauthorized'
      );
  }
  private function getUserInfo () {
      return $this->oidc->requestUserInfo();
  }
}
