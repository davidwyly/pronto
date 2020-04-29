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
        try {
            $distribution  = new LeadingDigitDistribution();
            for ($i = 0; $i < 1000; $i++) {
                $fibonacci    = Fibonacci::calculateValueByIndex($i);
                $leadingDigit = LeadingDigitDistribution::getLeadingDigit($fibonacci);
                $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            }
            $results = $this->calculateResults($distribution);
            $this->renderSuccess($results);
        } catch (Exception $e) {
            $this->renderFail($e);
        }
    }

    public function custom() {
        try {
            $data = $this->request->post;
            $values = (array)$data['json'];
            $distribution = new LeadingDigitDistribution();
            foreach ($values as $key => $value) {
                $leadingDigit = LeadingDigitDistribution::getLeadingDigit($value);
                $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            }
            $results = $this->calculateResults($distribution);
            $this->renderSuccess($results);
        } catch (\Exception $e) {
            $this->renderFail($e);
        }
    }

    /**
     * @param LeadingDigitDistribution $distribution
     *
     * @return array
     * @throws Exception
     */
    private function calculateResults(LeadingDigitDistribution $distribution) {
        $results = [];
        for ($i = 1; $i <= 9; $i++) {
            $actual                  = $distribution->getDistributionByDigit($i);
            $expected                = LeadingDigitDistribution::getProbabilityFromBenfordsLaw($i);
            $variance                = round($actual - $expected, 6);
            $results[$i]['expected'] = round($expected * 100, 4) . '%';
            $results[$i]['actual']   = round($actual * 100, 4) . '%';
            $results[$i]['variance'] = round($variance * 100, 4) . '%';
        }
        return $results;
    }
}