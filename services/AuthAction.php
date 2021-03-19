<?php
namespace Services;

require __DIR__.'/../vendor/autoload.php';

use \Lacuna\RestPki\Authentication;
use \Utils\Util;

class AuthAction extends Util
{
    public function dispatch()
    {
        // Get the token for this authentication (rendered in a hidden input field, see authentication.php).
        $token = $_POST['token']?? '';

        // Get an instance of the Authentication class (see util.php).
        $auth = $this->getRestPkiClient()->getAuthentication();

        // Call the completeWithWebPki() method with the token, which finalizes the authentication process. The call yields a
        // ValidationResults which denotes whether the authentication was successful or not (we'll use it to render the page
        // accordingly, see below)
        $vr = $auth->completeWithWebPki($token);

        if ($vr->isValid()) {
            $userCert = $auth->getCertificate();

            // At this point, you have assurance that the certificate is valid according to the SecurityContext specified on the
            // file authentication.php and that the user is indeed the certificate's subject. Now, you'd typically query your
            // database for a user that matches one of the certificate's fields, such as $userCert->emailAddress or
            // $userCert->pkiBrazil->cpf (the actual field to be used as key depends on your application's business logic) and
            // set the user as authenticated with whatever web security framework your application uses. For demonstration
            // purposes, we'll just render the user's certificate information.

            return $userCert;
        } else {

            $vrHtml = $vr;
            $vrHtml = str_replace("\n", '<br/>', $vrHtml);
            $vrHtml = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $vrHtml);

            var_dump($vrHtml);

            return $vrHtml;

        }
    }
}

/*
| ==================================================================================================================================================================
| Class implementation
| ==================================================================================================================================================================
*/

$auth = new AuthAction();


