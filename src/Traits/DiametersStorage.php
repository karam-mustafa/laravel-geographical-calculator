<?php

namespace KMLaravel\GeographicalCalculator\Traits;

trait DiametersStorage
{
    /**
     *
     *
     * @author karam mustafa
     *
     * @var array
     */
    public $diameter = [];

    /**
     * @return array
     * @author karam mustafa
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * @param  array  $diameter
     *
     * @return DiametersStorage
     * @author karam mustafa
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;

        return $this;
    }
}
