<?php


namespace KMLaravel\GeographicalCalculator\Traits;

use Exception;

trait Distances
{
    use LocalStorage, Formatter, Debugger;

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
        foreach ($this->getPoints() as $index => $point) {
            // check if we are not arrive to the last point yet.
            if (isset($this->getPoints()[$index + 1])) {
                // init and calc sin and cos value
                $this->setSin($this->getAngle($point[0], $this->getPoints()[$index + 1][0], 'sin'))
                    ->setCos($this->getAngle($point[0], $this->getPoints()[$index + 1][0], 'cos'))
                    // set the position of this loop at the local storage.
                    ->setInLocalStorage('position', ($index + 1).'-'.($index + 2), ['new' => true])
                    // set first longitude.
                    ->setLongitude($point[1])
                    // set second longitude.
                    ->setLongitude($this->getPoints()[$index + 1][1])
                    // set the formatted key that bind with the prefix config.
                    ->setInLocalStorage('distance_key',
                        $this->formatDistanceKey($this->getFromLocalStorage('position'))
                    )
                    // save the results.
                    ->setResult([$this->getFromLocalStorage('distance_key') => $this->calcDistance()])
                    // remove the saved keys in storage, because we dont want to return these values.
                    ->removeFromLocalStorage('position', 'distance_key');
            }

        }
        return $this->getResult();
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
        return cos(deg2rad($this->getLongs()[0] - $this->getLongs()[1]));
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
        $distance = acos($this->getSin() + $this->getCos() * $this->getValueForAngleBetween());
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

        $options = $this->getOptions();

        if (isset($options['units']) && sizeof($options['units']) > 0) {

            foreach ($options['units'] as $unit) {
                $this->checkIfUnitExists($unit)
                    ->setInLocalStorage($unit, $distance * $this->getUnits()[$unit]);
            }

        } else {
            $this->setInLocalStorage('mile', $distance * $this->getUnits()['mile']);
        }
        return $this->removeFromLocalStorage('position', 'distance_key')->getFromLocalStorage();
    }
}
