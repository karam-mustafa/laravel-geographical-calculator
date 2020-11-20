<?php


namespace KMLaravel\GeographicalCalculator\Interfaces;

interface GeographicalCalculatorInterface
{
    /**
     * @param $lat1
     * @param $lat2
     * @param $lon1
     * @param $lon2
     * @param array $options
     * @author karam mustafa
     */
    static function initCoordinates($lat1, $lat2, $lon1, $lon2, $options = []);

    /**
     * @desc get final length between the given points
     * @author karam mustafa
     * @author karam mustafa
     */
    function getLength();
}
