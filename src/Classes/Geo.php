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
     * sin value
     *
     * @author karam mustafa
     * @var float|int
     */
    private $sin;

    /**
     * results
     *
     * @author karam mustafa
     * @var array
     */
    private $result = [];

    /**
     * cos value
     *
     * @author karam mustafa
     * @var float|int
     */
    private $cos;
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
     * get the available units.
     *
     * @return array
     * @author karam mustafa
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param  array  $units
     *
     * @return Geo
     * @author karam mustaf
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

    /**
     * for develop and resolve any options
     *
     * @author karam mustafa
     * @var array
     */
    private $options;

    /**
     * @return array
     * @author karam mustaf
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param  array  $options
     *
     * @return Geo
     * @author karam mustaf
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return mixed
     *
     * @author karam mustaf
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param  mixed  $result
     *
     * @return Geo
     * @author karam mustaf
     */
    public function setResult($result)
    {
        $this->result = array_merge($this->result, $result);

        return $this;
    }

    /**
     * @return array
     * @author karam mustaf
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param $point
     *
     * @return Geo
     * @author karam mustaf
     */
    public function setPoint($point)
    {
        $this->points[] = $point;

        return $this;
    }

    /**
     * @param  array  $points
     *
     * @return Geo
     * @author karam mustaf
     */
    public function setPoints($points)
    {
        $this->points = array_merge($this->points, $points);

        return $this;
    }

    /**
     * instance constructor.
     *
     * @author karam mustafa
     */
    public function __construct()
    {
        $this->resolveUnits();
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
        $position = '';

        foreach ($this->getPoints() as $index => $point) {

            if (isset($this->getPoints()[$index + 1])) {
                // init and calc sin value
                $this->sin = $this->getAngle($point[0], $this->getPoints()[$index + 1][0], 'sin');
                // init and calc cos value
                $this->cos = $this->getAngle($point[0], $this->getPoints()[$index + 1][0], 'cos');
                // set formatted key in result property.
                $position = ($index + 1).'-'.($index + 2);

                $this->lon1 = $point[1];

                $this->lon2 = $this->getPoints()[$index + 1][1];
                // save the results.
                $this->setResult(["$position" => $this->calcDistance()]);
            }

        }

        return sizeof($this->getResult()) == 1
            ? $this->getResult()["$position"]
            : $this->getResult();
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

        $options = $this->getOptions();

        if (isset($options['units']) && sizeof($options['units']) > 0) {

            foreach ($options['units'] as $unit) {
                $this->checkIfUnitExists($unit);
                $result[$unit] = $distance * $this->getUnits()[$unit];
            }

        } else {
            $result['mile'] = $distance * $this->getUnits()['mile'];
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
            $this->setUnits(config('geographical_calculator.units'));
        }
    }

    /**
     * @param  string  $unit
     * check if current units its available in units property or config file
     *
     * @return void
     * @throws \Exception
     * @author karam mustafa
     */
    private function checkIfUnitExists($unit)
    {
        if (!isset($this->getUnits()[$unit])) {
            throw new Exception("the unit ['$unit'] dose not available in units config");
        }
    }
}
