<?php

namespace KMLaravel\GeographicalCalculator\Abstracts;

/**
 * Class AbstractGeo.
 *
 * @author karam mustafa
 */
abstract class AbstractGeo
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
     * available units.
     *
     * @author karam mustafa
     *
     * @var array
     */
    private $units = [
        'mile' => 1,
        'km'   => 1.609344,
        'm'    => (1.609344 * 1000),
        'cm'   => (1.609344 * 100),
        'mm'   => (1.609344 * 1000 * 1000),
    ];
    /**
     * for develop and resolve any options.
     *
     * @author karam mustafa
     *
     * @var array
     */
    private $options;

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
     * @param array $units
     *
     * @return AbstractGeo
     *
     * @author karam mustaf
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

    /**
     * @param mixed $key
     *
     * @return array
     *
     * @author karam mustaf
     */
    public function getOptions($key = null)
    {
        return isset($this->options[$key])
            ? $this->options[$key]
            : $this->options;
    }

    /**
     * @param array $options
     *
     * @return AbstractGeo
     *
     * @author karam mustaf
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param null $index
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
     * @return AbstractGeo
     *
     * @author karam mustaf
     */
    public function setPoint($point)
    {
        $this->points[] = $point;

        return $this;
    }

    /**
     * @param array $points
     *
     * @return AbstractGeo
     *
     * @author karam mustaf
     */
    public function setPoints($points)
    {
        $this->points = array_merge($this->points, $points);

        return $this;
    }

    /**
     * @param mixed         $condition
     * @param null|callable $callback
     *
     * @return AbstractGeo
     *
     * @author karam mustaf
     */
    public function checkIf($condition, $callback = null)
    {
        if (isset($condition)) {
            if (isset($callback)) {
                return $callback();
            }
        }

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
