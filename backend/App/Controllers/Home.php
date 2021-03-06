<?php

namespace App\Controllers;

use \Core\View;
use \App\Config as Config;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{
   
  public function before() {
    if (!isset($_SESSION)) {
            @session_start();
        }
    // force login
    if (!isset($_SESSION['User'])) {
      $this->login(); 
    }
  }
  
  /**
   * Show the index page
   *
   * @return void
   */
  public function indexAction()
  {
    $user = unserialize($_SESSION['User']);
    View::renderTemplate('Home/index.html', array('email' => $user['email']));
  }
  public function logoutAction()
  {
     // logout of all keycloak app
     unset($_SESSION['User']);
     $logoutUrl = Config::PROVIDER_URL . '/protocol/openid-connect/logout';
     $logoutUrl .= '?redirect_uri=' . urlencode(Config::BASE_URL);
     header('Location: ' . $logoutUrl );
  }
  private function login () {
     $oidc = new \OpenIDConnectClient(
         Config::PROVIDER_URL,
         Config::CLIENT_ID,
         Config::CLIENT_SECRET,
         Config::BASE_URL,
         Config::BASE_URL . '/unauthorized'
      );
      // Request authentification before begin
      $oidc->authenticate();
   
      // Check Keycloak authorization
      $oidc->checkKeycloakAuthorization();

      // get user info:
      $user =  $oidc->requestUserInfo();

      // register in session
      $_SESSION['User'] = serialize((array)$user);
  }
}
