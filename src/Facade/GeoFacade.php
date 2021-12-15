<?php

namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;
use KMLaravel\GeographicalCalculator\Classes\Geo;

/**
 * @method Geo getDistance()
 * @method Geo setPoint(array $point)
 * @method Geo setPoints(array $points)
 * @method Geo setOptions(array $options)
 * @method Geo getCenter()
 */
class GeoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GeoFacade';
    }
}
