<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Classes\Geo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class DistanceTest extends OrchestraTestCase
{
    /**
     * test if the distance equal the correct distance by given coordinate.
     *
     * @return void
     * @throws \Exception
     *
     */
    public function test_distance()
    {
        $result = (new Geo())->setPoint([22, 37])
            ->setOptions(['units' => ['km']])
            ->setPoint([33, 40])
            ->getDistance();

        $this->assertEquals([
            '1-2' => ['km' => 1258.1691302282],
        ], $result);
    }
}
