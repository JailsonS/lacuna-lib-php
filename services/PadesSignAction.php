<?php
namespace Services;

require __DIR__.'/../vendor/autoload.php';

use \Lacuna\RestPki\PadesSignatureFinisher2;
use \Utils\Util;

class PadesSignAction extends Util
{
    private $signerCert;
    private $filename;

    public function signtureFinish()
    {
        // Get the token for this signature (rendered in a hidden input field, see pades-signature.php).
        $token = $_POST['token'];

        // Instantiate the PadesSignatureFinisher2 class, responsible for completing the signature process.
        $signatureFinisher = new PadesSignatureFinisher2($this->getRestPkiClient());

        // Set the token.
        $signatureFinisher->token = $token;

        // Call the finish() method, which finalizes the signature process and returns a SignatureResult object.
        $signatureResult = $signatureFinisher->finish();

        // The "certificate" property of the SignatureResult object contains information about the certificate used by the user
        // to sign the file.
        $this->$signerCert = $signatureResult->certificate;

        // At this point, you'd typically store the signed PDF on your database. For demonstration purposes, we'll
        // store the PDF on a temporary folder publicly accessible and render a link to it.

        $filename = uniqid() . ".pdf";
        $this->filename = $filename;

        $this->createAppData(); // make sure the "app-data" folder exists (util.php)

        // The SignatureResult object has functions for writing the signature file to a local file (writeToFile()) and to get
        // its raw contents (getContent()). For large files, use writeToFile() in order to avoid memory allocation issues.
        $signatureResult->writeToFile("../app-data/{$filename}");
    }

    public function getSigned()
    {
        return [
            'signerCert' => $this->signerCert?? '',
            'filename' => $this->filename
        ];
    }
}

/*
| ==================================================================================================================================================================
| Class implementation
| ==================================================================================================================================================================
*/

$sign = new PadesSignAction();
$sign->signtureFinish();

$fileSigned = $sign->getSigned();

echo "<pre>";
    print_r($fileSigned);
echo "</pre>";
