<?php

namespace Davidwyly\Pronto\Model;

class Fibonacci {
    static public function calculateValueByIndex($index) {
        if ($index === 0
            || $index === 1
            || $index === -1
        ) {
            return abs($index);
        }

        $calculated  = 0;
        $last        = 1;
        $second_last = 0;
        for ($i = 2; $i <= abs($index); $i++) {
            $calculated  = $last + $second_last;
            $second_last = $last;
            $last        = $calculated;
        }

        if ($index < 0
            && ($index % 2 === 0)
        ) {
            $calculated = $calculated * -1;
        }
        return $calculated;
    }
}