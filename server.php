<?php
require_once 'lib/Braintree.php';
session_start();



$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$sypyzs38xxxgm9pq$25a89b8fab203be7ae5cec73b05a8ed2',
));


$result = $gateway->transaction()->sale([
    "amount" => '10',
    //'merchantAccountId' => 'USD',
    "paymentMethodNonce" => $_POST['payment_method_nonce'],
    //"descriptor" => [
     // "name" => "PP*Merchant"
    //],
     "shipping" => [
      "firstName" => "Buyer",
      "lastName" => "One",     
      "streetAddress" => "1, Palm Road",
      "extendedAddress" => "Unit 04-03",
      "locality" => "Singapore",      
      "postalCode" => "457448",
      "countryCodeAlpha2" => "SG"
    ],
    "options" => [
      "paypal" => [
        "customField" => 'Item number AXU128903',
        "description" => 'Pair of trousers'
      ],
    ]
]);


if ($result->success) {
    var_dump("This is var dump: " . $result);
    echo '<pre>'; print_r("This is print_r: " . $result); echo '</pre>';   
    echo '<pre>'; echo json_encode($result->transaction->paypal); echo '</pre>';     
} else {
    print_r("Error Message: " . $result->message);
    foreach($result->errors->deepAll() AS $error) {
        var_dump($error->code . ": " . $error->message . "\n");
    }
}


