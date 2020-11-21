<?php


namespace KMLaravel\GeographicalCalculator\Abstracts;

abstract class AbstractGeographicalCalculator
{
    /**
     * @desc first Latitude value
     * @var float|int
     * @author karam mustafa
     */
    public $lat1;
    /**
     * @desc second Latitude value
     * @var float|int
     * @author karam mustafa
     */
    public $lat2;
    /**
     * @desc first Longitude  value
     * @var float|int
     * @author karam mustafa
     */
    public $lon1;
    /**
     * @desc second Longitude  value
     * @var float|int
     * @author karam mustafa
     */
    public $lon2;
    /**
     * @desc sin value
     * @var float|int
     * @author karam mustafa
     */
    private $sin;
    /**
     * @desc cos value
     * @var float|int
     * @author karam mustafa
     */
    private $cos;
    /**
     * @desc for develop and resolve any options
     * @var array
     * @author karam mustafa
     */
    private $options;
    /**
     * @desc available units
     * @var array
     * @author karam mustafa
     */
    private $units = [];

    /**
     * @param $lat1
     * @param $lat2
     * @param $lon1
     * @param $lon2
     * @param array $options
     * @author karam mustafa
     */
     abstract static function initCoordinates($lat1, $lat2, $lon1, $lon2, $options = []);

    /**
     * @desc get the sin or cos values multiply
     * @param $val1
     * @param $val2
     * @param string $angle
     * @author karam mustafa
     */
    private function getAngle($val1, $val2, $angle = 'sin'){}

    /**
     * @desc get final Distance between the given points
     * @author karam mustafa
     */
    abstract public function getDistance();

    /**
     * @desc get theta angle
     * @author karam mustafa
     */
    private function getValueForAngleBetween(){}

    /**
     * @desc calculation distance process
     * @author karam mustafa
     */
    private function calcDistance(){}

    /**
     * @param $distance
     * @author karam mustafa
     */
    private function correctDistanceValue($distance){}

    /**
     * @desc check if user chose any units
     * @param float $distance
     * @author karam mustafa
     */
    private function resolveDistanceWithUnits(float $distance){}

    /**
     * @desc check if user chose any units
     * @author karam mustafa
     */
    private function resolveUnits(){}

    /**
     * @param string $unit
     * @desc check if current units its aviliable in units property or config file
     * @author karam mustafa
     */
    private function checkIfUnitExists($unit){}
}
