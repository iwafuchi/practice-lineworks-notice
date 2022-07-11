<?php

require './vendor/autoload.php';

use Models\Env;

echo Env::get("GREETING");

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// echo phpinfo();
// print_r($_ENV);
// // .envファイルで定義したGREETINGを変数に代入
// $greeting = $_ENV['GREETING'];

// print ($greeting) . PHP_EOL;
