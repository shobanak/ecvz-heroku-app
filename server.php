<?php
require_once 'lib/Braintree.php';
session_start();



$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$sypyzs38xxxgm9pq$25a89b8fab203be7ae5cec73b05a8ed2',
));


$result = $gateway->transaction()->sale([
    // "amount" => '10',
    "amount" => $_POST['txnamount'],
    //'merchantAccountId' => 'USD',
    "paymentMethodNonce" => $_POST['payment_method_nonce'],    
     "shipping" => [
      "firstName" => "Buyer",
      "lastName" => "One",     
      "streetAddress" => $_POST['addline1'],
      "extendedAddress" => $_POST['addline2'],
      "locality" => $_POST['addcity'],
       "region" => $_POST['state'],   
      "postalCode" => $_POST['postalcode'],
      "countryCodeAlpha2" => $_POST['countrycode']
    ],
    "options" => [
      "paypal" => [
        "customField" => $_POST['orderid'],
        "description" => $_POST['orderdesc']
      ],
    ]
]);


if ($result->success) {
echo 'Express Checkout - v.zero SDK(ECVZ) Transaction Result Details <br/><br/>';
print_r("PayPal transaction ID :" . $result->transaction->paypal[captureId]);  echo '<br/>';
print_r("PayPal DebugID required for troubleshooting : " . $result->transaction->paypal[debugId]);  echo '<br/>';
print_r("PayPal transaction Seller Protection Status : " . $result->transaction->paypal[sellerProtectionStatus]);  echo '<br/>';
print_r("PayPal OrderID(custom field passed) : " . $result->transaction->paypal[customField]);  echo '<br/>';
print_r("PayPal Payment ID : " . $result->transaction->paypal[paymentId]);  echo '<br/>';
echo '<br/>'; echo 'Express Checkout - v.zero SDK(ECVZ) Payer Details <br/><br/>';
print_r("Payer ID : " . $result->transaction->paypal[payerId]);  echo '<br/>';
print_r("Payer Email : " . $result->transaction->paypal[payerEmail]);  echo '<br/>';
print_r("Payer First Name : " . $result->transaction->paypal[payerFirstName]);  echo '<br/>';
print_r("Payer Second Name : " . $result->transaction->paypal[payerLastName]);  echo '<br/>';
print_r("Payer Status : " . $result->transaction->paypal[payerStatus]);  echo '<br/>';
print_r(json_encode($result->transaction->paypal));  echo '<br/>'; 

} else {
    print_r("Error Message: " . $result->message);
    foreach($result->errors->deepAll() AS $error) {
        var_dump($error->code . ": " . $error->message . "\n");
    }
}

?>


