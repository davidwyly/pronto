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
    public function fibonacci()
    {
        try {
            $distribution  = new LeadingDigitDistribution();
            $leadingDigits = [];
            for ($i = 1; $i <= 50; $i++) {
                $fibonacci       = Fibonacci::calculateValueByIndex($i);
                $leadingDigit    = LeadingDigitDistribution::getLeadingDigit($fibonacci);
                $leadingDigits[] = $leadingDigit;
                $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            }
            $results = $this->calculateResults($distribution, $leadingDigits);
            $this->renderSuccess($results);
        } catch (Exception $e) {
            $this->renderFail($e);
        }
    }

    public function custom()
    {
        try {
            $data         = $this->request->post;
            $values       = (array)$data['json'];
            $distribution = new LeadingDigitDistribution();
            $leadingDigits = [];
            foreach ($values as $key => $value) {
                $leadingDigit = LeadingDigitDistribution::getLeadingDigit($value);
                $leadingDigits[] = $leadingDigit;
                $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            }
            $results = $this->calculateResults($distribution,$leadingDigits);
            $this->renderSuccess($results);
        } catch (\Exception $e) {
            $this->renderFail($e);
        }
    }

    /**
     * @param $values
     *
     * @return float
     */
    function standardDeviation($values)
    {
        $count    = count($values);
        $variance = 0.0;

        // calculating mean using array_sum() method
        $average = array_sum($values) / $count;

        foreach ($values as $i) {
            // sum of squares of differences between
            // all numbers and means.
            $variance += pow(($i - $average), 2);
        }

        return (float)sqrt($variance / ($count - 1));
    }

    function cr($t)
    {
        return $t[1] / $t[0];
    }

    /**
     *
     * @param $control
     * @param $treatment
     *
     * @return float|int
     */
    function zScore(array $control, array $treatment)
    {
        $c = $control;
        $t = $treatment;
        $z = $this->cr($t) - $this->cr($c);
        $s = ($this->cr($t) * (1 - $this->cr($t))) / $t[0] + ($this->cr($c) * (1 - $this->cr($c))) / $c[0];
        return $z / sqrt($s);
    }

    function marginOfError($zScore, $numberOfInterest, $sampleSize)
    {
        $p = $numberOfInterest / $sampleSize;
        return $zScore * sqrt(($p * (abs(1 - $p))) / $sampleSize);
    }

    /**
     * @param LeadingDigitDistribution $distribution
     * @param array                    $treatment
     *
     * @return array
     * @throws Exception
     */
    private function calculateResults(LeadingDigitDistribution $distribution, array $treatment)
    {
        $control = [];
        for ($i = 1; $i <= 9; $i++) {
            $control[] = LeadingDigitDistribution::getProbabilityFromBenfordsLaw($i);
        }

        $results                      = [];
        $zScore                       = $this->zScore($control, $treatment);
        $results['zScore']            = $zScore;
        $results['standardDeviation'] = $this->standardDeviation($treatment);
        for ($i = 1; $i <= 9; $i++) {
            $actual                                    = $distribution->getDistributionByDigit($i);
            $expected                                  = $control[$i - 1];
            $variance                                  = round($actual - $expected, 6);
            $marginOfError                             = $this->marginOfError(
                $zScore,
                $distribution->{'frequency' . $i},
                $distribution->getTotalCount()
            );
            $results[$i]['expected']                   = round($expected * 100, 4) . '%';
            $results[$i]['actual']                     = round($actual * 100, 4) . '%';
            $results[$i]['variance']                   = round($variance * 100, 4) . '%';
            $results[$i]['margin-of-error']            = round($marginOfError * 100, 4) . '%';
            $results[$i]['conforms-to-benford\'s-law'] = $this->isWithinMarginOfError(
                $expected,
                $actual,
                $marginOfError
            );
        }
        return $results;
    }

    private function isWithinMarginOfError($expected, $actual, $marginOfError)
    {
        if ($actual < ($expected + $marginOfError)
            && $actual > ($expected - $marginOfError)
        ) {
            return true;
        }
        return false;
    }
}