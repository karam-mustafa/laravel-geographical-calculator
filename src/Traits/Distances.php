<?php


namespace KMLaravel\GeographicalCalculator\Traits;

use Exception;

trait Distances
{
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
                // init and calc sin and cos value
                $this
                    ->setSin($this->getAngle($point[0], $this->getPoints()[$index + 1][0], 'sin'))
                    ->setCos($this->getAngle($point[0], $this->getPoints()[$index + 1][0], 'cos'));

                $position = ($index + 1).'-'.($index + 2);

                $this->setLongitude($point[1])
                    ->setLongitude($this->getPoints()[$index + 1][1])
                    // save the results.
                    ->setResult(["$position" => $this->calcDistance()]);
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
}
