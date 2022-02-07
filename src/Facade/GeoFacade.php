<?php

namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;
use KMLaravel\GeographicalCalculator\Classes\Geo;

/**
 * @method Geo setPoint(array $point)
 * @method Geo setPoints(array $points)
 * @method Geo setOptions(array $options)
 * @method Geo setMainPoint(array $point)
 * @method Geo setDiameter(int $diameter)
 * @method Geo clearResult()
 * @method Geo getDistance($callback)
 * @method Geo getCenter($callback)
 * @method Geo allFeatures($callback)
 * @method Geo getClosest()
 * @method Geo getFarthest()
 * @method Geo getOrderByNearestNeighbor()
 * @method Geo isInArea()
 */
class GeoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GeoFacade';
    }
}
