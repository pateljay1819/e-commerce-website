<?php 
require 'PayPal-PHP-SDK/autoload.php';
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Payouts\PayoutsPostRequest;

// Set up PayPal environment
$clientId = 'AQswlkYsVTiuvEJ0pldQrjQB-xtA0MgNt2yNrGN3VaZBjOyTPTtL5AwIyMeTV489zNaa_9pvIy9lrQB1';
$clientSecret = 'EMgNY7fC_Jw-HDY2dF39tnTLJuqCDOEaFXrJfJNdH0j1tZ3x6AxpZ6AZSBuwTMrcbRvD7liFTPsTihgP';
$environment = new SandboxEnvironment($clientId, $clientSecret); // Use ProductionEnvironment for live

$client = new PayPalHttpClient($environment);

// Construct a request object and set desired parameters
$request = new PayoutsPostRequest();
$request->body = json_decode('
{
  "sender_batch_header": {
    "email_subject": "Payment for your service",
    "sender_batch_id": "batch_12345",
    "recipient_type": "EMAIL"
  },
  "items": [
    {
      "recipient_type": "EMAIL",
      "amount": {
        "value": "10.0",
        "currency": "USD"
      },
      "note": "Thank you.",
      "receiver": "receiver@example.com"
    }
  ]
}
');

// Call PayPal to create the payout
try {
  $response = $client->execute($request);

  // Handle successful response
  print "Payouts batch created with ID: " . $response->result->batch_header->payout_batch_id . "\n";
} catch (HttpException $ex) {
  // Handle exception
  print_r($ex->getMessage());
}
?>
