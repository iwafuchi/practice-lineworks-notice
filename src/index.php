<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use Models\Env;
use Models\lineworks\AccessToken;

echo Env::get("GREETING");
$accessToken = new AccessToken();
$accessToken->getAccessToken();
