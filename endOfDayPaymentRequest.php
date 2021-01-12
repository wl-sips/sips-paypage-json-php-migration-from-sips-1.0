<?php
/*This file generates the payment request and sends it to the Sips server.
For more information on this use case, please refer to the following documentation:
https://documentation.sips.worldline.com/en/WLSIPS.004-GD-Functionality-set-up-guide.html#End-of-day-payment */

session_start();

include('Common/paymentRequest.php');
include('Common/transactionIdCalculation.php');


//PAYMENT REQUEST

// parameters.php initializes some session data like $_SESSION['merchantId'], $_SESSION['secretKey'], $_SESSION['normalReturnUrl'] and $_SESSION["urlForPaymentInitialisation"]
// You can change these values in parameters.php according to your needs and architecture
include('parameters.php');

// Merchants migrating from WL Sips 1.0 to WL Sips 2.0 must provide a transactionId. This easily done below. (second example used as default).

// Example with the merchant's own transactionId (typically when you increment Ids from your database)
// $s10TransactionReference=array(
//    "s10TransactionId" => "000001",
// //   "s10TransactionIdDate" => "not needed",   Please note that the date is not needed, Sips server will apply its date.
// );
//
// Example with transactionId automatic generation, like the WL Sips 1.0 API was doing.
$s10TransactionReference=get_s10TransactionReference();


$requestData = array(
   "normalReturnUrl" => $_SESSION['normalReturnUrl'],
   "merchantId" => $_SESSION['merchantId'],
   "s10TransactionReference" => $s10TransactionReference,
//   "transactionReference" => "",  // usefull for native WL Sips 2.0 merchantIds.  Merchants migrating from WL Sips 1.0 will provide s10TransactionId instead
   "amount" => "5999",             //Note that the amount entered in the "amount" field is in cents
   "orderChannel" => "INTERNET",
   "currencyCode" => "978",
   "interfaceVersion" => "IR_WS_2.20",

   "captureMode" => "AUTHOR_CAPTURE",
   "captureDay" => "0",
);

$requestTable = generate_the_payment_request($requestData);

send_payment_request($requestTable, $_SESSION["urlForPaymentInitialisation"]);

?>
