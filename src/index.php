<?php

declare(strict_types=1);

require_once('../vendor/autoload.php');

use Models\lineworks\Notice;

session_start();
session_regenerate_id();

if (!isset($_SESSION["count"])) {
    $_SESSION["count"] = 0;
}
$_SESSION["count"] = $_SESSION["count"] + 1;

$notice = new Notice();
echo $notice->notifyMessage("sho@iwafuchi", (string)$_SESSION["count"]);
