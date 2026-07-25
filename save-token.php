<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;

$client = new Client();

$client->setAuthConfig(
    __DIR__ . '/storage/app/oauth-client.json'
);

$client->setRedirectUri('https://hyst.uk/oauth2callback');

$client->addScope(Drive::DRIVE);

$token = $client->fetchAccessTokenWithAuthCode(
    '4/0AXEQxIBxKnjpnYWBHYdN8_HzdMPV-qGU5dZn9KXBtX21MXPhyRXGeIlTHlANGpvC2gh35Q'
);

echo "<pre>";
print_r($token);
echo "</pre>";