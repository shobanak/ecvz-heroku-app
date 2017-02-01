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

  var_dump("This is var dump of result->transaction->paypal : " . $result->transaction->paypal);
  var_dump("This is var dump of result->transaction->paypal->captureId : " . $result->transaction->paypal->captureId);
  echo '<pre>'; print_r("This is print_r: " . $result->transaction->paypal[captureId]); echo '</pre>';   
  /*
  var_dump("This is var dump: " . $result->transaction->paypal);
  echo '<pre>'; print_r("This is print_r: " . $result); echo '</pre>';   
  echo '<pre>'; echo json_encode($result->transaction->paypal); echo '</pre>'; 
  print "<pre>";
  print "</pre>";
 
  */

  //echo $result ;
  echo json_encode($result->transaction->paypal);


  foreach($result->errors->deepAll() AS $error) {
    var_dump($error->code . ": " . $error->message . "\n");
  }

} else {
    print_r("Error Message: " . $result->message);
    foreach($result->errors->deepAll() AS $error) {
        var_dump($error->code . ": " . $error->message . "\n");
    }
}


