<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Classes\Geo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class AllFeaturesTest extends OrchestraTestCase
{
    /**
     * @throws \Exception
     *
     * @return void
     */
    public function test_get_all_feature()
    {
        $distance = $this->newGeoInstance()
            ->setOptions(['units' => ['km', 'mile', 'm', 'cm']])
            ->setPoint([40.92945, 14.44301])
            ->setPoint([40.92918, 14.44339])
            ->getDistance();

        $center = $this->newGeoInstance()
            ->setOptions(['units' => ['km', 'mile', 'm', 'cm']])
            ->setPoint([40.92945, 14.44301])
            ->setPoint([40.92918, 14.44339])
            ->getCenter();

        $all = $this->newGeoInstance()
            ->setOptions(['units' => ['km', 'mile', 'm', 'cm']])
            ->setPoint([40.92945, 14.44301])
            ->setPoint([40.92918, 14.44339])
            ->allFeatures();

        $this->assertEquals([
            'distance' => $distance,
            'center' => $center,
        ], $all);
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
