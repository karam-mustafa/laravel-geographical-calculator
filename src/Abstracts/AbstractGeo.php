<?php


namespace KMLaravel\GeographicalCalculator\Abstracts;


/**
 * Class AbstractGeo
 *
 * @author karam mustafa
 * @package KMLaravel\GeographicalCalculator\Abstracts
 */
abstract class AbstractGeo
{
    /**
     *
     * @author karam mustafa
     * @var array
     */
    private $longs = [];
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
     * for develop and resolve any options
     *
     * @author karam mustafa
     * @var array
     */
    private $options;

    /**
     * @return float|int
     * @author karam mustaf
     */
    public function getSin()
    {
        return $this->sin;
    }

    /**
     * @param  float|int  $sin
     *
     * @return AbstractGeo
     * @author karam mustaf
     */
    public function setSin($sin)
    {
        $this->sin = $sin;

        return $this;
    }

    /**
     * @return float|int
     * @author karam mustaf
     */
    public function getCos()
    {
        return $this->cos;
    }

    /**
     * @param  float|int  $cos
     *
     * @return AbstractGeo
     * @author karam mustaf
     */
    public function setCos($cos)
    {
        $this->cos = $cos;
        return $this;
    }

    /**
     * @return mixed
     * @author karam mustaf
     */
    public function getLongs()
    {
        return $this->longs;
    }

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
     * @return AbstractGeo
     * @author karam mustaf
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

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
     * @return AbstractGeo
     * @author karam mustaf
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param  null  $index
     *
     * @return array
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
     * @return AbstractGeo
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
     * @return AbstractGeo
     * @author karam mustaf
     */
    public function setPoints($points)
    {
        $this->points = array_merge($this->points, $points);

        return $this;
    }

    /**
     * @param $val
     *
     * @return AbstractGeo
     * @author karam mustaf
     */
    public function setLongitude($val)
    {
        $this->longs[] = $val;

        return $this;
    }

    /**
     * get final Distances between the given points.
     *
     * @author karam mustafa
     */
    abstract public function getDistance();

    /**
     * get final Distances between the given points.
     *
     * @author karam mustafa
     */
    abstract public function getCenter();
}
