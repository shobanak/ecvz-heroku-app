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

<html>
<h1>Express Checkout - v.zero SDK(ECVZ) Transaction Result Object </h1><br>  
     <p>Client Token generated by server side SDK: </p>  
</html>

if ($result->success) {
echo 'Here are  the details of the PayPal Transaction <br/>';
print_r("PayPal transaction ID is :" . $result->transaction->paypal[captureId]);  echo '<br/>';
print_r(json_encode($result->transaction->paypal));  echo '<br/>'; 

} else {
    print_r("Error Message: " . $result->message);
    foreach($result->errors->deepAll() AS $error) {
        var_dump($error->code . ": " . $error->message . "\n");
    }
}

?> 

