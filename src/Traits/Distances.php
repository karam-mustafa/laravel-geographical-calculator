<?php

namespace KMLaravel\GeographicalCalculator\Traits;

use Exception;

trait Distances
{
    use DataStorage;
    use Formatter;
    use Debugger;
    /**
     * @author karam mustafa
     *
     * @var array
     */
    private $longs = [];
    /**
     * sin value.
     *
     * @author karam mustafa
     *
     * @var float|int
     */
    private $sin;
    /**
     * cos value.
     *
     * @author karam mustafa
     *
     * @var float|int
     */
    private $cos;

    /**
     * @return float|int
     *
     * @author karam mustaf
     */
    public function getSin()
    {
        return $this->sin;
    }

    /**
     * @param  float|int  $sin
     *
     * @return Distances
     *
     * @author karam mustaf
     */
    public function setSin($sin)
    {
        $this->sin = $sin;

        return $this;
    }

    /**
     * @return float|int
     *
     * @author karam mustaf
     */
    public function getCos()
    {
        return $this->cos;
    }

    /**
     * @return mixed
     *
     * @author karam mustaf
     */
    public function getLongs()
    {
        return $this->longs;
    }

    /**
     * @param $val
     *
     * @return Distances
     *
     * @author karam mustaf
     */
    public function setLongitude($val)
    {
        $this->longs[] = $val;

        return $this;
    }

    /**
     * @param  float|int  $cos
     *
     * @return Distances
     *
     * @author karam mustaf
     */
    public function setCos($cos)
    {
        $this->cos = $cos;

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
     * Finding the distance of points using several given coordinate points.
     *
     * @return array
     *
     * @throws Exception
     *
     * @author karam mustafa
     * @author karam mustafa
     */
    public function getDistance()
    {
        foreach ($this->getPoints() as $index => $point) {
            // check if we are not arrive to the last point yet.
            if (isset($this->getPoints()[$index + 1])) {
                // init and calc sin and cos value
                $this->setSin($this->getAngle($point[0], $this->getPoints($index + 1)[0], 'sin'))
                    ->setCos($this->getAngle($point[0], $this->getPoints($index + 1)[0], 'cos'))
                    // set the position of this loop at the local storage.
                    ->setInStorage('position', ($index + 1).'-'.($index + 2))
                    // set first longitude.
                    ->setLongitude($point[1])
                    // set second longitude.
                    ->setLongitude($this->getPoints($index + 1)[1])
                    // set the formatted key that bind with the prefix config.
                    ->setInStorage(
                        'distance_key',
                        $this->formatDistanceKey($this->getFromStorage('position'))
                    )
                    // save the results.
                    ->setResult([$this->getFromStorage('distance_key') => $this->calcDistance()]);
            }
        }

        return $this->getResult();
    }

    /**
     * get the sin or cos values multiply.
     *
     * @param  int  $firstLat
     * @param  int  $secondLat
     * @param  string  $angle
     *
     * @return float
     *
     * @author karam mustafa
     */
    private function getAngle($firstLat, $secondLat, $angle = 'sin')
    {
        // convert the first value to radian and get result sin or cos method
        // convert the second value to radian and get result sin or cos method
        return $angle(deg2rad($firstLat)) * $angle(deg2rad($secondLat));
    }

    /**
     * get theta angle.
     *
     * @return float
     *
     * @author karam mustafa
     */
    private function getValueForAngleBetween()
    {
        return cos(deg2rad($this->getLongs()[0] - $this->getLongs()[1]));
    }

    /**
     * calculation distance process.
     *
     * @return array
     *
     * @throws Exception
     *
     * @author karam mustafa
     */
    private function calcDistance()
    {
        $distance = acos($this->getSin() + $this->getCos() * $this->getValueForAngleBetween());

        return $this->resolveDistanceWithUnits($this->correctDistanceValue(rad2deg($distance)));
    }

    /**
     * @param $distance
     *
     * @return float
     *
     * @author karam mustafa
     */
    private function correctDistanceValue($distance)
    {
        return $distance * 60 * 1.1515;
    }

    /**
     * check if user chose any units.
     *
     * @param  float  $distance
     *
     * @return array
     *
     * @throws Exception
     *
     * @author karam mustafa
     */
    private function resolveDistanceWithUnits($distance)
    {
        // loop in each unit and solve the distance.
        foreach ($this->getOptions()['units'] as $unit) {
            // check if the unit isset.
            $this->checkIfUnitExists($unit)
                // set the result in storage.
                ->setInStorage($unit, $distance * $this->getUnits()[$unit]);
        }
        // remove un required results and get the results from storage.
        return $this->removeFromStorage('position', 'distance_key')->getFromStorage();
    }


    /**
     * check if user chose any units.
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
     * check if current units its available in units property or config file.
     *
     * @param  string  $unit
     *
     * @return Distances
     *
     * @throws \Exception
     *
     * @author karam mustafa
     */
    private function checkIfUnitExists($unit)
    {
        if (!isset($this->getUnits()[$unit])) {
            throw new Exception("the unit ['$unit'] dose not available in units config");
        }

        return $this;
    }
}
