<?php

namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;
use KMLaravel\GeographicalCalculator\Classes\Geo;

/**
 * @method Geo initCoordinates($lat1, $lat2, $lon1, $lon2, $options)
 * @method Geo getDistance()
 * @method Geo setPoint()
 * @method Geo getCenter()
 */
class GeoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GeoFacade';
    }
}
