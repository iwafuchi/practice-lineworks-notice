<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Models\Env;
use Models\lineworks\AccessToken;

echo Env::get("GREETING");

$accessToken = new AccessToken();
$accessToken->getAccessToken();

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// echo phpinfo();
// print_r($_ENV);
// // .envファイルで定義したGREETINGを変数に代入
// $greeting = $_ENV['GREETING'];

// print ($greeting) . PHP_EOL;
