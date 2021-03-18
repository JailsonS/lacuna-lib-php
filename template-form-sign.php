<?php 
    require 'services/PadesSign.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Authentication</title>

    <link href="content/css/bootstrap.css" rel="stylesheet"/>
    <link href="content/css/bootstrap-theme.css" rel="stylesheet"/>
    <link href="content/css/site.css" rel="stylesheet"/>
    
    <script src="content/js/jquery-1.11.3.js"></script>
    <script src="content/js/jquery.blockUI.js"></script>
    <script src="content/js/bootstrap.js"></script>
        
    <script>
        var _webPkiLicense = "<?= $settings['webPki']['license']; ?>";
        var _restPkiEndpoint = "<?= $settings['restPki']['endpoint'] ?>";
    </script>

</head>
<body>
    <div class="container">

        <h2>PAdES Signature</h2>
        
        <form id="signForm" method="POST" action="services/PadesSignAction.php">

            <input type="hidden" name="token" value="<?= $token ?>">

            <div class="form-group">
                <label>File to sign</label>
                <?php if (!empty($userfile)) { ?>
                    <p>You'll are signing <a href='app-data/<?= $userfile ?>'>this document</a>.</p>
                <?php } else { ?>
                    <p>You'll are signing <a href='content/SampleDocument.pdf'>this sample document</a>.</p>
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="certificateSelect">Choose a certificate</label>
                <select id="certificateSelect" class="form-control"></select>
            </div>

            <button id="signButton" type="button" class="btn btn-primary">Sign File</button>
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
                form: $('#signForm'),                       // The form that should be submitted when the operation is complete.
                certificateSelect: $('#certificateSelect'), // The <select> element (combo box) to list the certificates.
                refreshButton: $('#refreshButton'),         // The "refresh" button.
                signButton: $('#signButton')              // The button that initiates the operation.
            });
        });
    </script>

</body>
</html>

