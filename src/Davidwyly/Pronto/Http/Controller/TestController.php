<?php

declare(strict_types=1);

namespace Davidwyly\Pronto\Http\Controller;

use Davidwyly\Pronto\Http\Controller\Collect;
use Davidwyly\Pronto\Http\Controller\Parse;
use Davidwyly\Pronto\Exception\ControllerException;
use Davidwyly\Pronto\Model\LeadingDigitDistribution;
use Davidwyly\Pronto\Model\Fibonacci;
use Exception;

class TestController extends Controller
{
    use Collect\Json;
    use Collect\Xml;

    /**
     * @throws Exception
     */
    function fibonacci() {
        $distribution = new LeadingDigitDistribution();
        $leadingDigits = [];
        for ($i = 0; $i < 1000; $i++) {
            $fibonacci = Fibonacci::calculateValueByIndex($i);
            $leadingDigit = LeadingDigitDistribution::getLeadingDigit($fibonacci);
            $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            $leadingDigits[] = $leadingDigit;
        }
        $results = [];
        for ($i = 1; $i <= 9; $i++) {
            $actual = $distribution->getDistributionByDigit($i);
            $expected = LeadingDigitDistribution::getProbabilityFromBenfordsLaw($i);
            $variance = round($actual - $expected, 6);
            $results[$i]['expected'] = round($expected * 100,4) . '%';
            $results[$i]['actual'] = round($actual * 100,4) . '%';
            $results[$i]['variance'] = round($variance * 100,4) . '%';
        }
        $this->renderSuccess($results);
    }
}