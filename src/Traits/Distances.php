<?php

namespace KMLaravel\GeographicalCalculator\Traits;

use Exception;

trait Distances
{
    use DataStorage;
    use Formatter;
    use Debugger;
    use Looper;
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
     * available units.
     *
     * @author karam mustafa
     *
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
     * all the points to handle the selected requirement.
     *
     * @author karam mustafa
     *
     * @var array
     */
    public $points = [];

    /**
     * @param  null  $index
     *
     * @return array
     *
     * @author karam mustaf
     */
    public function getPoints($index = null)
    {
        return isset($this->points[$index])
            ? $this->points[$index]
            : $this->points;
    }

    /**
     * @param $point
     *
     * @return DataStorage
     *
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
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function setPoints($points)
    {
        $this->points = array_merge($this->points, $points);

        return $this;
    }

    /**
     * get the available units.
     *
     * @return array
     *
     * @author karam mustafa
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param  array  $units
     *
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

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
     * @param  null|callback  $callback
     *
     * @return array|\Illuminate\Support\Collection
     *
     * @throws \Exception
     * @author karam mustafa
     * @author karam mustafa
     */
    public function getDistance($callback = null)
    {
        $this->loop($this->getPoints(), function ($index, $point) {
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
        });

        return isset($callback)
            ? $callback(collect($this->getResult()))
            : $this->getResult();
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
        $this->setInStorage('distance',
            acos($this->getSin() + $this->getCos() * $this->getValueForAngleBetween())
        )->setInStorage('rad2deg',
            rad2deg($this->getFromStorage('distance'))
        )->setInStorage('correctDistanceValue',
            $this->correctDistanceValue($this->getFromStorage('rad2deg'))
        );

        return $this->resolveDistanceWithUnits($this->getFromStorage('correctDistanceValue'));
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
        if (isset($this->getOptions()['units']) &&
            sizeof($this->getOptions('units')) > 0
        ) {
            // loop in each unit and solve the distance.
            $this->loop($this->getOptions()['units'], function ($index, $unit) use ($distance) {
                $this->checkIfUnitExists($unit)
                    // set the result in storage.
                    ->setInStorage($unit, $distance * $this->getUnits()[$unit]);
            });

        } else {
            // if there are not units, then get the default units property.
            $this->setInStorage('mile', $distance * $this->getUnits()['mile']);
        }

        // remove un required results and get the results from storage.
        return $this
            ->removeFromStorage('position', 'distance_key', 'distance', 'rad2deg', 'correctDistanceValue')
            ->getFromStorage();
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
