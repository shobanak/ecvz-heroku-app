
<?php

require_once 'lib/Braintree.php';

$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$sypyzs38xxxgm9pq$25a89b8fab203be7ae5cec73b05a8ed2',
));


$clientToken = $gateway->clientToken()->generate();

?>

<html>
<form id="checkoutfrm" action="server.php" method="post">     
     <h1>Express Checkout - v.zero SDK(ECVZ) </h1><br>  
     <p>Client Token generated by server side SDK. This should not be reused, a new client token should be generated for each customer request : <pre><?echo $clientToken?></pre></p>  
     <input type="hidden" name="payment_method_nonce" id="payment_method_nonce" value="" />
     <h4>Order Details</h4>
     Transaction Amount: <input type="text" name="txnamount" id="txnamount" value="10.00"><br>
     Transaction Currency: <input type="text" name="txncur" id="txncur" value="SGD" readonly><br>
     Order ID: <input type="text" name="orderid" id="orderid" value="ABC12780"><br>
     Order Description: <input type="text" name="orderdesc" id="orderdesc" value="pair of socks"><br><br>
     <h4>Shipping Details</h4>
    <p>This address overrides the addresses available in your PayPal wallet</p>
     Line 1: <input type="text" name="addline1" id="addline1" value="1, Palm Road" readonly><br>
     Line 2: <input type="text" name="addline2" id="addline2" value="Unit 04-03" readonly><br>
     City: <input type="text" name="addcity" id="addcity" value="Singapore" readonly><br>
     Country Code: <input type="text" name="countrycode" id="countrycode" value="SG" readonly><br>
     State : <input type="text" name="state" id="state" value="SG" readonly><br>
     Postal Code: <input type="text" name="postalcode" id="postalcode" value="457448" readonly><br>
     Phone No: <input type="text" name="phone" id="phone" value="6598127355" readonly><br><br>

 </form>

<script src="https://js.braintreegateway.com/web/3.6.3/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.6.3/js/paypal.min.js"></script>
<script src="https://www.paypalobjects.com/api/button.js?"
     data-merchant="braintree"
     data-id="paypal-button"
     data-button="checkout"
     data-color="gold"
     data-size="medium"
     data-shape="pill"
     data-button_type="submit"
     data-button_disabled="false"
 ></script>

<script type="text/javascript">
var paypalButton = document.getElementById('paypal-button');

// Create a Client component
braintree.client.create({
  authorization: "<?php echo $clientToken ?>",  
}, function (clientErr, clientInstance) {
  // Create PayPal component
  braintree.paypal.create({
    client: clientInstance
  }, function (err, paypalInstance) {
    paypalButton.addEventListener('click', function () {
      // Tokenize here!
      paypalInstance.tokenize({
        flow: 'checkout', // Required
        intent: 'sale',       
        amount: document.getElementById('txnamount').value, // Required
        currency: 'SGD', // Required
        locale: 'en_US',
        enableShippingAddress: true,
        shippingAddressEditable: false,
        shippingAddressOverride: {
          recipientName: 'Buyer One',
          line1: document.getElementById('addline1').value,
          line2: document.getElementById('addline2').value,
          city: document.getElementById('addcity').value,
          countryCode: document.getElementById('countrycode').value,
          postalCode: document.getElementById('postalcode').value,
          state: document.getElementById('state').value,
          phone: document.getElementById('phone').value
        }
      }, function (err, tokenizationPayload) {
        
        // Tokenization complete
        document.getElementById('payment_method_nonce').value = tokenizationPayload.nonce;
        document.getElementById('checkoutfrm').submit();
      });
    });
  });
});
</script>
</html>

