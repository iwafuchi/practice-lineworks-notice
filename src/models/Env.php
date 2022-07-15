<?php

declare(strict_types=1);

namespace Models;

use Dotenv\Dotenv;

class Env {
    private static $dotenv;
    public static function get($key) {
        if ((self::$dotenv instanceof Dotenv) === false) {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();
        }
        return array_key_exists($key, $_ENV) ? $_ENV[$key] : null;
    }
}
