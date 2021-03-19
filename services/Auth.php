<?php
namespace Services;

require __DIR__.'/../vendor/autoload.php';

use \Lacuna\RestPki\Authentication;
use \Utils\Util;
use \Utils\Settings;

class Auth extends Util
{
    private $token;

    public function authentication(): void
    {
        // Get an instance of the Authentication class 
        $auth = new Authentication($this->getRestPkiClient());

        // Call the startWithWebPki() method, which initiates the authentication. This yields the "token", a 22-character
        // case-sensitive URL-safe string, which represents this authentication process. We'll use this value to call the
        // signWithRestPki() method on the Web PKI component (see javascript below) and also to call the completeWithWebPki()
        // method on the file authentication-action.php. This should not be mistaken with the API access token. We have
        // encapsulated the security context choice on util.php.
        $this->token = $auth->startWithWebPki($this->getSecurityContextId());

        // The token acquired above can only be used for a single authentication. In order to retry authenticating it is
        // necessary to get a new token. This can be a problem if the user uses the back button of the browser, since the
        // browser might show a cached page that we rendered previously, with a now stale token. To prevent this from happening,
        // we call the function setExpiredPage(), located in util.php, which sets HTTP headers to prevent caching of the page.
        $this->setExpiredPage();
    }
    
    public function getToken()
    {
        return $this->token?? false;
    }

    public function getSettings()
    {
        return Settings::set();
    }
}

/*
| ==================================================================================================================================================================
| Class implementation
| ==================================================================================================================================================================
*/
$auth = new Auth();
$auth->authentication();

$token = $auth->getToken();
$settings = $auth->getSettings();