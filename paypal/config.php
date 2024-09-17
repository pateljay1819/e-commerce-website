<?php
require 'vendor/autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

$apiContext = new ApiContext(
    new OAuthTokenCredential(
        'AQswlkYsVTiuvEJ0pldQrjQB-xtA0MgNt2yNrGN3VaZBjOyTPTtL5AwIyMeTV489zNaa_9pvIy9lrQB1',     // ClientID
        'EMgNY7fC_Jw-HDY2dF39tnTLJuqCDOEaFXrJfJNdH0j1tZ3x6AxpZ6AZSBuwTMrcbRvD7liFTPsTihgP'      // ClientSecret
    )
);

$apiContext->setConfig(
    array(
        'mode' => 'sandbox', // or 'live'
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'FINE', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
        'validation.level' => 'log',
        'cache.enabled' => true,
        // 'http.CURLOPT_CONNECTTIMEOUT' => 30
        // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
    )
);
