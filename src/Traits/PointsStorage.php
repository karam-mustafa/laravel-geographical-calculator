<?php

namespace KMLaravel\GeographicalCalculator\Traits;

trait PointsStorage
{
    /**
     * all the points to handle the selected requirement.
     *
     * @author karam mustafa
     *
     * @var array
     */
    public $points = [];

    /**
     * Main point that used to compare the closest points to the specific point.
     *
     * @author karam mustafa
     *
     * @var array
     */
    public $mainPoint = [];

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
     * @return PointsStorage
     *
     * @author karam mustaf
     */
    public function setPoint($point)
    {
        $this->points[] = $point;

        return $this;
    }

    /**
     * @return array
     *
     * @author karam mustaf
     */
    public function getMainPoint()
    {
        return $this->mainPoint;
    }

    /**
     * @param $point
     *
     * @return PointsStorage
     *
     * @author karam mustaf
     */
    public function setMainPoint($point)
    {
        $this->mainPoint = $point;

        return $this;
    }

    /**
     * @param  array  $points
     *
     * @return PointsStorage
     *
     * @author karam mustaf
     */
    public function setPoints($points)
    {
        $this->points = array_merge($this->points, $points);

        return $this;
    }

    /**
     * clear all stored points.
     *
     * @return PointsStorage
     *
     * @author karam mustaf
     */
    public function clearPoints()
    {
        $this->points = [];

        return $this;
    }
}
