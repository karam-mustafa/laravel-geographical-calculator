<?php

namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;
use KMLaravel\GeographicalCalculator\Classes\Geo;

/**
 * @method Geo setPoint(array $point)
 * @method Geo setPoints(array $points)
 * @method Geo setOptions(array $options)
 * @method Geo setMainPoint(array $point)
 * @method Geo clearResult()
 * @method Geo getDistance($callback)
 * @method Geo getCenter($callback)
 * @method Geo allFeature($callback)
 * @method Geo getClosest()
 * @method Geo getOrderByNearestNeighbor()
 */
class GeoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GeoFacade';
    }
}
