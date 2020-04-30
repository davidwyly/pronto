<?php

use PHPUnit\Framework\TestCase;
use Davidwyly\Pronto\Model\Fibonacci;


class FibonacciTest extends TestCase
{

    public function testCalculateValueByIndex()
    {
        $fixture1 = [0, 1, 1, 2, 3, 5, 8, 13, 21];
        for ($i = 0; $i < count($fixture1); $i++) {
            $this->assertEquals($fixture1[$i], Fibonacci::calculateValueByIndex($i), "index: $i");
        }

        $fixture2 = [0, 1, -1, 2, -3, 5, -8, 13, -21];
        for ($i = 0; $i < count($fixture2); $i++) {
            $j = $i * -1;
            $this->assertEquals($fixture2[$i], Fibonacci::calculateValueByIndex($j), "index: $j");
        }
    }
}