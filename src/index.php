<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use Models\Env;
use Models\lineworks\Notice;

$notice = new Notice();
echo $notice->notifyMessage("sho@iwafuchi", "こんにちは");
