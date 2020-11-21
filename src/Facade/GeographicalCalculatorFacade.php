<?php


namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KMLaravel\GeographicalCalculator\Classes\GeographicalCalculator initCoordinates($lat1, $lat2, $lon1, $lon2, $options)
 * @method \KMLaravel\GeographicalCalculator\Classes\GeographicalCalculator getDistance()
 */
class GeographicalCalculatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GeographicalCalculatorFacade';
    }
}
