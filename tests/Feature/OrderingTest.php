<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Classes\Geo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class OrderingTest extends OrchestraTestCase
{
    /**
     * @throws \Exception
     *
     * @return void
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
                14.44339,
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
                14.44339,
            ],
        ], $result);
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function test_farthest_point_of_set_points()
    {
        $result = $this->newGeoInstance()
            ->setMainPoint([40.9171863, 14.1632638])
            ->setPoint([40.92945, 14.44301])
            ->setPoint([40.92918, 14.44339])
            ->getFarthest();

        $this->assertEquals([
            // the key is the index of points insertion.
            0 => [
                40.92945,
                14.44301,
            ],
        ], $result);

        $result = $this->newGeoInstance()
            ->setMainPoint([40.9171863, 14.1632638])
            ->setPoint([40.92918, 14.44339])
            ->setPoint([40.92945, 14.44301])
            ->getFarthest();
        // now the closest point index should be 1
        $this->assertEquals([
            1 => [
                40.92945,
                14.44301,
            ],
        ], $result);
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function test_order_by_nearest_neighbor_algorithm()
    {
        $result = $this->newGeoInstance()
            ->setMainPoint([40.9171863, 14.1632638])
            ->setPoint([40.92945, 14.44301])
            ->setPoint([40.92918, 14.44339])
            ->getOrderByNearestNeighbor();
        // this data already ordered.
        // so we depend on the returned keys to test the results.
        $this->assertEquals([
            [0, 1, 2],
        ], [collect($result)->keys()->toArray()]);

        // now we will re implement the same points
        // We will arrange the points in a slightly different order
        // and the order of the points should remain in the correct order

        $result = $this->newGeoInstance()
            ->setMainPoint([40.9171863, 14.1632638])
            ->setPoint([40.92918, 14.44339])
            ->setPoint([40.92945, 14.44301])
            ->getOrderByNearestNeighbor();

        $this->assertEquals([
            [0, 2, 1],
        ], [collect($result)->keys()->toArray()]);
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
