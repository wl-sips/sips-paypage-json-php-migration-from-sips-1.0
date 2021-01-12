<?php
/*This file generates the payment request and sends it to the WL Sips server.
For more information on this use case, please refer to the following documentation:
https://documentation.sips.worldline.com/en/WLSIPS.344-UG-3-D-Secure.html */

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
// //   "s10TransactionIdDate" => "not needed",   Please note that the date is not needed, WL Sips server will apply its date.
// );
//
// Example with transactionId automatic generation, like the Sips 1 API was doing.
$s10TransactionReference=get_s10TransactionReference();

$requestData = array(
   "normalReturnUrl" => $_SESSION['normalReturnUrl'],
   "merchantId" =>  $_SESSION['merchantId'],
//   "transactionReference" => "r735", // this is the usual type of reference for native WL Sips 2.0 merchants 
   "s10TransactionReference" => $s10TransactionReference,

   "amount" => "2000",                    //Note that the amount entered in the "amount" field is in cents
   "orderChannel" => "INTERNET",
   "currencyCode" => "978",
   "interfaceVersion" => "IR_WS_2.20",
   
   "billingAddress" => array(
      "city" => "Nantes",
      "country" => "FRA",
      "addressAdditional1" => "route de l'atlantique, 5990",
      "addressAdditional2" => "rue Pompidou, 8900",
      "addressAdditional3" => "avenue Jean Jaures, 4900",
      "zipCode" => "44000",
      "state" => "France",
   ),
   "holderContact" => array(
      "lastname" => "Doe",
      "email" => "jane.doe@example.org",
   ),
   "fraudData" => array(
      "merchantCustomerAuthentMethod" => "NOAUTHENT",
      "challengeMode3DS" => "NO_CHALLENGE",
   ),
);

$requestTable = generate_the_payment_request($requestData);

send_payment_request($requestTable, $_SESSION["urlForPaymentInitialisation"]);

?>
