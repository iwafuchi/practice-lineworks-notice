<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use Models\lineworks\Notice;

session_start();
$_SESSION['username'] = "John";

$notice = new Notice();
echo $notice->notifyMessage("sho@iwafuchi", "こんにちは");
