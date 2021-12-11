<?php


namespace KMLaravel\GeographicalCalculator\Interfaces;

interface GeoInterface
{
    /**
     *
     * @param  array  $point
     *
     * @author karam mustafa
     */
    function setPoint($point);

    /**
     * @desc get final distance between the given points
     * @author karam mustafa
     * @author karam mustafa
     */
    function getDistance();
}
