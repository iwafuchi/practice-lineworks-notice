<?php

declare(strict_types=1);

namespace Models;

require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class EnvTest extends TestCase {
    private static $dotenv;
    public function testGet() {
        $key = "GREETING";
        if ((self::$dotenv instanceof Dotenv) === false) {
            $dotenv = Dotenv::createImmutable(__DIR__ . "/../src/models");
            $dotenv->load();
        }
        $result = array_key_exists($key, $_ENV) ? $_ENV[$key] : null;
        $this->assertSame("Hello", $result);
    }
}
