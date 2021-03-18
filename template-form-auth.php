<?php 
    
require 'services/Auth.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Authentication</title>

    <script src="content/js/jquery-1.11.3.js"></script>
    <script src="content/js/jquery.blockUI.js"></script>
    
    <script>
        var _webPkiLicense = "<?= $settings['webPki']['license']; ?>";
        var _restPkiEndpoint = "<?= $settings['restPki']['endpoint'] ?>";
    </script>

</head>
<body>
    <div class="container">

        <h2>Authentication</h2>
        

        <form id="authForm" method="POST" action="services/AuthAction.php">

            <input type="hidden" name="token" value="<?= $token ?>">

            <div class="form-group">
                <label for="certificateSelect">Choose a certificate</label>
                <select id="certificateSelect" class="form-control"></select>
            </div>

            <button id="signInButton" type="button" class="btn btn-primary">Sign In</button>
            <button id="refreshButton" type="button" class="btn btn-default">Refresh Certificates</button>
            
        </form>

    </div>

    <!-- webpki lib IMPORTANT -->
    <script src="content/js/lacuna-web-pki-2.9.0.js"></script>
    <script src="content/js/signature-form.js"></script>

    <script>
        $(document).ready(function () {
            signatureForm.init({
                token: '<?= $token ?>',                     // The token acquired from REST PKI.
                form: $('#authForm'),                       // The form that should be submitted when the operation is complete.
                certificateSelect: $('#certificateSelect'), // The <select> element (combo box) to list the certificates.
                refreshButton: $('#refreshButton'),         // The "refresh" button.
                signButton: $('#signInButton')              // The button that initiates the operation.
            });
        });
    </script>

</body>
</html>
