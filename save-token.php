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
    '4/0AXEQxIBjlrWv6Xt3t6slqI6R_GrAxNrbDMlV936BUUP8Hf_AQ4VMq0ujW5HCR22psIJ8Rw'
);

echo "<pre>";
print_r($token);
echo "</pre>";