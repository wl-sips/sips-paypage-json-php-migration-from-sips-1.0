<?php
/*
This file includes customized information shared accross PHP files
For more information on simulation environment and simulation merchant and keys, please refer to:
https://documentation.sips.worldline.com/fr/WLSIPS.316-UG-Sips-Paypage-JSON.html
*/

//You can change the values in session according to your needs and architecture
$_SESSION['merchantId'] = "002001000000003";
$_SESSION['secretKey'] = "002001000000003_KEY1";
$_SESSION['sealAlgorithm'] = "HMAC-SHA-256";

// following lines refer to your own servers
$_SESSION['normalReturnUrl'] = "http://localhost/sips-paypage-json-php/Common/paymentResponse.php";
$_SESSION["automaticResponseUrl"] = "http://localhost/sips-paypage-json-php/Common/automPaymentResponse.php";

// following line is the Sips server adress. The simulation is for test purpose only.
// you will use production url once you are ready to go live with your migration project.
$_SESSION["urlForPaymentInitialisation"] = "https://payment-webinit.simu.sips-services.com/rs-services/v2/paymentInit/";

?>
