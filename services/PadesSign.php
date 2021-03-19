<?php
namespace Services;

require __DIR__.'/../vendor/autoload.php';

use \Lacuna\RestPki\Authentication;
use \Lacuna\RestPki\PadesSignatureStarter;
use \Lacuna\RestPki\StandardSignaturePolicies;
use \Lacuna\RestPki\PadesMeasurementUnits;

use \Utils\Util;
use \Utils\UtilPades;
use \Utils\Settings;

class PadesSign extends Util
{

    private $token;

    public function signture()
    {

        $utilPades = new UtilPades();

        // Instantiate the PadesSignatureStarter class, responsible for receiving the signature elements and start the signature
        // process.
        $signatureStarter = new PadesSignatureStarter($this->getRestPkiClient());
        
        // If the user was redirected here by upload.php (signature with file uploaded by user), the "userfile" URL argument
        // will contain the filename under the "app-data" folder. Otherwise (signature with server file), we'll sign a sample
        // document.
        $userfile = isset($_GET['userfile']) ? $_GET['userfile'] : null;
        if (!empty($userfile)) {
            $signatureStarter->setPdfToSignFromPath(__DIR__."/../app-data/{$userfile}");
        } else {
            $signatureStarter->setPdfToSignFromPath(__DIR__."/../content/SampleDocument.pdf");
        }
        
        // Set the signature policy.
        $signatureStarter->signaturePolicy = StandardSignaturePolicies::PADES_BASIC;
        
        // Set the security context. We have encapsulated the security context choice on util.php.
        $signatureStarter->securityContext = $this->getSecurityContextId();
        
        // Set the unit of measurement used to edit the pdf marks and visual representations.
        $signatureStarter->measurementUnits = PadesMeasurementUnits::CENTIMETERS;
        
        // Set the visual representation to the signature. We have encapsulated this code (on util-pades.php) to be used on
        // various PAdES examples.
        $signatureStarter->visualRepresentation = $utilPades->getVisualRepresentation($this->getRestPkiClient());
        
        /*
            Optionally, add marks to the PDF before signing. These differ from the signature visual representation in that
            they are actually changes done to the document prior to signing, not binded to any signature. Therefore, any number
            of marks can be added, for instance one per page, whereas there can only be one visual representation per signature.
            However, since the marks are in reality changes to the PDF, they can only be added to documents which have no
            previous signatures, otherwise such signatures would be made invalid by the changes to the document (see property
            PadesSignatureStarter::bypassMarksIfSigned). This problem does not occur with signature visual representations.
        
            We have encapsulated this code in a method to include several possibilities depending on the argument passed.
            Experiment changing the argument to see different examples of PDF marks. Once you decide which is best for your case,
            you can place the code directly here.
        */
        //array_push($signatureStarter->pdfMarks, $utilPades->getPdfMark(1));
        
        // Call the startWithWebPki() method, which initiates the signature. This yields the token, a 43-character
        // case-sensitive URL-safe string, which identifies this signature process. We'll use this value to call the
        // signWithRestPki() method on the Web PKI component (see javascript below) and also to complete the signature after
        // the form is submitted (see file pades-signature-action.php). This should not be mistaken with the API access token.
        $this->token = $signatureStarter->startWithWebPki();
        
        // The token acquired above can only be used for a single signature attempt. In order to retry the signature it is
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

$sign = new PadesSign();
$sign->signture();

$settings = $sign->getSettings();
$token = $sign->getToken();
