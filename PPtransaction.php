<?php
require_once 'lib/Braintree.php';
session_start();



$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$sypyzs38xxxgm9pq$25a89b8fab203be7ae5cec73b05a8ed2',
));


$result = $gateway->transaction()->sale([
    "amount" => '19',
    'merchantAccountId' => 'USD',
    "paymentMethodNonce" => $_POST['payment_method_nonce'],
    "descriptor" => [
      "name" => "www*fgtttteee"
    ],
     "shipping" => [
      "firstName" => "Jen",
      "lastName" => "Smith",
      "company" => "Braintree",
      "streetAddress" => "1 E 1st St",
      "extendedAddress" => "Suite 403",
      "locality" => "Bartlett",
      "region" => "IL",
      "postalCode" => "60103",
      "countryCodeAlpha2" => "US"
    ],
    "options" => [
      "paypal" => [
        "customField" => '123',
        "description" => '345777777'
      ],
    ]
]);


if ($result->success) {
    var_dump("Success ID: " . $result);
} else {
    foreach($result->errors->deepAll() AS $error) {
        var_dump($error->code . ": " . $error->message . "\n");
    }
}


