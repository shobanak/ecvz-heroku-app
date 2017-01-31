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
  //  var_dump("This is var dump: " . $result);
  // echo '<pre>'; print_r("This is print_r: " . $result); echo '</pre>';   
  // echo '<pre>'; echo json_encode($result->transaction->paypal); echo '</pre>'; 
  print "<pre>";
  echo json_encode($result->paypalDetails);
  print "</pre>";

  $decoded_array = json_decode($result, true);
  echo $decoded_array['transaction']['paypal']['captureId'];





  foreach($result->errors->deepAll() AS $error) {
    var_dump($error->code . ": " . $error->message . "\n");
  }

} else {
    print_r("Error Message: " . $result->message);
    foreach($result->errors->deepAll() AS $error) {
        var_dump($error->code . ": " . $error->message . "\n");
    }
}


