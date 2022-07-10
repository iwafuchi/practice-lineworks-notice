<?php

require './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// .envファイルで定義したGREETINGを変数に代入
$greeting = $_ENV['GREETING'];

print ($greeting) . PHP_EOL;
