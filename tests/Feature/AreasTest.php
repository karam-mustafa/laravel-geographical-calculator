<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Classes\Geo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class AreasTest extends OrchestraTestCase
{
    /**
     * test if the center equal the correct center by given coordinates.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function test_center()
    {
        $result = $this->newGeoInstance()->setPoint([22, 37])
            ->setPoint([33, 40])
            ->getCenter();

        $this->assertEquals([
            'lat' => 27.508023496931,
            'long' => 38.424795502212,
        ], $result);
    }

    /**
     * get clean instance of geo class.
     *
     * @return Geo|GeoInterface
     * @author karam mustafa
     */
    public function newGeoInstance()
    {
        return (new Geo())->clearResult();
    }
}
