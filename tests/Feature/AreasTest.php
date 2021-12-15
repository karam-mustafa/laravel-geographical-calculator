<?php

namespace KMLaravel\GeographicalCalculator\Tests\Feature;

use KMLaravel\GeographicalCalculator\Facade\GeoFacade;
use PHPUnit\Framework\TestCase;

class AreasTest extends TestCase
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
        $result = GeoFacade::setPoint([22, 37])
            ->setPoint([33, 40])
            ->getCenter();

        $this->assertEquals([
            'lat' => 27.508023496931,
            'long' => 38.424795502212,
        ], $result);
    }
}
