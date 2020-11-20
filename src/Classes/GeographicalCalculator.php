<?php


namespace KMLaravel\GeographicalCalculator\Classes;

use Exception;
use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeographicalCalculator;
use KMLaravel\GeographicalCalculator\Interfaces\GeographicalCalculatorInterface;

class GeographicalCalculator extends AbstractGeographicalCalculator implements GeographicalCalculatorInterface
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
    private $units = [
        'mile' => 1,
        'km' => 1.609344,
        'm' => (1.609344 * 1000),
        'cm' => (1.609344 * 100),
        'mm' => (1.609344 * 1000 * 1000),
    ];

    /**
     * GetDistance constructor.
     * @param $lat1
     * @param $lat2
     * @param $lon1
     * @param $lon2
     * @param array $options
     * @return GeographicalCalculator
     * @author karam mustafa
     */
    static function initCoordinates($lat1, $lat2, $lon1, $lon2, $options = []): GeographicalCalculator
    {
        $GetDistance = new self();
        $GetDistance->lat1 = $lat1;
        $GetDistance->lat2 = $lat2;
        $GetDistance->lon1 = $lon1;
        $GetDistance->lon2 = $lon2;
        $GetDistance->options = $options;
        $GetDistance->resolveUnits();
        return $GetDistance;
    }

    /**
     * @desc get final length between the given points
     * @return array
     * @throws Exception
     * @author karam mustafa
     * @author karam mustafa
     */
    public function getLength(): array
    {
        // init and calc sin value
        $this->sin = $this->getAngle($this->lat1, $this->lat2, 'sin');
        // init and calc cos value
        $this->cos = $this->getAngle($this->lat1, $this->lat2, 'cos');
        return $this->calcDistance();
    }

    /**
     * @desc get the sin or cos values multiply
     * @param $val1
     * @param $val2
     * @param string $angle
     * @return float
     * @author karam mustafa
     */
    public function getAngle($val1, $val2, $angle = 'sin'): float
    {
        // convert the first value to radian and get result sin or cos method
        $res1 = $angle(deg2rad($val1));
        // convert the second value to radian and get result sin or cos method
        $res2 = $angle(deg2rad($val2));
        return ($res1 * $res2);
    }

    /**
     * @desc get theta angle
     * @return float
     * @author karam mustafa
     */
    private function getValueForAngleBetween(): float
    {
        return cos(deg2rad($this->lon1 - $this->lon2));
    }

    /**
     * @desc calculation distance process
     * @return array
     * @throws Exception
     * @author karam mustafa
     */
    private function calcDistance(): array
    {
        $distance = acos($this->sin + $this->cos * $this->getValueForAngleBetween());
        return $this->resolveDistanceWithUnits($this->correctDistanceValue(rad2deg($distance)));
    }

    /**
     * @param $distance
     * @return float
     * @author karam mustafa
     */
    private function correctDistanceValue($distance): float
    {
        return ($distance * 60 * 1.1515);
    }

    /**
     * @desc check if user chose any units
     * @param float $distance
     * @return array
     * @throws Exception
     * @author karam mustafa
     */
    private function resolveDistanceWithUnits(float $distance): array
    {
        $result = [];
        if (isset($this->options['units']) && sizeof($this->options['units']) > 0) {
            foreach ($this->options['units'] as $unit) {
                $this->chackIfUnitExists($unit);
                $result[$unit] = $distance * $this->units[$unit];
            }
        } else {
            $result['mile'] = $distance * $this->units['mile'];
        }
        return $result;
    }

    /**
     * @desc check if user chose any units
     * @author karam mustafa
     */
    private function resolveUnits()
    {
        if (config('geographical_calculator.units')) $this->units = config('geographical_calculator.units');
    }

    /**
     * @param string $unit
     * @desc check if current units its aviliable in units property or config file
     * @return boolean
     * @throws Exception
     * @author karam mustafa
     */
    private function chackIfUnitExists($unit)
    {
        if (!isset($this->units[$unit])) {
            throw new Exception("the unit ['$unit'] dosn't aviliable in units config");
        }
    }
}
