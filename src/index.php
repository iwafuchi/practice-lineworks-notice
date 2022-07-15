<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Models\lineworks\Notice;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notify Lineworks message bot</title>
</head>

<body>
    <h1>Notify Lineworks message bot</h1>
    <form method="post">
        <textarea name="message" rows="5" cols="40"></textarea>
        <p>
            <button type="submit" name="fetch" value="true">送信</button>
        </p>
    </form>
    <?php
    if (isset($_POST["fetch"]) && $_POST["fetch"]) {
        if (isset($_POST["message"]) && $_POST["message"]) {
            session_start();
            session_regenerate_id();
            $notice = new Notice();
            echo $notice->notifyMessage("sho@iwafuchi", $_POST["message"]);
        }
    }
    if (isset($_POST["fetch"])) {
        unset($_POST["fetch"]);
    }
    if (isset($_POST["message"])) {
        unset($_POST["message"]);
    }
    ?>
</body>

</html>