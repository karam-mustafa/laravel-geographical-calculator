<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Facade\GeoFacade;
use PHPUnit\Framework\TestCase;

class DistanceTest extends TestCase
{
    /**
     * test if the distance equal the correct distance by given coordinate.
     *
     * @return void
     * @throws \Exception
     */
    public function test_distance()
    {
        $class = GeoFacade::initCoordinates(22, 33, 37, 40, ['units' => ['km']]);
        $this->assertEquals([ "km" => 1258.1691302282 ], $class->getDistance());
    }
}
