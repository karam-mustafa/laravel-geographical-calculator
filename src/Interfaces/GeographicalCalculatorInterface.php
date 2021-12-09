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
     function initCoordinates($lat1, $lat2, $lon1, $lon2, $options = []);

    /**
     * @desc get final distance between the given points
     * @author karam mustafa
     * @author karam mustafa
     */
    function getDistance();
}
