<?php


namespace KMLaravel\GeographicalCalculator\Classes;

use Exception;
use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;

class Geo extends AbstractGeo implements GeoInterface
{
    /**
     * all the points to handle the selected requirement
     *
     * @author karam mustafa
     * @var array
     */
    public $points = [];

    /**
     * first Latitude value
     *
     * @author karam mustafa
     * @var float|int
     */
    public $lat1;
    /**
     * second Latitude value
     *
     * @author karam mustafa
     * @var float|int
     */
    public $lat2;
    /**
     * first Longitude  value
     *
     * @author karam mustafa
     * @var float|int
     */
    public $lon1;
    /**
     * second Longitude  value
     *
     * @author karam mustafa
     * @var float|int
     */
    public $lon2;
    /**
     * sin value
     *
     * @author karam mustafa
     * @var float|int
     */
    private $sin;
    /**
     * cos value
     *
     * @author karam mustafa
     * @var float|int
     */
    private $cos;
    /**
     * for develop and resolve any options
     *
     * @author karam mustafa
     * @var array
     */
    private $options;
    /**
     * available units
     *
     * @author karam mustafa
     * @var array
     */
    private $units = [
        'mile' => 1,
        'km' => 1.609344,
        'm' => (1.609344 * 1000),
        'cm' => (1.609344 * 100),
        'mm' => (1.609344 * 1000 * 1000),
    ];
    /**
     * @return array
     * @author karam mustaf
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param  array  $points
     *
     * @return Geo
     * @author karam mustaf
     */
    public function setPoints($points)
    {
        $this->points[] = $points;

        return $this;
    }

    /**
     * instance constructor.
     *
     * @param $lat1
     * @param $lat2
     * @param $lon1
     * @param $lon2
     * @param  array  $options
     *
     * @return Geo
     * @author karam mustafa
     */
    public function initCoordinates($lat1, $lat2, $lon1, $lon2, $options = [])
    {
        $this->lat1 = $lat1;
        $this->lat2 = $lat2;
        $this->lon1 = $lon1;
        $this->lon2 = $lon2;
        $this->options = $options;

        $this->resolveUnits();

        return $this;
    }

    /**
     * get final length between the given points
     *
     * @return array
     * @throws Exception
     * @author karam mustafa
     * @author karam mustafa
     */
    public function getDistance()
    {
        // init and calc sin value
        $this->sin = $this->getAngle($this->lat1, $this->lat2, 'sin');
        // init and calc cos value
        $this->cos = $this->getAngle($this->lat1, $this->lat2, 'cos');
        return $this->calcDistance();
    }

    /**
     * get the sin or cos values multiply
     *
     * @param $val1
     * @param $val2
     * @param  string  $angle
     *
     * @return float
     * @author karam mustafa
     */
    private function getAngle($val1, $val2, $angle = 'sin')
    {
        // convert the first value to radian and get result sin or cos method
        $res1 = $angle(deg2rad($val1));
        // convert the second value to radian and get result sin or cos method
        $res2 = $angle(deg2rad($val2));
        return ($res1 * $res2);
    }

    /**
     * get theta angle
     *
     * @return float
     * @author karam mustafa
     */
    private function getValueForAngleBetween()
    {
        return cos(deg2rad($this->lon1 - $this->lon2));
    }

    /**
     * calculation distance process
     *
     * @return array
     * @throws Exception
     * @author karam mustafa
     */
    private function calcDistance()
    {
        $distance = acos($this->sin + $this->cos * $this->getValueForAngleBetween());
        return $this->resolveDistanceWithUnits($this->correctDistanceValue(rad2deg($distance)));
    }

    /**
     * @param $distance
     *
     * @return float
     * @author karam mustafa
     */
    private function correctDistanceValue($distance)
    {
        return ($distance * 60 * 1.1515);
    }

    /**
     * check if user chose any units
     *
     * @param  float  $distance
     *
     * @return array
     * @throws Exception
     * @author karam mustafa
     */
    private function resolveDistanceWithUnits($distance)
    {
        $result = [];
        if (isset($this->options['units']) && sizeof($this->options['units']) > 0) {
            foreach ($this->options['units'] as $unit) {
                $this->checkIfUnitExists($unit);
                $result[$unit] = $distance * $this->units[$unit];
            }
        } else {
            $result['mile'] = $distance * $this->units['mile'];
        }
        return $result;
    }

    /**
     * check if user chose any units
     *
     * @author karam mustafa
     */
    private function resolveUnits()
    {
        if (config('geographical_calculator.units')) {
            $this->units = config('geographical_calculator.units');
        }
    }

    /**
     * @param  string  $unit
     * check if current units its available in units property or config file
     *
     * @return boolean
     * @throws Exception
     * @author karam mustafa
     */
    private function checkIfUnitExists($unit)
    {
        if (!isset($this->units[$unit])) {
            throw new Exception("the unit ['$unit'] dose not available in units config");
        }
    }
}
