<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * SSO Provider url
     * @var string
     */
    const PROVIDER_URL = 'your-sso-provider-url';

    /**
     * SSO Client ID 
     * @var string
     */
    const CLIENT_ID = 'your-client-id';

    /**
     * SSO Client secret
     * @var string
     */
    const CLIENT_SECRET = 'your-client-secret';


    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
}
