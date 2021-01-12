<?php
/*This file generates the payment request and sends it to the Sips server.
For more information on this use case, please refer to the following documentation:
https://documentation.sips.worldline.com/en/WLSIPS.004-GD-Functionality-set-up-guide.html#Payment-in-instalments */

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
$s10TransactionReference1=get_s10TransactionReference();
$s10TransactionId1=$s10TransactionReference1["s10TransactionId"];
$s10TransactionId2=(string)($s10TransactionId1+1);
$s10TransactionId3=(string)($s10TransactionId1+2);


$requestData = array(
   "normalReturnUrl" => $_SESSION['normalReturnUrl'],
   "merchantId" => $_SESSION['merchantId'],
   "s10TransactionReference" => $s10TransactionReference1,
//   "transactionReference" => "", // usefull for native WL Sips 2.0 merchantIds.  Merchants migrating from WL Sips 1.0 do provide s10TransactionId instead

   "amount" => "2500",             //Note that the amount entered in the "amount" field is in cents
   "orderChannel" => "INTERNET",
   "currencyCode" => "978",
   "interfaceVersion" => "IR_WS_2.20",

   "paymentPattern" => "INSTALMENT",
   "instalmentData" => array(
      "number" => "3",
      "amountsList" => array('1000','1000','500'),   //The sum of these amounts must be equal to the content of the amount field
      "datesList" => array('20210105','20210106','20210107'),  //Change the dates according to the time of the test of this use case
      "s10TransactionIdsList" => array($s10TransactionId1,$s10TransactionId2,$s10TransactionId3)   //The first reference must be equal to the one contained in the transactionReference field
   ),
);

$requestTable = generate_the_payment_request($requestData);

send_payment_request($requestTable, $_SESSION["urlForPaymentInitialisation"]);

?>
