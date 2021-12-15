<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Facade\GeoFacade;
use PHPUnit\Framework\TestCase;

class DistanceTest extends TestCase
{
    /**
     * test if the distance equal the correct distance by given coordinate.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function test_distance()
    {
        $result = GeoFacade::setPoint([22, 37])
            ->setOptions(['units' => ['km']])
            ->setPoint([33, 40])
            ->getDistance();

        $this->assertEquals(['km' => 1258.1691302282], $result);
    }
}
