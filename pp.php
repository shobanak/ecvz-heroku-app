

<?php

require_once 'lib/Braintree.php';
$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$5hd3g65q5cq6xrck$168ceadab863c5058b1f74c6863a0902',
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

