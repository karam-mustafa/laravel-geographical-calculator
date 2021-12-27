<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Classes\Geo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class OrderingTest extends OrchestraTestCase
{
    /**
     *
     * @return void
     * @throws \Exception
     *
     */
    public function test_closest_point_of_set_points()
    {
        $result = $this->newGeoInstance()
            ->setMainPoint([40.9171863, 14.1632638])
            ->setPoint([40.92945, 14.44301])
            ->setPoint([40.92918, 14.44339])
            ->getClosest();

        $this->assertEquals([
            // the key is the index of points insertion.
            1 => [
                40.92918,
                14.44339
            ],
        ], $result);

        $result = $this->newGeoInstance()
            ->setMainPoint([40.9171863, 14.1632638])
            ->setPoint([40.92918, 14.44339])
            ->setPoint([40.92945, 14.44301])
            ->getClosest();
        // now the closest point index should be 2
        $this->assertEquals([
            0 => [
                40.92918,
                14.44339
            ],
        ], $result);

    }

    /**
     * get clean instance of geo class.
     *
     * @return Geo|GeoInterface
     * @author karam mustafa
     */
    public function newGeoInstance(){
        return (new Geo())->clearResult();
    }
}
