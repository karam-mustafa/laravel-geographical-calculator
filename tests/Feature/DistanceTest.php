<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Classes\Geo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class DistanceTest extends OrchestraTestCase
{
    /**
     * test if the distance equal the correct distance by given coordinate.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function test_distance_is_correct()
    {
        $result = $this->newGeoInstance()->setPoint([22, 37])
            ->setOptions(['units' => ['km']])
            ->setPoint([33, 40])
            ->getDistance();

        $this->assertEquals([
            '1-2' => ['km' => 1258.1691302282],
        ], $result);
    }

    /**
     * get clean instance of geo class.
     *
     * @return Geo|GeoInterface
     *
     * @author karam mustafa
     */
    public function newGeoInstance()
    {
        return (new Geo())->clearResult();
    }
}
