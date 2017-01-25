

<?php

require_once 'lib/Braintree.php';
$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$sypyzs38xxxgm9pq$25a89b8fab203be7ae5cec73b05a8ed2',
));
$clientToken = $gateway->clientToken()->generate();

echo $clientToken;
?>

<html>
<form id="checkout" action="PPtransaction.php" method="post">			
     <h1>EC V.Zero</h1>
     <input type="hidden" name="payment_method_nonce" id="payment_method_nonce" value="" />

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
        intent: 'sale'
        amount: 10.00, // Required
        currency: 'USD', // Required
        locale: 'en_US',
        enableShippingAddress: true,
        shippingAddressEditable: false,
        shippingAddressOverride: {
          recipientName: 'Scruff McGruff',
          line1: '1234 Main St.',
          line2: 'Unit 1',
          city: 'Chicago',
          countryCode: 'US',
          postalCode: '60652',
          state: 'IL',
          phone: '123.456.7890'
        }
      }, function (err, tokenizationPayload) {
        // Tokenization complete

         document.getElementById('payment_method_nonce').value = tokenizationPayload.nonce;
        document.getElementById('checkout').submit();
      });
    });
  });
});
</script>
</html>

