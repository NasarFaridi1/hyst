<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;

$client = new Client();

$client->setAuthConfig(__DIR__ . '/storage/app/oauth-client.json');

$client->setRedirectUri('https://hyst.uk/oauth2callback');

$client->addScope(Drive::DRIVE);

$client->setAccessType('offline');
$client->setPrompt('consent');

echo PHP_EOL;
echo "==========================================" . PHP_EOL;
echo "Open this URL in your browser:" . PHP_EOL . PHP_EOL;
echo $client->createAuthUrl() . PHP_EOL . PHP_EOL;
echo "==========================================" . PHP_EOL;

echo PHP_EOL;
echo "After authorizing Google, you'll be redirected to:" . PHP_EOL;
echo "https://hyst.uk/oauth2callback?code=xxxx" . PHP_EOL;
echo PHP_EOL;

echo "Paste ONLY the code here:" . PHP_EOL;

$code = trim(fgets(STDIN));

$token = $client->fetchAccessTokenWithAuthCode($code);

echo PHP_EOL;
print_r($token);