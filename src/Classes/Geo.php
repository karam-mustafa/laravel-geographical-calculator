<?php


namespace KMLaravel\GeographicalCalculator\Classes;

use Exception;
use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use KMLaravel\GeographicalCalculator\Traits\Areas;
use KMLaravel\GeographicalCalculator\Traits\Distances;

class Geo extends AbstractGeo implements GeoInterface
{
    use Areas, Distances;

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
     * check if user chose any units
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
     * @param  string  $unit
     * check if current units its available in units property or config file
     *
     * @return void
     * @throws \Exception
     * @author karam mustafa
     */
    private function checkIfUnitExists($unit)
    {
        if (!isset($this->getUnits()[$unit])) {
            throw new Exception("the unit ['$unit'] dose not available in units config");
        }
    }
}
