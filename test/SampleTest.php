<?php

declare(strict_types=1);

require_once "./src/Sample.php";

use PHPUnit\Framework\TestCase;
use app\src\Sample;

class SampleTest extends TestCase {
    public function testHello() {
        $sample = new Sample();

        $result = $sample->hello();

        $this->assertEquals("Hello", $result);
    }
}
