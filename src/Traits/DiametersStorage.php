<?php

namespace KMLaravel\GeographicalCalculator\Traits;

trait DiametersStorage
{
    /**
     * diameter in meter.
     *
     * @author karam mustafa
     *
     * @var int
     */
    public $diameter = 0;

    /**
     * @return int
     *
     * @author karam mustafa
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * diameter in kilo meter.
     *
     * @param int $diameter
     *
     * @return DiametersStorage
     *
     * @author karam mustafa
     */
    public function setDiameter($diameter = 0)
    {
        $this->diameter = $diameter;

        return $this;
    }
}
